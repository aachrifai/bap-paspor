<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-user-tie text-green-600 mr-2"></i> {{ __('Dashboard Kasubsi') }}
            </h2>
            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-400">
                {{ date('d M Y') }}
            </span>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: "{{ session('success') }}",
                        icon: 'success',
                        confirmButtonColor: '#16a34a',
                        timer: 3000
                    });
                });
            </script>
            @endif

            @if(session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Gagal!',
                        text: "{{ session('error') }}",
                        icon: 'error',
                        confirmButtonColor: '#d33'
                    });
                });
            </script>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-orange-400 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-semibold uppercase">Menunggu Persetujuan</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $data->where('status', 'review_kasubsi')->count() }}</h3>
                    </div>
                    <div class="p-3 bg-orange-100 rounded-full text-orange-500">
                        <i class="fas fa-clock text-2xl"></i>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-semibold uppercase">Telah Disetujui</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $data->where('status', '!=', 'review_kasubsi')->count() }}</h3>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full text-green-600">
                        <i class="fas fa-check-double text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-800">
                            <i class="fas fa-list-alt mr-2"></i> Daftar Antrian Approval
                        </h3>
                        <span class="text-xs text-gray-400">Menampilkan 10 data terbaru</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-lg">Tgl Masuk</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Data Pemohon</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Dokumen BAP</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-lg">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($data as $item)
                                <tr class="hover:bg-blue-50 transition duration-150 ease-in-out">
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-700">
                                            {{ $item->updated_at->format('d M Y') }}
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            Pukul {{ $item->updated_at->format('H:i') }} WIB
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $item->nama_pemohon }}</div>
                                        <div class="text-xs text-gray-500 font-mono bg-gray-100 px-2 py-0.5 rounded inline-block mt-1">
                                            {{ $item->kode_booking }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @if($item->file_bap)
                                            <a href="{{ asset('storage/berkas/bap/' . $item->file_bap) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 border border-red-200 text-xs font-medium rounded text-red-700 bg-red-50 hover:bg-red-100 transition">
                                                <i class="fas fa-file-pdf mr-1"></i> Lihat BAP
                                            </a>
                                        @else
                                            <span class="text-gray-400 text-xs italic">Belum tersedia</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @if($item->status == 'review_kasubsi')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-orange-100 text-orange-800">
                                                MENUNGGU ACC
                                            </span>
                                        @elseif($item->status == 'proses_bapen')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-blue-100 text-blue-800">
                                                SUDAH DI-ACC
                                            </span>
                                        @elseif($item->status == 'sk_terbit')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800">
                                                SK TERBIT
                                            </span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-gray-100 text-gray-800">
                                                {{ strtoupper(str_replace('_', ' ', $item->status)) }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @if($item->status == 'review_kasubsi')
                                            <form action="{{ route('kasubsi.approve', $item->id) }}" method="POST" class="form-approve">
                                                @csrf
                                                <button type="button" onclick="konfirmasiAcc(this)" style="background-color: #16a34a; color: white;" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md font-bold text-xs uppercase tracking-widest hover:opacity-90 transition shadow-md">
                                                    <i class="fas fa-check mr-2"></i> SETUJUI
                                                </button>
                                            </form>

                                        @elseif($item->status == 'proses_bapen')
                                            <div class="flex flex-col items-center gap-1">
                                                <span class="text-xs text-orange-500 italic mb-1 font-semibold">
                                                    <i class="fas fa-clock mr-1"></i> Menunggu Kasi
                                                </span>
                                                <form action="{{ route('kasubsi.batal', $item->id) }}" method="POST">
                                                    @csrf
                                                    <button type="button" onclick="konfirmasiBatal(this)" class="text-red-400 hover:text-red-600 text-xs font-medium underline decoration-red-300 hover:decoration-red-600 transition">
                                                        <i class="fas fa-undo-alt mr-1"></i> Batal / Tarik
                                                    </button>
                                                </form>
                                            </div>

                                        @elseif($item->status == 'sk_terbit' && $item->file_sk)
                                            <div class="flex flex-col items-center">
                                                <a href="{{ asset('storage/berkas/sk/' . $item->file_sk) }}" target="_blank" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md font-bold text-xs uppercase text-white bg-green-600 hover:bg-green-700 shadow-md transition transform hover:-translate-y-0.5">
                                                    <i class="fas fa-file-pdf mr-2 text-lg"></i> LIHAT SK
                                                </a>
                                                <span class="text-[10px] text-gray-400 mt-1">Selesai</span>
                                            </div>

                                        @else
                                            <span class="text-gray-400 text-xs font-medium bg-gray-100 px-2 py-1 rounded cursor-not-allowed">
                                                <i class="fas fa-lock mr-1"></i> Terkunci
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-500">
                                            <i class="fas fa-clipboard-check text-5xl mb-4 text-gray-300"></i>
                                            <p class="text-lg font-semibold">Semua bersih!</p>
                                            <p class="text-sm">Tidak ada berkas yang perlu persetujuan saat ini.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $data->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // 1. Alert untuk Setujui
        function konfirmasiAcc(button) {
            Swal.fire({
                title: 'Setujui Berkas?',
                text: "Pastikan dokumen BAP sudah sesuai.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#16a34a',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Setujui!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            })
        }

        // 2. Alert untuk Batal/Tarik
        function konfirmasiBatal(button) {
            Swal.fire({
                title: 'Tarik Kembali Persetujuan?',
                text: "Status berkas akan dikembalikan menjadi 'Menunggu ACC'.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Tarik!',
                cancelButtonText: 'Jangan'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            })
        }
    </script>
</x-app-layout>