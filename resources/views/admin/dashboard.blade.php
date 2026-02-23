<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-user-shield text-indigo-600 mr-2"></i> {{ __('Dashboard Petugas (Admin)') }}
            </h2>

            <div class="flex items-center gap-3">
                <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded border border-indigo-400">
                    {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                </span>
                <a href="{{ route('admin.kuota.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-indigo-200 rounded-lg font-bold text-xs text-indigo-700 uppercase tracking-widest shadow-sm hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-calendar-alt mr-2"></i> Atur Kuota
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({ title: 'Berhasil!', text: "{{ session('success') }}", icon: 'success', confirmButtonColor: '#4f46e5', timer: 3000 });
                });
            </script>
            @endif

            @if(session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({ title: 'Gagal!', text: "{{ session('error') }}", icon: 'error', confirmButtonColor: '#d33' });
                });
            </script>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-semibold uppercase">Total Permohonan</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $data_bap->total() }}</h3>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                        <i class="fas fa-folder-open text-2xl"></i>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-500 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-semibold uppercase">Menunggu Validasi</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ \App\Models\Bap::where('status', 'pending')->count() }}</h3>
                    </div>
                    <div class="p-3 bg-yellow-100 rounded-full text-yellow-600">
                        <i class="fas fa-clock text-2xl"></i>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-semibold uppercase">Selesai (SK Terbit)</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ \App\Models\Bap::where('status', 'sk_terbit')->count() }}</h3>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full text-green-600">
                        <i class="fas fa-check-circle text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                        <h3 class="text-lg font-bold text-gray-800">
                            <i class="fas fa-list-alt mr-2 text-indigo-600"></i> Daftar Antrian BAP
                        </h3>
                        
                        <form method="GET" action="{{ url()->current() }}" class="relative w-full md:w-72">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Cari Kode / Nama..." 
                                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm transition">
                            
                            <button type="submit" class="absolute left-3 top-2.5 text-gray-400 hover:text-indigo-600 transition">
                                <i class="fas fa-search text-xs"></i>
                            </button>
                        </form>
                    </div>

                    @if(request('search'))
                        <div class="mb-4 p-3 bg-blue-50 text-blue-700 rounded-lg flex justify-between items-center border border-blue-100">
                            <span class="text-sm">
                                <i class="fas fa-search mr-2"></i> 
                                Menampilkan hasil untuk: <strong>"{{ request('search') }}"</strong>
                            </span>
                            <a href="{{ url()->current() }}" class="text-red-500 hover:text-red-700 font-bold text-xs uppercase tracking-wider flex items-center transition">
                                <i class="fas fa-times-circle mr-1"></i> Reset
                            </a>
                        </div>
                    @endif

                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tgl Masuk</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Data Pemohon</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Layanan</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($data_bap as $item)
                                <tr class="hover:bg-indigo-50 transition duration-150">
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-700">
                                            {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('H:i') }} WIB
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $item->nama_pemohon }}</div>
                                        <div class="text-xs text-indigo-600 font-mono bg-indigo-50 px-2 py-0.5 rounded inline-block mt-1">
                                            {{ $item->kode_booking }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <div class="text-xs font-semibold text-gray-700 uppercase">{{ $item->jenis_layanan }}</div>
                                        <span class="text-[10px] text-gray-500 capitalize bg-gray-100 px-2 py-0.5 rounded-full mt-1 inline-block border border-gray-200">
                                            {{ str_replace('_', ' ', $item->kategori) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $statusClass = match($item->status) {
                                                'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                'revisi_dokumen' => 'bg-red-100 text-red-800 border-red-200',
                                                'verifikasi_ok', 'proses_bap', 'review_kasubsi', 'proses_bapen', 'review_kakan' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                'sk_terbit', 'selesai' => 'bg-green-100 text-green-800 border-green-200',
                                                default => 'bg-gray-100 text-gray-800 border-gray-200'
                                            };
                                            
                                            $statusLabel = match($item->status) {
                                                'pending' => 'BARU',
                                                'revisi_dokumen' => 'REVISI',
                                                'verifikasi_ok' => 'SIAP BAP',
                                                'proses_bap' => 'WAWANCARA',
                                                'review_kasubsi' => 'CEK KASUBSI',
                                                'review_kakan' => 'CEK KAKANIM',
                                                'sk_terbit' => 'SELESAI',
                                                default => strtoupper(str_replace('_', ' ', $item->status))
                                            };
                                        @endphp
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-bold rounded-full border {{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @if($item->status == 'pending' || $item->status == 'revisi_dokumen')
                                            <a href="{{ route('admin.bap.show', $item->id) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded shadow transition transform hover:-translate-y-0.5">
                                                <i class="fas fa-search mr-1"></i> Periksa
                                            </a>

                                        @elseif($item->status == 'verifikasi_ok') 
                                            <a href="{{ route('admin.bap.wawancara', $item->id) }}" class="inline-flex items-center px-3 py-1.5 bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold rounded shadow transition transform hover:-translate-y-0.5">
                                                <i class="fas fa-microphone-alt mr-1"></i> BAP
                                            </a>

                                        @elseif(in_array($item->status, ['review_kasubsi', 'proses_bapen', 'review_kakan']))
                                            <div class="flex flex-col items-center gap-2">
                                                @if($item->file_bap)
                                                    <a href="{{ asset('storage/berkas/bap/' . $item->file_bap) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded shadow transition transform hover:-translate-y-0.5">
                                                        <i class="fas fa-file-pdf mr-1"></i> Cek PDF BAP
                                                    </a>
                                                @endif

                                                <span class="text-[10px] text-orange-600 font-bold border border-orange-200 bg-orange-50 px-2 py-1 rounded">
                                                    <i class="fas fa-user-tie mr-1"></i> Proses Pejabat
                                                </span>
                                                
                                                <form id="form-batal-{{ $item->id }}" action="{{ route('admin.bap.batal', $item->id) }}" method="POST">
                                                    @csrf
                                                    <button type="button" onclick="konfirmasiBatal('{{ $item->id }}')" class="text-xs text-gray-400 hover:text-red-500 underline transition">
                                                        Tarik / Batalkan
                                                    </button>
                                                </form>
                                            </div>

                                        @elseif($item->status == 'sk_terbit' && $item->file_sk)
                                            <div class="flex flex-col items-center gap-1">
                                                <a href="{{ asset('storage/berkas/sk/' . $item->file_sk) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded shadow transition transform hover:-translate-y-0.5">
                                                    <i class="fas fa-file-pdf mr-1"></i> Unduh SK
                                                </a>
                                                <span class="text-[10px] text-gray-400 font-medium">Selesai</span>
                                            </div>

                                        @else
                                            <span class="text-xs text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-folder-open text-4xl mb-3 text-gray-300"></i>
                                            <p class="text-base font-medium">Data tidak ditemukan.</p>
                                            <p class="text-sm text-gray-400">Belum ada permohonan atau hasil pencarian nihil.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $data_bap->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function konfirmasiBatal(id) {
            Swal.fire({
                title: 'Tarik Kembali Berkas?',
                text: "Berkas akan dikembalikan ke status Revisi/Awal. Proses pejabat akan dibatalkan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Tarik!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-batal-' + id).submit();
                }
            })
        }
    </script>
</x-app-layout>