<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bap;
use App\Models\KuotaHarian;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * 1. DASHBOARD UTAMA
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Bap::with('user');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_pemohon', 'like', "%{$search}%")
                  ->orWhere('kode_booking', 'like', "%{$search}%");
            });
        }

        $data_bap = $query->orderBy('created_at', 'desc')
                          ->paginate(10)
                          ->withQueryString();

        return view('admin.dashboard', compact('data_bap'));
    }

    /**
     * 2. DETAIL & VALIDASI BERKAS
     */
    public function show($id)
    {
        $bap = Bap::with(['user', 'attachments'])->findOrFail($id); 
        return view('admin.detail_bap', compact('bap'));
    }

    /**
     * 3. PROSES KEPUTUSAN (TERIMA/TOLAK)
     */
    public function verifikasi(Request $request, $id)
    {
        $bap = Bap::findOrFail($id);

        if ($request->aksi == 'revisi') {
            $request->validate(['catatan' => 'required']);
            
            $bap->update([
                'status' => 'revisi_dokumen',
                'catatan_revisi' => $request->catatan
            ]);
            
            $pesan = 'Berkas dikembalikan ke User untuk direvisi.';
        } else {
            $bap->update([
                'status' => 'verifikasi_ok', 
                'catatan_revisi' => null
            ]);
            
            $pesan = 'Berkas Valid! Status diperbarui, siap untuk wawancara.';
        }

        return redirect()->route('admin.dashboard')->with('success', $pesan);
    }

    /**
     * 4. HALAMAN WAWANCARA
     */
    public function wawancara($id)
    {
        $bap = Bap::findOrFail($id);
        
        if (!in_array($bap->status, ['verifikasi_ok', 'proses_bap'])) {
             return redirect()->route('admin.dashboard')->with('error', 'Status berkas belum siap untuk wawancara.');
        }

        return view('admin.wawancara', compact('bap'));
    }

    /**
     * 5. GENERATE BAP (BERSIH DARI FORM LAMA)
     */
    public function generateBap(Request $request, $id)
    {
        // Validasi tanpa hasil_pemeriksaan dan pendapat_petugas
        $request->validate([
            'tempat_lahir'      => 'required|string',
            'tgl_lahir'         => 'required|date',
            'agama'             => 'required|string',
            'pendidikan'        => 'required|string',
            'pekerjaan'         => 'required|string',
            'alamat_lengkap'    => 'required|string',
            'nik_ktp'           => 'required|numeric',
            'tgl_keluar_ktp'    => 'required|date',
            'no_kk'             => 'required|numeric',
            'tgl_keluar_kk'     => 'required|date',
            'no_akta'           => 'required|string',
            'tgl_keluar_akta'   => 'required|date',
            'tanya_tambahan.*'  => 'nullable|string',
            'jawab_tambahan.*'  => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $id) {
            $bap = Bap::findOrFail($id);

            $data_tambahan = [];
            if ($request->has('tanya_tambahan')) {
                foreach ($request->tanya_tambahan as $key => $tanya) {
                    if (!empty($tanya)) {
                        $data_tambahan[] = [
                            'tanya' => $tanya,
                            'jawab' => $request->jawab_tambahan[$key] ?? '-' 
                        ];
                    }
                }
            }

            $bap->update([
                'tempat_lahir'      => $request->tempat_lahir,
                'tgl_lahir'         => $request->tgl_lahir,
                'pendidikan'        => $request->pendidikan,
                'pekerjaan'         => $request->pekerjaan,
                'agama'             => $request->agama,
                'alamat_lengkap'    => $request->alamat_lengkap,
                
                'nik_ktp'           => $request->nik_ktp,
                'tgl_keluar_ktp'    => $request->tgl_keluar_ktp,
                'no_kk'             => $request->no_kk,
                'tgl_keluar_kk'     => $request->tgl_keluar_kk,
                'no_akta'           => $request->no_akta,
                'tgl_keluar_akta'   => $request->tgl_keluar_akta,

                'nama_petugas'      => Auth::user()->name,
                'nip_petugas'       => Auth::user()->nip ?? '199504252017121001',
                'nama_kasubsi'      => 'DEDI MUHAEMIN', 
                'nip_kasubsi'       => '199802202022011001',
                
                'pertanyaan_tambahan' => count($data_tambahan) > 0 ? json_encode($data_tambahan) : null,
            ]);

            $pdf = Pdf::loadView('pdf.cetakan_bap', ['bap' => $bap])->setPaper('a4', 'portrait');
            $filename = 'BAK_' . $bap->kode_booking . '_' . time() . '.pdf';
            Storage::disk('public')->put('berkas/bap/' . $filename, $pdf->output());

            $bap->update([
                'file_bap' => $filename,
                'status' => 'review_kasubsi'
            ]);
        });

        return redirect()->route('admin.dashboard')->with('success', 'BAP Selesai! Berita Acara Klarifikasi berhasil dicetak dan diteruskan ke Kasubsi.');
    }

    /**
     * 6. FITUR BATAL / REVISI (TARIK KEMBALI)
     */
    public function batalBap($id)
    {
        $bap = Bap::findOrFail($id);

        if($bap->status == 'review_kasubsi') {
            if($bap->file_bap && Storage::disk('public')->exists('berkas/bap/' . $bap->file_bap)){
                Storage::disk('public')->delete('berkas/bap/' . $bap->file_bap);
            }

            $bap->update([
                'status' => 'verifikasi_ok', 
                'file_bap' => null,
            ]);

            return redirect()->back()->with('success', 'BAP ditarik kembali. Silakan revisi data wawancara.');
        }

        return redirect()->back()->with('error', 'Gagal menarik berkas. Status dokumen tidak valid untuk pembatalan.');
    }

    /**
     * 7. MANAJEMEN KUOTA HARIAN (INDEX)
     */
    public function indexKuota()
    {
        $kuotas = KuotaHarian::whereDate('tanggal', '>=', now())
                             ->orderBy('tanggal', 'asc')
                             ->get();
                             
        return view('admin.kuota_index', compact('kuotas'));
    }

    /**
     * 8. MANAJEMEN KUOTA HARIAN (STORE/UPDATE)
     */
    public function storeKuota(Request $request)
    {
        $request->validate([
            'tanggal'       => 'required|date|after_or_equal:today',
            'kuota_reguler' => 'required|integer|min:0',
            'kuota_lasles'  => 'required|integer|min:0'
        ]);

        KuotaHarian::updateOrCreate(
            ['tanggal' => $request->tanggal],
            [
                'kuota_reguler' => $request->kuota_reguler,
                'kuota_lasles'  => $request->kuota_lasles
            ]
        );

        return redirect()->back()->with('success', 'Kuota untuk tanggal ' . \Carbon\Carbon::parse($request->tanggal)->format('d M Y') . ' berhasil diupdate!');
    }

    /**
     * 9. MANAJEMEN KUOTA HARIAN (DELETE/RESET)
     */
    public function destroyKuota($id)
    {
        KuotaHarian::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Aturan kuota dihapus (Kembali ke Default).');
    }
}