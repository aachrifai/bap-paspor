<?php

namespace App\Http\Controllers\Kasi;

use App\Http\Controllers\Controller;
use App\Models\Bap;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class KasiDashboardController extends Controller
{
    public function index()
    {
        // Kasi melihat yang statusnya:
        // 1. 'proses_bapen' (Tugas Baru dari Kasubsi)
        // 2. 'review_kakan' (Yang sudah dikerjakan/dikirim ke Kakan)
        // 3. 'sk_terbit' (Selesai)
        $data = Bap::with('user')
                ->whereIn('status', ['proses_bapen', 'review_kakan', 'sk_terbit'])
                ->orderBy('updated_at', 'desc')
                ->paginate(10);

        return view('kasi.dashboard', compact('data'));
    }

    /**
     * TAMPILKAN FORM PENGISIAN BAPEN (TAMBAHAN UNTUK LOAD VIEW FORM)
     */
    public function formBapen($id)
    {
        $bap = Bap::findOrFail($id);

        if ($bap->status != 'proses_bapen') {
            return redirect()->route('kasi.dashboard')->with('error', 'Status berkas belum siap untuk diproses.');
        }

        return view('kasi.form_bapen', compact('bap'));
    }

    /**
     * 1. PREVIEW PDF (Lihat Draft Sebelum Terbit)
     * Hanya menampilkan di browser, tidak menyimpan ke database/storage.
     */
    public function previewBapen($id)
    {
        $bap = Bap::findOrFail($id);
        
        // Load view cetakan
        $pdf = Pdf::loadView('pdf.cetakan_bapen', ['bap' => $bap])->setPaper('a4', 'portrait');
        
        // stream() = Tampilkan di browser tab baru
        return $pdf->stream('PREVIEW_BAPEN_' . $bap->kode_booking . '.pdf');
    }

    /**
     * 2. TERBITKAN BAPEN (Final)
     * Generate PDF, Simpan ke Storage, dan Oper ke Kakan.
     */
    public function storeBapen(Request $request, $id) // Tambahkan Request $request
    {
        $bap = Bap::findOrFail($id);

        // === LOGIKA SIMPAN POIN-POIN DINAMIS ===
        $pendapat_kasi = [];
        $utamas = $request->input('pendapat_utama', []);
        $subs   = $request->input('pendapat_sub', []);

        foreach ($utamas as $index => $teks_utama) {
            if (!empty($teks_utama)) {
                $sub_items = [];
                
                // Cek apakah poin ini memiliki anak poin (a,b,c)
                if (isset($subs[$index]) && is_array($subs[$index])) {
                    foreach ($subs[$index] as $sub_teks) {
                        if (!empty($sub_teks)) {
                            $sub_items[] = $sub_teks;
                        }
                    }
                }

                $pendapat_kasi[] = [
                    'utama' => $teks_utama,
                    'sub'   => $sub_items
                ];
            }
        }

        // Simpan data pendapat ke tabel database
        $bap->update([
            'pendapat_kasi' => json_encode($pendapat_kasi)
        ]);
        // ========================================

        // Generate PDF
        $pdf = Pdf::loadView('pdf.cetakan_bapen', ['bap' => $bap])->setPaper('a4', 'portrait');

        // Simpan File ke Storage Public (Ditambahkan time() agar tidak tertimpa cache file lama jika diedit)
        $filename = 'BAPEN_' . $bap->kode_booking . '_' . time() . '.pdf';
        Storage::disk('public')->put('berkas/bapen/' . $filename, $pdf->output());

        // Update Status -> Kirim ke Kakan
        $bap->update([
            'file_bapen' => $filename,
            'status' => 'review_kakan' 
        ]);

        return redirect()->route('kasi.dashboard')->with('success', 'BAPEN Berhasil diterbitkan! Berkas diteruskan ke Kepala Kantor.');
    }

    /**
     * 3. BATAL / TARIK KEMBALI (Fitur Undo)
     * Menarik berkas dari meja Kakan kembali ke meja Kasi.
     */
    public function batalBapen($id)
    {
        $bap = Bap::findOrFail($id);

        // Hanya bisa ditarik jika statusnya masih 'review_kakan' (Belum disentuh Kakan)
        if($bap->status == 'review_kakan'){
            
            // Hapus file fisik PDF lama agar tidak memenuhi storage
            if($bap->file_bapen && Storage::disk('public')->exists('berkas/bapen/' . $bap->file_bapen)){
                Storage::disk('public')->delete('berkas/bapen/' . $bap->file_bapen);
            }

            $bap->update([
                'status' => 'proses_bapen', // Kembalikan status ke diri sendiri (Kasi)
                'file_bapen' => null
            ]);
            return redirect()->back()->with('success', 'BAPEN ditarik kembali! Berkas kembali ke antrian Anda.');
        } 
        
        // Jika status sudah berubah (misal sudah SK Terbit), tolak.
        return redirect()->back()->with('error', 'Gagal! Berkas sudah diproses oleh Kepala Kantor, tidak bisa ditarik.');
    }
}