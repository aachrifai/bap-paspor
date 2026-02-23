<?php

namespace App\Http\Controllers\Kasubsi;

use App\Http\Controllers\Controller;
use App\Models\Bap;
use Illuminate\Http\Request;

class KasubsiDashboardController extends Controller
{
    public function index()
    {
        // Kasubsi melihat data yang statusnya 'review_kasubsi' (Tugas Baru)
        // Atau 'proses_bapen' (Yang sudah dia kerjakan/history)
        $data = Bap::with('user')
                ->whereIn('status', ['review_kasubsi', 'proses_bapen', 'review_kakan', 'sk_terbit'])
                ->orderBy('updated_at', 'desc')
                ->paginate(10);

        return view('kasubsi.dashboard', compact('data'));
    }

    // Fungsi untuk menyetujui (ACC)
    public function approve($id)
    {
        $bap = Bap::findOrFail($id);

        // Ubah status jadi 'proses_bapen' (Lanjut ke tahap berikutnya)
        $bap->update([
            'status' => 'proses_bapen'
        ]);

        return redirect()->back()->with('success', 'Berkas berhasil disetujui! Lanjut ke BAPEN.');
    }

    // Fungsi untuk membatalkan ACC (Undo/Tarik Kembali)
    // INI YANG TADI ERROR KARENA BELUM ADA
    public function batalAcc($id)
    {
        $bap = Bap::findOrFail($id);

        // Cek dulu: Hanya bisa dibatalkan jika statusnya masih 'proses_bapen'
        if($bap->status == 'proses_bapen'){
            $bap->update([
                'status' => 'review_kasubsi' // Kembalikan status ke diri sendiri
            ]);
            return redirect()->back()->with('success', 'Status ACC berhasil dibatalkan! Berkas kembali ke antrian Anda.');
        } 
        
        return redirect()->back()->with('error', 'Gagal! Berkas sudah diproses oleh Kasi, tidak bisa ditarik kembali.');
    }
}