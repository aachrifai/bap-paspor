<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bap;
use App\Models\BapAttachment;
use App\Models\KuotaHarian; 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserDashboardController extends Controller
{
    /**
     * 1. MENAMPILKAN HALAMAN RIWAYAT (DASHBOARD)
     */
    public function index()
    {
        $data = Bap::where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('user.dashboard', compact('data'));
    }

    /**
     * 2. MENAMPILKAN HALAMAN FORM PENDAFTARAN
     */
    public function create()
    {
        return view('user.bap_create');
    }

    /**
     * 3. PROSES SIMPAN DATA BARU (DENGAN CEK KUOTA SPESIFIK LAYANAN)
     */
    public function store(Request $request)
    {
        // PESAN ERROR CUSTOM BAHASA INDONESIA
        $messages = [
            'required' => 'Kolom :attribute wajib diisi.',
            'numeric'  => 'Kolom :attribute harus berupa angka.',
            'tanggal_booking.after_or_equal' => 'Tanggal kedatangan minimal adalah hari ini.',
            'files.*.mimes' => 'File lampiran pendukung harus berformat: JPG, JPEG, PNG, atau PDF.',
            'files.*.max'   => 'Ukuran maksimal tiap file lampiran adalah 5MB.',
            'file_ktp.mimes' => 'File KTP harus berformat: JPG, JPEG, PNG, atau PDF.',
            'file_ktp.max'   => 'Ukuran maksimal file KTP adalah 5MB.',
        ];

        // 1. Validasi Input (dengan pesan custom)
        $request->validate([
            'no_wa'             => 'required|numeric',
            'jenis_layanan'     => 'required|in:reguler,lasles',
            'kategori'          => 'required',
            'kronologi_singkat' => 'required|string',
            'tanggal_booking'   => 'required|date|after_or_equal:today', 
            'files.*'           => 'nullable|mimes:jpg,jpeg,png,pdf|max:5120', 
            'file_ktp'          => 'nullable|mimes:jpg,jpeg,png,pdf|max:5120',
        ], $messages);

        // 2. --- LOGIKA CEK KUOTA DINAMIS ---
        $cek_kuota_khusus = KuotaHarian::whereDate('tanggal', $request->tanggal_booking)->first();

        // Tentukan batas kuota berdasarkan jenis layanan yang dipilih
        if ($request->jenis_layanan == 'reguler') {
            $batas_kuota = $cek_kuota_khusus ? $cek_kuota_khusus->kuota_reguler : 3;
        } else {
            $batas_kuota = $cek_kuota_khusus ? $cek_kuota_khusus->kuota_lasles : 2;
        }

        // Hitung jumlah antrian HANYA untuk layanan yang sama di tanggal tersebut
        $jumlah_booking = Bap::whereDate('tanggal_booking', $request->tanggal_booking)
                             ->where('jenis_layanan', $request->jenis_layanan)
                             ->count();

        // Tolak jika penuh
        if ($jumlah_booking >= $batas_kuota) {
            return redirect()->back()
                ->withInput() 
                ->with('error', 'Mohon maaf, Kuota ' . strtoupper($request->jenis_layanan) . ' untuk tanggal ' . date('d-m-Y', strtotime($request->tanggal_booking)) . ' sudah penuh (Maksimal ' . $batas_kuota . ' slot). Silakan pilih tanggal lain.');
        }

        // 3. Generate Kode Booking
        $kode_booking = 'BAP-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        // 4. Simpan Data
        $bap = Bap::create([
            'user_id'           => Auth::id(),
            'nama_pemohon'      => Auth::user()->name,
            'kode_booking'      => $kode_booking,
            'no_wa'             => $request->no_wa,
            'jenis_layanan'     => $request->jenis_layanan,
            'kategori'          => $request->kategori,
            'kronologi_singkat' => $request->kronologi_singkat,
            'tanggal_booking'   => $request->tanggal_booking,
            'status'            => 'pending',
        ]);

        // 5. Upload File
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('lampiran_bap', 'public');
                BapAttachment::create([
                    'bap_id'     => $bap->id,
                    'jenis_file' => 'Lampiran Pendukung',
                    'path_file'  => $path
                ]);
            }
        } 
        
        if ($request->hasFile('file_ktp')) {
             $path = $request->file('file_ktp')->store('lampiran_bap', 'public');
             BapAttachment::create([
                'bap_id'     => $bap->id,
                'jenis_file' => 'KTP', 
                'path_file'  => $path
            ]);
        }

        return redirect()->route('user.dashboard')->with('success', 'Permohonan berhasil dikirim! Kode Booking Anda: ' . $kode_booking);
    }

    /**
     * 4. MENAMPILKAN HALAMAN EDIT (REVISI)
     */
    public function edit($id)
    {
        $bap = Bap::where('user_id', Auth::id())->findOrFail($id);

        if ($bap->status != 'revisi_dokumen' && $bap->status != 'pending') {
            return redirect()->route('user.dashboard')->with('error', 'Permohonan sedang diproses dan tidak dapat diedit.');
        }

        return view('user.bap_edit', compact('bap'));
    }

    /**
     * 5. PROSES UPDATE (DENGAN CEK KUOTA SPESIFIK LAYANAN)
     */
    public function update(Request $request, $id)
    {
        $bap = Bap::where('user_id', Auth::id())->findOrFail($id);

        // PESAN ERROR CUSTOM BAHASA INDONESIA
        $messages = [
            'required' => 'Kolom :attribute wajib diisi.',
            'numeric'  => 'Kolom :attribute harus berupa angka.',
            'tanggal_booking.after_or_equal' => 'Tanggal kedatangan minimal adalah hari ini.',
            'files.*.mimes' => 'File lampiran pendukung harus berformat: JPG, JPEG, PNG, atau PDF.',
            'files.*.max'   => 'Ukuran maksimal tiap file lampiran adalah 5MB.',
            'file_ktp.mimes' => 'File KTP harus berformat: JPG, JPEG, PNG, atau PDF.',
            'file_ktp.max'   => 'Ukuran maksimal file KTP adalah 5MB.',
        ];

        $request->validate([
            'no_wa'             => 'required|numeric',
            'jenis_layanan'     => 'required|in:reguler,lasles',
            'kategori'          => 'required',
            'kronologi_singkat' => 'required|string',
            'tanggal_booking'   => 'nullable|date|after_or_equal:today', 
            'files.*'           => 'nullable|mimes:jpg,jpeg,png,pdf|max:5120', 
            'file_ktp'          => 'nullable|mimes:jpg,jpeg,png,pdf|max:5120',
        ], $messages);

        // Cek Kuota (Hanya jika tanggal diganti ATAU jenis layanan diganti)
        if (
            ($request->filled('tanggal_booking') && $request->tanggal_booking != $bap->tanggal_booking) ||
            ($request->jenis_layanan != $bap->jenis_layanan)
        ) {
            $tgl_cek = $request->filled('tanggal_booking') ? $request->tanggal_booking : $bap->tanggal_booking;
            
            $cek_kuota_khusus = KuotaHarian::whereDate('tanggal', $tgl_cek)->first();
            
            if ($request->jenis_layanan == 'reguler') {
                $batas_kuota = $cek_kuota_khusus ? $cek_kuota_khusus->kuota_reguler : 3;
            } else {
                $batas_kuota = $cek_kuota_khusus ? $cek_kuota_khusus->kuota_lasles : 2;
            }

            $jumlah_booking = Bap::whereDate('tanggal_booking', $tgl_cek)
                                 ->where('jenis_layanan', $request->jenis_layanan)
                                 ->count();

            if ($jumlah_booking >= $batas_kuota) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal update! Kuota ' . strtoupper($request->jenis_layanan) . ' untuk tanggal ' . date('d-m-Y', strtotime($tgl_cek)) . ' penuh (Maksimal ' . $batas_kuota . ').');
            }
            
            if($request->filled('tanggal_booking')) {
                $bap->tanggal_booking = $request->tanggal_booking;
            }
        }

        // Update Data
        $bap->no_wa             = $request->no_wa;
        $bap->jenis_layanan     = $request->jenis_layanan;
        $bap->kategori          = $request->kategori;
        $bap->kronologi_singkat = $request->kronologi_singkat;
        $bap->status            = 'pending'; 
        $bap->save(); 

        // Upload File Tambahan
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('lampiran_bap', 'public');
                BapAttachment::create([
                    'bap_id'     => $bap->id,
                    'jenis_file' => 'Lampiran Tambahan (Revisi)',
                    'path_file'  => $path
                ]);
            }
        }
        
        if ($request->hasFile('file_ktp')) {
             $path = $request->file('file_ktp')->store('lampiran_bap', 'public');
             BapAttachment::create([
                'bap_id'     => $bap->id,
                'jenis_file' => 'KTP (Revisi)',
                'path_file'  => $path
            ]);
        }

        return redirect()->route('user.dashboard')->with('success', 'Data perbaikan berhasil dikirim ulang ke Petugas.');
    }

    /**
     * 6. AJAX CEK KUOTA (UNTUK JAVASCRIPT/ALERT) - UPDATE CEK LAYANAN
     */
    public function checkKuota(Request $request)
    {
        $tanggal = $request->query('date');
        $layanan = $request->query('layanan'); // Menerima parameter layanan
        
        if (!$tanggal || !$layanan) {
            return response()->json(['status' => 'error', 'message' => 'Lengkapi data layanan & tanggal']);
        }

        $cek_kuota_khusus = KuotaHarian::whereDate('tanggal', $tanggal)->first();
        
        if ($layanan == 'reguler') {
            $batas_kuota = $cek_kuota_khusus ? $cek_kuota_khusus->kuota_reguler : 3;
        } else {
            $batas_kuota = $cek_kuota_khusus ? $cek_kuota_khusus->kuota_lasles : 2;
        }

        $terisi = Bap::whereDate('tanggal_booking', $tanggal)->where('jenis_layanan', $layanan)->count();
        $sisa = $batas_kuota - $terisi;

        if ($terisi >= $batas_kuota) {
            return response()->json([
                'status' => 'full', 
                'message' => 'Kuota ' . strtoupper($layanan) . ' Penuh! (0 dari ' . $batas_kuota . ' slot)',
                'sisa' => 0
            ]);
        }

        return response()->json([
            'status' => 'available', 
            'message' => 'Tersedia (Sisa ' . $sisa . ' dari ' . $batas_kuota . ' slot ' . strtoupper($layanan) . ')',
            'sisa' => $sisa
        ]);
    }

    /**
     * 7. MENAMPILKAN DETAIL DATA (UNTUK USER CEK DATA)
     */
    public function show($id)
    {
        $bap = Bap::where('user_id', Auth::id())->findOrFail($id);
        return view('user.bap_show', compact('bap'));
    }
}