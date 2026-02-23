<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-signature text-rose-600 mr-2"></i> {{ __('Dashboard Kepala Kantor') }}
            </h2>
            <span class="bg-rose-100 text-rose-800 text-xs font-medium px-2.5 py-0.5 rounded border border-rose-400">
                {{ date('d M Y') }}
            </span>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({ title: 'Selesai!', text: "{{ session('success') }}", icon: 'success', confirmButtonColor: '#e11d48', timer: 3000 });
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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-indigo-500 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-semibold uppercase">Perlu Tanda Tangan</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $data->where('status', 'review_kakan')->count() }}</h3>
                    </div>
                    <div class="p-3 bg-indigo-100 rounded-full text-indigo-500">
                        <i class="fas fa-pen-nib text-2xl"></i>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 font-semibold uppercase">SK Terbit (Selesai)</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $data->where('status', 'sk_terbit')->count() }}</h3>
                    </div>
                    <div class="p-3 bg-green-100 rounded-full text-green-600">
                        <i class="fas fa-check-circle text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-800">
                            <i class="fas fa-briefcase mr-2"></i> Ruang Kerja Kepala Kantor
                        </h3>
                        <span class="text-xs text-gray-400">Menampilkan data terbaru</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-lg">Tgl Masuk</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pemohon</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Dokumen Pendukung</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-lg">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($data as $item)
                                <tr class="hover:bg-rose-50 transition duration-150 ease-in-out">
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-700">{{ $item->updated_at->format('d M Y') }}</div>
                                        <div class="text-xs text-gray-400">Pukul {{ $item->updated_at->format('H:i') }} WIB</div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $item->nama_pemohon }}</div>
                                        <div class="text-xs text-rose-600 font-mono bg-rose-50 px-2 py-0.5 rounded inline-block mt-1">{{ $item->kode_booking }}</div>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            @if($item->file_bap)
                                                <a href="{{ asset('storage/berkas/bap/' . $item->file_bap) }}" target="_blank" class="text-xs bg-red-50 text-red-600 px-2 py-1 rounded border border-red-200 hover:bg-red-100 transition" title="Lihat BAP">
                                                    <i class="fas fa-file-pdf"></i> BAP
                                                </a>
                                            @endif
                                            @if($item->file_bapen)
                                                <a href="{{ asset('storage/berkas/bapen/' . $item->file_bapen) }}" target="_blank" class="text-xs bg-blue-50 text-blue-600 px-2 py-1 rounded border border-blue-200 hover:bg-blue-100 transition" title="Lihat BAPEN">
                                                    <i class="fas fa-file-signature"></i> BAPEN
                                                </a>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @if($item->status == 'review_kakan')
                                            <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-full border border-indigo-200">
                                                PERLU TTD
                                            </span>
                                        @elseif($item->status == 'sk_terbit')
                                            <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full border border-green-200">
                                                DITERBITKAN
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400">-</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @if($item->status == 'review_kakan')
                                            <div class="flex flex-col gap-2">
                                                <a href="{{ route('kakan.preview', $item->id) }}" target="_blank" class="w-full inline-flex justify-center items-center px-4 py-1 border border-yellow-400 text-yellow-700 bg-yellow-50 rounded-md font-bold text-xs hover:bg-yellow-100 transition">
                                                    <i class="fas fa-eye mr-2"></i> Preview Template
                                                </a>

                                                <a href="{{ route('kakan.formSk', $item->id) }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-900 text-white border border-transparent rounded-md font-bold text-xs uppercase tracking-widest hover:bg-black transition shadow-md">
                                                    <i class="fas fa-pen-fancy mr-2"></i> PROSES SK
                                                </a>
                                            </div>

                                        @elseif($item->status == 'sk_terbit' && $item->file_sk)
                                            <div class="flex flex-col items-center gap-2">
                                                <a href="{{ asset('storage/berkas/sk/' . $item->file_sk) }}" target="_blank" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md font-bold text-xs uppercase text-white bg-green-600 hover:bg-green-700 shadow-md transition transform hover:-translate-y-0.5">
                                                    <i class="fas fa-file-pdf mr-2 text-lg"></i> DOWNLOAD SK
                                                </a>
                                                
                                                <form action="{{ route('kakan.batal', $item->id) }}" method="POST">
                                                    @csrf
                                                    <button type="button" onclick="konfirmasiBatal(this)" class="text-red-500 hover:text-red-700 text-xs font-bold underline decoration-red-300 hover:decoration-red-700 transition">
                                                        <i class="fas fa-times-circle mr-1"></i> Batal / Tarik SK
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-10 text-gray-500">
                                        <i class="fas fa-clipboard-check text-4xl mb-3 text-gray-300"></i>
                                        <p>Tidak ada berkas yang perlu ditandatangani.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">{{ $data->links() }}</div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Alert Batal SK
        function konfirmasiBatal(button) {
            Swal.fire({
                title: 'Tarik Kembali SK?',
                text: "Surat Keputusan akan DIHAPUS dan status dikembalikan ke 'Perlu Tanda Tangan'. Anda bisa memperbaiki draftnya kembali.",
                icon: 'error', 
                showCancelButton: true,
                confirmButtonColor: '#d33', // Merah
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Tarik SK!',
                cancelButtonText: 'Jangan'
            }).then((result) => {
                if (result.isConfirmed) button.closest('form').submit();
            })
        }
    </script>
</x-app-layout>