<?php

namespace App\Http\Controllers\Kakan;

use App\Http\Controllers\Controller;
use App\Models\Bap;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class KakanDashboardController extends Controller
{
    public function index()
    {
        // Kakan melihat:
        // 1. 'review_kakan' (Tugas Baru dari Kasi - Perlu Tanda Tangan)
        // 2. 'sk_terbit' (Arsip Selesai)
        $data = Bap::with('user')
                ->whereIn('status', ['review_kakan', 'sk_terbit'])
                ->orderBy('updated_at', 'desc')
                ->paginate(10);

        return view('kakan.dashboard', compact('data'));
    }

    /**
     * TAMPILKAN FORM PENGISIAN DRAFT SK (BARU)
     */
    public function formSk($id)
    {
        $bap = Bap::findOrFail($id);
        
        if ($bap->status != 'review_kakan') {
            return redirect()->route('kakan.dashboard')->with('error', 'Status berkas tidak valid untuk diproses.');
        }
        
        return view('kakan.form_sk', compact('bap'));
    }

    /**
     * 1. PREVIEW SK (Lihat Draft Sebelum TTD)
     */
    public function previewSk($id)
    {
        $bap = Bap::findOrFail($id);

        // Load view cetakan SK
        $pdf = Pdf::loadView('pdf.cetakan_sk', ['bap' => $bap])->setPaper('a4', 'portrait');

        // Tampilkan di browser tab baru (Stream)
        return $pdf->stream('DRAFT_SK_' . $bap->kode_booking . '.pdf');
    }

    /**
     * 2. TANDA TANGAN / TERBITKAN SK (Final)
     * Tangkap data dari Form, Generate PDF SK, Simpan, dan Ubah Status.
     */
    public function storeSk(Request $request, $id) // Menerima Request dari Form
    {
        // Validasi input form
        $request->validate([
            'nomor_sk'               => 'required|string',
            'alasan_sk'              => 'required|string',
            'nomor_paspor_lama'      => 'required|string',
            'kanim_penerbit_lama'    => 'required|string',
            'tgl_keluar_paspor_lama' => 'required|date',
            'tgl_habis_paspor_lama'  => 'required|date',
            'jabatan_ttd_sk'         => 'required|string',
            'nama_ttd_sk'            => 'required|string',
        ]);

        $bap = Bap::findOrFail($id);

        // Simpan data inputan SK ke database
        $bap->update([
            'nomor_sk'               => $request->nomor_sk,
            'alasan_sk'              => $request->alasan_sk,
            'nomor_paspor_lama'      => $request->nomor_paspor_lama,
            'kanim_penerbit_lama'    => $request->kanim_penerbit_lama,
            'tgl_keluar_paspor_lama' => $request->tgl_keluar_paspor_lama,
            'tgl_habis_paspor_lama'  => $request->tgl_habis_paspor_lama,
            'jabatan_ttd_sk'         => $request->jabatan_ttd_sk,
            'nama_ttd_sk'            => $request->nama_ttd_sk,
        ]);

        // Generate PDF dengan data yang sudah di-update
        $pdf = Pdf::loadView('pdf.cetakan_sk', ['bap' => $bap])->setPaper('a4', 'portrait');

        // Simpan File ke Storage Public (Gunakan time() agar tidak bentrok jika revisi)
        $filename = 'SK_' . $bap->kode_booking . '_' . time() . '.pdf';
        Storage::disk('public')->put('berkas/sk/' . $filename, $pdf->output());

        // Update Status -> FINAL (Selesai)
        $bap->update([
            'file_sk' => $filename,
            'status'  => 'sk_terbit'
        ]);

        // Redirect kembali ke dashboard kakan
        return redirect()->route('kakan.dashboard')->with('success', 'SK Kakanim Berhasil diterbitkan! Proses Permohonan SELESAI.');
    }

    /**
     * 3. BATAL / TARIK SK (Undo)
     * Menghapus SK yang sudah terbit dan mengembalikan status ke 'review_kakan'.
     */
    public function batalSk($id)
    {
        $bap = Bap::findOrFail($id);

        if($bap->status == 'sk_terbit'){
            // 1. Hapus file fisik SK lama agar tidak menumpuk
            if($bap->file_sk && Storage::disk('public')->exists('berkas/sk/' . $bap->file_sk)){
                Storage::disk('public')->delete('berkas/sk/' . $bap->file_sk);
            }

            // 2. Kembalikan status ke 'review_kakan' dan kosongkan kolom file_sk
            $bap->update([
                'status' => 'review_kakan',
                'file_sk' => null
            ]);
            
            return redirect()->back()->with('success', 'SK berhasil dibatalkan dan ditarik kembali ke meja Anda. Anda bisa memperbaiki ulang form SK-nya.');
        } 
        
        return redirect()->back()->with('error', 'Gagal membatalkan SK.');
    }
}