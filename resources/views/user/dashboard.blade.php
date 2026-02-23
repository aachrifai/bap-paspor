<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-history mr-2 text-indigo-600"></i> {{ __('Riwayat Permohonan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-end mb-4">
                <a href="{{ route('user.bap.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 transition ease-in-out duration-150 shadow-md">
                    <i class="fas fa-plus mr-2"></i> Buat Pengajuan Baru
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-indigo-600">
                <div class="p-8 text-gray-900">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-list-alt text-indigo-600 mr-2"></i> Daftar Pengajuan Saya
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kode Booking</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Layanan</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($data as $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $item->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-mono font-bold text-gray-800 bg-gray-100 px-2 py-1 rounded">{{ $item->kode_booking }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm capitalize">
                                        {{ str_replace('_', ' ', $item->kategori) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @php
                                            $statusClass = match($item->status) {
                                                'sk_terbit', 'selesai' => 'bg-green-100 text-green-800 border-green-200',
                                                'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                'revisi_dokumen' => 'bg-red-100 text-red-800 border-red-200',
                                                'review_kasubsi', 'proses_bapen', 'review_kakan' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                default => 'bg-gray-100 text-gray-800 border-gray-200'
                                            };
                                            
                                            $labelStatus = match($item->status) {
                                                'pending' => 'Menunggu Admin',
                                                'revisi_dokumen' => 'PERLU REVISI',
                                                'review_kasubsi' => 'Validasi Kasubsi',
                                                'proses_bapen' => 'Proses BAPEN',
                                                'review_kakan' => 'Tanda Tangan SK',
                                                'sk_terbit' => 'SELESAI',
                                                default => strtoupper(str_replace('_', ' ', $item->status))
                                            };
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full border {{ $statusClass }}">
                                            {{ $labelStatus }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        
                                        <div class="flex items-center justify-center space-x-3">
                                            
                                            <a href="{{ route('user.bap.show', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 p-2 rounded-full transition" title="Lihat Detail / Resi">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <div>
                                                @if($item->status == 'revisi_dokumen')
                                                    <a href="{{ route('user.bap.edit', $item->id) }}" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-full shadow-md transition transform hover:-translate-y-0.5">
                                                        <i class="fas fa-edit mr-2"></i> Perbaiki Dokumen
                                                    </a>

                                                @elseif($item->status == 'sk_terbit' && $item->file_sk)
                                                    <div class="flex flex-col items-center justify-center">
                                                        <a href="{{ asset('storage/berkas/sk/' . $item->file_sk) }}" target="_blank" class="flex items-center justify-center bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md shadow-lg transition transform hover:-translate-y-0.5 w-full">
                                                            <i class="fas fa-file-pdf mr-2 text-lg"></i> DOWNLOAD SK
                                                        </a>
                                                        <span class="text-[10px] text-gray-400 mt-1 font-medium">Proses Selesai</span>
                                                    </div>

                                                @else
                                                    <span class="text-xs text-gray-400 font-medium bg-gray-100 px-3 py-1 rounded-full border border-gray-200 cursor-default">
                                                        <i class="fas fa-clock mr-1"></i> Sedang Diproses
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                        <i class="fas fa-folder-open text-4xl mb-3 text-gray-300"></i>
                                        <p>Belum ada riwayat permohonan.</p>
                                        <a href="{{ route('user.bap.create') }}" class="text-blue-500 hover:underline text-sm mt-2 block font-semibold">Buat pengajuan baru sekarang</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK, Siap!'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Tutup'
                });
            @endif
        });
    </script>
</x-app-layout>