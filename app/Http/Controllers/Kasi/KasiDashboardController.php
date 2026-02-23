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
    public function storeBapen($id)
    {
        $bap = Bap::findOrFail($id);

        // Generate PDF
        $pdf = Pdf::loadView('pdf.cetakan_bapen', ['bap' => $bap])->setPaper('a4', 'portrait');

        // Simpan File ke Storage Public
        $filename = 'BAPEN_' . $bap->kode_booking . '.pdf';
        Storage::disk('public')->put('berkas/bapen/' . $filename, $pdf->output());

        // Update Status -> Kirim ke Kakan
        $bap->update([
            'file_bapen' => $filename,
            'status' => 'review_kakan' 
        ]);

        return redirect()->back()->with('success', 'BAPEN Berhasil diterbitkan! Berkas diteruskan ke Kepala Kantor.');
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
            $bap->update([
                'status' => 'proses_bapen' // Kembalikan status ke diri sendiri (Kasi)
            ]);
            return redirect()->back()->with('success', 'BAPEN ditarik kembali! Berkas kembali ke antrian Anda.');
        } 
        
        // Jika status sudah berubah (misal sudah SK Terbit), tolak.
        return redirect()->back()->with('error', 'Gagal! Berkas sudah diproses oleh Kepala Kantor, tidak bisa ditarik.');
    }
}