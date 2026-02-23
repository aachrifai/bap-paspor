<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center w-10 h-10 bg-white rounded-full shadow-sm border border-gray-200 text-gray-500 hover:text-indigo-600 hover:bg-gray-50 mr-4 transition duration-150 ease-in-out" title="Kembali ke Dashboard">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Permohonan <span class="text-indigo-600 ml-1">#{{ $bap->kode_booking }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="md:col-span-1">
                    <div class="bg-white shadow-sm sm:rounded-lg p-6 sticky top-6">
                        <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2">Data Pemohon</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="text-xs text-gray-500 uppercase">Nama Lengkap</label>
                                <p class="font-medium text-gray-900">{{ $bap->nama_pemohon }}</p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 uppercase">No. WhatsApp</label>
                                <p class="font-medium text-gray-900">{{ $bap->no_wa }}</p>
                                <a href="https://wa.me/{{ $bap->no_wa }}" target="_blank" class="text-xs text-green-600 hover:underline">
                                    <i class="fab fa-whatsapp"></i> Chat via WA
                                </a>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 uppercase">Jenis Layanan</label>
                                <p class="font-medium text-gray-900">
                                    @if($bap->jenis_layanan == 'lasles')
                                        <span class="text-purple-600 font-bold">⚡ LASLES (Prioritas)</span>
                                    @else
                                        Reguler
                                    @endif
                                </p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 uppercase">Tanggal Kedatangan</label>
                                <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($bap->tanggal_booking)->translatedFormat('d F Y') }}</p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 uppercase">Kronologi</label>
                                <p class="text-sm text-gray-600 bg-gray-50 p-2 rounded border">{{ $bap->kronologi_singkat }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 space-y-6">
                    
                    @if($bap->catatan_revisi)
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded shadow-sm">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-history text-yellow-600 text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-bold text-yellow-800 uppercase">Riwayat Catatan Revisi Sebelumnya:</h3>
                                    <p class="text-sm text-yellow-700 mt-1 italic">
                                        "{{ $bap->catatan_revisi }}"
                                    </p>
                                    <p class="text-xs text-yellow-600 mt-2 font-semibold">
                                        *User mungkin sudah memperbaiki berkas berdasarkan catatan ini.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2">Berkas Lampiran</h3>
                        
                        @if($bap->attachments && $bap->attachments->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($bap->attachments as $file)
                                <div class="flex items-center p-3 border rounded-lg hover:bg-gray-50 transition group">
                                    <div class="mr-3">
                                        <i class="fas fa-file-alt text-3xl text-blue-400"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            {{ $file->jenis_file ?? 'Lampiran ' . $loop->iteration }}
                                        </p>
                                        <p class="text-xs text-gray-500 truncate" title="{{ basename($file->path_file) }}">
                                            {{ basename($file->path_file) }}
                                        </p>
                                    </div>
                                    <a href="{{ asset('storage/' . $file->path_file) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm font-bold px-3 py-1 border border-blue-200 rounded-md hover:bg-blue-50">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-400 border-2 border-dashed border-gray-200 rounded-lg">
                                <i class="fas fa-exclamation-circle text-2xl mb-2"></i>
                                <p>Tidak ada lampiran diupload.</p>
                            </div>
                        @endif
                    </div>

                    <div class="bg-white shadow-sm sm:rounded-lg p-6 border-t-4 border-indigo-500">
                        <h3 class="text-lg font-bold text-gray-700 mb-4">Keputusan Petugas</h3>
                        
                        <form action="{{ route('admin.bap.verifikasi', $bap->id) }}" method="POST">
                            @csrf
                            
                            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 mb-6">
                                <label class="flex-1 cursor-pointer group">
                                    <input type="radio" name="aksi" value="valid" class="peer sr-only" checked onclick="toggleRevisi(false)">
                                    <div class="p-4 rounded-lg border-2 border-gray-200 peer-checked:border-green-500 peer-checked:bg-green-50 text-center transition group-hover:border-green-200">
                                        <div class="peer-checked:hidden">
                                            <i class="far fa-check-circle text-2xl text-gray-400 mb-2"></i>
                                        </div>
                                        <div class="hidden peer-checked:block">
                                            <i class="fas fa-check-circle text-2xl text-green-500 mb-2"></i>
                                        </div>
                                        <h4 class="font-bold text-gray-800">Berkas Valid</h4>
                                        <p class="text-xs text-gray-500">Lanjut ke Wawancara</p>
                                    </div>
                                </label>

                                <label class="flex-1 cursor-pointer group">
                                    <input type="radio" name="aksi" value="revisi" class="peer sr-only" onclick="toggleRevisi(true)">
                                    <div class="p-4 rounded-lg border-2 border-gray-200 peer-checked:border-red-500 peer-checked:bg-red-50 text-center transition group-hover:border-red-200">
                                        <div class="peer-checked:hidden">
                                            <i class="far fa-times-circle text-2xl text-gray-400 mb-2"></i>
                                        </div>
                                        <div class="hidden peer-checked:block">
                                            <i class="fas fa-times-circle text-2xl text-red-500 mb-2"></i>
                                        </div>
                                        <h4 class="font-bold text-gray-800">Tolak / Revisi</h4>
                                        <p class="text-xs text-gray-500">Minta user perbaiki</p>
                                    </div>
                                </label>
                            </div>

                            <div id="box-catatan" class="mb-6 hidden animate-fade-in-down">
                                <label class="block text-sm font-bold text-red-700 mb-2">
                                    <i class="fas fa-edit mr-1"></i> Alasan Penolakan / Catatan Revisi
                                </label>
                                <textarea name="catatan" rows="3" class="w-full border-red-300 rounded-lg focus:ring-red-500 focus:border-red-500 bg-red-50 placeholder-red-300" placeholder="Tuliskan secara jelas dokumen apa yang salah atau kurang..."></textarea>
                                <p class="text-xs text-gray-500 mt-1">*Catatan ini akan muncul di dashboard pemohon.</p>
                            </div>

                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg shadow-lg transition transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <i class="fas fa-paper-plane mr-2"></i> Simpan Keputusan
                            </button>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script>
        function toggleRevisi(show) {
            const box = document.getElementById('box-catatan');
            const input = box.querySelector('textarea');
            if(show) {
                box.classList.remove('hidden');
                input.setAttribute('required', 'required');
                input.focus();
            } else {
                box.classList.add('hidden');
                input.removeAttribute('required');
                input.value = ''; // Reset isi jika batal revisi
            }
        }
    </script>
    
    <style>
        .animate-fade-in-down {
            animation: fadeInDown 0.3s ease-out;
        }
        @keyframes fadeInDown {
            0% { opacity: 0; transform: translateY(-10px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-app-layout>