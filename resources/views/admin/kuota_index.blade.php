<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <x-slot name="header">
        <h2 class="flex items-center font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center w-10 h-10 bg-white rounded-full shadow-sm border border-gray-200 text-gray-400 hover:text-indigo-600 mr-4 transition transform hover:-translate-x-1" title="Kembali ke Dashboard">
                <i class="fas fa-arrow-left"></i>
            </a>
            <i class="fas fa-calendar-alt mr-2 text-indigo-600"></i> Atur Kuota Harian
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
                <p class="font-bold"><i class="fas fa-check-circle mr-2"></i>Berhasil!</p>
                <p>{{ session('success') }}</p>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border-t-4 border-indigo-500">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="font-bold text-lg text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-plus-circle text-indigo-500 mr-2"></i> Set Kuota Khusus
                    </h3>
                    
                    <form action="{{ route('admin.kuota.store') }}" method="POST" class="flex flex-col md:flex-row gap-4 items-end">
                        @csrf
                        <div class="w-full md:w-1/4">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Pilih Tanggal</label>
                            <input type="date" name="tanggal" required 
                                   min="{{ date('Y-m-d') }}"
                                   class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                        </div>
                        <div class="w-full md:w-1/4">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Max Reguler</label>
                            <input type="number" name="kuota_reguler" required min="0" placeholder="Contoh: 3" 
                                   class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                        </div>
                        <div class="w-full md:w-1/4">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Max Lasles</label>
                            <input type="number" name="kuota_lasles" required min="0" placeholder="Contoh: 2" 
                                   class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                        </div>
                        <div class="w-full md:w-1/4">
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-lg shadow transition transform hover:-translate-y-0.5">
                                <i class="fas fa-save mr-2"></i> Simpan
                            </button>
                        </div>
                    </form>
                    <p class="text-xs text-gray-500 mt-2">*Tanggal yang tidak ada di daftar ini akan menggunakan kuota default (Reguler: 3, Lasles: 2).</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-gray-500">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="font-bold text-lg text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-list-ul text-gray-500 mr-2"></i> Daftar Tanggal dengan Kuota Khusus
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border rounded-lg">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th rowspan="2" class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-r">Tanggal</th>
                                    <th colspan="3" class="px-4 py-2 text-center text-xs font-bold text-blue-600 uppercase tracking-wider border-b border-r bg-blue-50">REGULER</th>
                                    <th colspan="3" class="px-4 py-2 text-center text-xs font-bold text-purple-600 uppercase tracking-wider border-b border-r bg-purple-50">LASLES</th>
                                    <th rowspan="2" class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider border-b">Aksi</th>
                                </tr>
                                <tr>
                                    <th class="px-2 py-2 text-center text-[10px] font-bold text-gray-500 uppercase border-b border-r bg-blue-50">Max</th>
                                    <th class="px-2 py-2 text-center text-[10px] font-bold text-gray-500 uppercase border-b border-r bg-blue-50">Terisi</th>
                                    <th class="px-2 py-2 text-center text-[10px] font-bold text-gray-500 uppercase border-b border-r bg-blue-50">Sisa</th>
                                    <th class="px-2 py-2 text-center text-[10px] font-bold text-gray-500 uppercase border-b border-r bg-purple-50">Max</th>
                                    <th class="px-2 py-2 text-center text-[10px] font-bold text-gray-500 uppercase border-b border-r bg-purple-50">Terisi</th>
                                    <th class="px-2 py-2 text-center text-[10px] font-bold text-gray-500 uppercase border-b border-r bg-purple-50">Sisa</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($kuotas as $k)
                                    @php
                                        // REGULER
                                        $terisi_reguler = \App\Models\Bap::whereDate('tanggal_booking', $k->tanggal)->where('jenis_layanan', 'reguler')->count();
                                        $sisa_reguler = max(0, $k->kuota_reguler - $terisi_reguler);
                                        $isFullReguler = $sisa_reguler == 0;

                                        // LASLES
                                        $terisi_lasles = \App\Models\Bap::whereDate('tanggal_booking', $k->tanggal)->where('jenis_layanan', 'lasles')->count();
                                        $sisa_lasles = max(0, $k->kuota_lasles - $terisi_lasles);
                                        $isFullLasles = $sisa_lasles == 0;
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 border-r">
                                            {{ \Carbon\Carbon::parse($k->tanggal)->translatedFormat('d F Y') }}
                                        </td>
                                        
                                        <td class="px-2 py-3 whitespace-nowrap text-center text-sm font-bold text-blue-600 border-r">{{ $k->kuota_reguler }}</td>
                                        <td class="px-2 py-3 whitespace-nowrap text-center text-sm text-gray-700 border-r">{{ $terisi_reguler }}</td>
                                        <td class="px-2 py-3 whitespace-nowrap text-center border-r">
                                            @if($isFullReguler)
                                                <span class="px-2 py-1 text-[10px] font-bold text-red-700 bg-red-100 rounded-full">Penuh</span>
                                            @else
                                                <span class="px-2 py-1 text-[10px] font-bold text-green-700 bg-green-100 rounded-full">{{ $sisa_reguler }} Slot</span>
                                            @endif
                                        </td>

                                        <td class="px-2 py-3 whitespace-nowrap text-center text-sm font-bold text-purple-600 border-r">{{ $k->kuota_lasles }}</td>
                                        <td class="px-2 py-3 whitespace-nowrap text-center text-sm text-gray-700 border-r">{{ $terisi_lasles }}</td>
                                        <td class="px-2 py-3 whitespace-nowrap text-center border-r">
                                            @if($isFullLasles)
                                                <span class="px-2 py-1 text-[10px] font-bold text-red-700 bg-red-100 rounded-full">Penuh</span>
                                            @else
                                                <span class="px-2 py-1 text-[10px] font-bold text-green-700 bg-green-100 rounded-full">{{ $sisa_lasles }} Slot</span>
                                            @endif
                                        </td>

                                        <td class="px-4 py-3 whitespace-nowrap text-center text-sm">
                                            <form id="form-delete-{{ $k->id }}" action="{{ route('admin.kuota.destroy', $k->id) }}" method="POST">
                                                @csrf 
                                                @method('DELETE')
                                                
                                                <button type="button" onclick="konfirmasiHapus('{{ $k->id }}', '{{ \Carbon\Carbon::parse($k->tanggal)->translatedFormat('d F Y') }}')" class="text-red-500 hover:text-red-700 font-semibold text-xs border border-red-200 bg-red-50 px-3 py-1 rounded hover:bg-red-100 transition">
                                                    <i class="fas fa-trash-alt mr-1"></i> Hapus / Reset
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-10 text-center text-gray-500">
                                            <i class="fas fa-calendar-times text-4xl mb-3 text-gray-300"></i>
                                            <p>Belum ada aturan kuota khusus.</p>
                                            <p class="text-xs">Semua tanggal menggunakan kuota default.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function konfirmasiHapus(id, tanggal) {
            Swal.fire({
                title: 'Hapus Aturan Kuota?',
                text: "Aturan untuk tanggal " + tanggal + " akan dihapus. Kuota akan kembali ke default (Reguler: 3, Lasles: 2).",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-delete-' + id).submit();
                }
            })
        }
    </script>
</x-app-layout>