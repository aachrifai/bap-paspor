<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-briefcase text-purple-600 mr-2"></i> {{ __('Dashboard Kasi') }}
            </h2>
            <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded border border-purple-400">
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
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-semibold uppercase">Perlu BAPEN</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $data->where('status', 'proses_bapen')->count() }}</h3>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                        <i class="fas fa-file-signature text-2xl"></i>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-orange-400 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-semibold uppercase">Menunggu Kakanim</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $data->where('status', '!=', 'proses_bapen')->count() }}</h3>
                    </div>
                    <div class="p-3 bg-orange-100 rounded-full text-orange-500">
                        <i class="fas fa-user-clock text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-800">
                            <i class="fas fa-gavel mr-2"></i> Penerbitan BAPEN (Kasi)
                        </h3>
                        <span class="text-xs text-gray-400">Menampilkan data terbaru</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-lg">Tgl Masuk</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Data Pemohon</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Dokumen BAPEN</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-lg">Aksi / SK Final</th>
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
                                        @if($item->file_bapen)
                                            <a href="{{ asset('storage/berkas/bapen/' . $item->file_bapen) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 border border-blue-200 text-xs font-medium rounded text-blue-700 bg-blue-50 hover:bg-blue-100 transition">
                                                <i class="fas fa-file-pdf mr-1"></i> Lihat BAPEN
                                            </a>
                                        @else
                                            <span class="text-gray-400 text-xs italic">Belum diterbitkan</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @if($item->status == 'proses_bapen')
                                            <span class="text-xs font-bold text-orange-600 bg-orange-100 px-2 py-1 rounded-full">
                                                MENUNGGU PROSES
                                            </span>
                                        @elseif($item->status == 'review_kakan')
                                            <span class="text-xs font-bold text-orange-600 bg-orange-100 px-2 py-1 rounded-full">
                                                MENUNGGU KAKANIM
                                            </span>
                                        @elseif($item->status == 'sk_terbit')
                                            <span class="text-xs font-bold text-green-600 bg-green-100 px-2 py-1 rounded-full">
                                                SK TERBIT (FINAL)
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @if($item->status == 'proses_bapen')
                                            <a href="{{ route('kasi.bapen.form', $item->id) }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md font-bold text-xs uppercase tracking-widest text-white bg-indigo-600 hover:bg-indigo-700 transition shadow-md">
                                                <i class="fas fa-edit mr-2"></i> ISI BAPEN
                                            </a>

                                        @elseif($item->status == 'review_kakan')
                                            <div class="flex flex-col gap-2 items-center">
                                                <div class="text-orange-600 text-xs font-bold flex items-center justify-center border border-orange-200 bg-orange-50 py-1.5 px-3 rounded-full cursor-default w-full">
                                                    <i class="fas fa-clock mr-1"></i> Menunggu ACC
                                                </div>
                                                
                                                <form action="{{ route('kasi.batal', $item->id) }}" method="POST">
                                                    @csrf
                                                    <button type="button" onclick="konfirmasiBatal(this)" class="text-red-500 hover:text-red-700 text-xs font-bold underline decoration-red-300 hover:decoration-red-700 transition">
                                                        <i class="fas fa-undo-alt mr-1"></i> Batal / Tarik
                                                    </button>
                                                </form>
                                            </div>

                                        @elseif($item->status == 'sk_terbit' && $item->file_sk)
                                            <div class="flex flex-col items-center">
                                                <a href="{{ asset('storage/berkas/sk/' . $item->file_sk) }}" target="_blank" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md font-bold text-xs uppercase text-white bg-green-600 hover:bg-green-700 shadow-md transition transform hover:-translate-y-0.5">
                                                    <i class="fas fa-file-pdf mr-2 text-lg"></i> DOWNLOAD SK
                                                </a>
                                                <span class="text-[10px] text-gray-400 mt-1">Proses Selesai</span>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                        <i class="fas fa-clipboard-check text-5xl mb-4 text-gray-300"></i>
                                        <p class="text-lg font-semibold">Meja Bersih!</p>
                                        <p class="text-sm">Tidak ada berkas yang perlu diproses saat ini.</p>
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
        // Alert untuk Batal/Tarik
        function konfirmasiBatal(button) {
            Swal.fire({
                title: 'Tarik Kembali?',
                text: "Berkas akan ditarik dari meja Kepala Kantor kembali ke antrian Anda. Anda bisa merubah BAPEN lagi setelahnya.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33', // Merah
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Tarik Kembali!',
                cancelButtonText: 'Jangan'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            })
        }
    </script>
</x-app-layout>