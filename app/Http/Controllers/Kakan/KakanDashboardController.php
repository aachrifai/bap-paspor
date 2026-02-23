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
     * Generate PDF SK, Simpan, dan Ubah Status jadi Selesai.
     */
    public function storeSk($id)
    {
        $bap = Bap::findOrFail($id);

        // Generate PDF
        $pdf = Pdf::loadView('pdf.cetakan_sk', ['bap' => $bap])->setPaper('a4', 'portrait');

        // Simpan File ke Storage Public
        $filename = 'SK_' . $bap->kode_booking . '.pdf';
        Storage::disk('public')->put('berkas/sk/' . $filename, $pdf->output());

        // Update Status -> FINAL (Selesai)
        $bap->update([
            'file_sk' => $filename,
            'status' => 'sk_terbit'
        ]);

        return redirect()->back()->with('success', 'SK Berhasil diterbitkan! Proses Permohonan SELESAI.');
    }

    /**
     * 3. BATAL / TARIK SK (Undo)
     * Menghapus SK yang sudah terbit dan mengembalikan status ke 'review_kakan'.
     */
    public function batalSk($id)
    {
        $bap = Bap::findOrFail($id);

        if($bap->status == 'sk_terbit'){
            // 1. Hapus file fisik SK lama agar tidak menumpuk (Opsional tapi rapi)
            if($bap->file_sk && Storage::disk('public')->exists('berkas/sk/' . $bap->file_sk)){
                Storage::disk('public')->delete('berkas/sk/' . $bap->file_sk);
            }

            // 2. Kembalikan status ke 'review_kakan' dan kosongkan kolom file_sk
            $bap->update([
                'status' => 'review_kakan',
                'file_sk' => null
            ]);
            
            return redirect()->back()->with('success', 'SK berhasil dibatalkan dan ditarik kembali ke meja Anda.');
        } 
        
        return redirect()->back()->with('error', 'Gagal membatalkan.');
    }
}