<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center w-10 h-10 bg-white rounded-full shadow-sm border border-gray-200 text-gray-500 hover:text-indigo-600 hover:bg-gray-50 mr-4 transition duration-150 ease-in-out" title="Kembali ke Dashboard">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fas fa-microphone-alt mr-2 text-blue-600"></i> Proses Wawancara BAP
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-8 rounded-r-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-500 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-bold text-blue-800">Data Pemohon</h3>
                                <div class="mt-1 text-sm text-blue-700 grid grid-cols-1 md:grid-cols-2 gap-x-4">
                                    <p>Nama: <strong>{{ $bap->nama_pemohon }}</strong></p>
                                    <p>Kode: <strong>{{ $bap->kode_booking }}</strong></p>
                                    <p class="col-span-2 mt-2 pt-2 border-t border-blue-200 italic">
                                        "Kronologi Awal: {{ $bap->kronologi ?? $bap->kronologi_singkat ?? '-' }}"
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form id="form-wawancara" action="{{ route('admin.bap.generate', $bap->id) }}" method="POST">
                        @csrf
                        
                        <div class="space-y-6">

                            <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                                <label class="block font-bold text-gray-800 mb-4 border-b pb-2">
                                    <i class="fas fa-id-card text-blue-500 mr-2"></i> Kelengkapan Identitas Pemohon (Untuk PDF)
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-xs font-bold text-gray-500">Tempat Lahir</label>
                                        <input type="text" name="tempat_lahir" required class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-500">Tanggal Lahir</label>
                                        <input type="date" name="tgl_lahir" required class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-500">Agama</label>
                                        <select name="agama" required class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500">
                                            <option value="">-- Pilih Agama --</option>
                                            <option value="Islam">Islam</option>
                                            <option value="Kristen">Kristen</option>
                                            <option value="Katolik">Katolik</option>
                                            <option value="Hindu">Hindu</option>
                                            <option value="Buddha">Buddha</option>
                                            <option value="Konghucu">Konghucu</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-500">Pendidikan Terakhir</label>
                                        <input type="text" name="pendidikan" placeholder="Contoh: SLTP/Sederajat" required class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-500">Pekerjaan</label>
                                        <input type="text" name="pekerjaan" placeholder="Contoh: Pelajar/Mahasiswa" required class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="text-xs font-bold text-gray-500">Alamat Lengkap</label>
                                        <textarea name="alamat_lengkap" rows="2" required class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500" placeholder="Contoh: Krajan RT/RW 001/004..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                                <label class="block font-bold text-gray-800 mb-4 border-b pb-2">
                                    <i class="fas fa-folder-open text-blue-500 mr-2"></i> Kelengkapan Dokumen Pemohon
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-xs font-bold text-gray-500">NIK KTP</label>
                                        <input type="number" name="nik_ktp" required class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-500">Tanggal Keluar KTP</label>
                                        <input type="date" name="tgl_keluar_ktp" required class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-500">Nomor Kartu Keluarga (KK)</label>
                                        <input type="number" name="no_kk" required class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-500">Tanggal Keluar KK</label>
                                        <input type="date" name="tgl_keluar_kk" required class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-500">Nomor Akta Kelahiran/Buku Nikah</label>
                                        <input type="text" name="no_akta" required class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-500">Tanggal Keluar Akta/Buku Nikah</label>
                                        <input type="date" name="tgl_keluar_akta" required class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>

                            <div class="bg-yellow-50 p-5 rounded-lg border border-yellow-200 border-dashed">
                                <div class="flex justify-between items-center mb-4">
                                    <label class="block font-bold text-yellow-800">
                                        <i class="fas fa-comments mr-1"></i> Pertanyaan Wawancara BAP
                                    </label>
                                    <button type="button" onclick="tambahPertanyaan()" class="text-xs bg-yellow-200 hover:bg-yellow-300 text-yellow-800 px-3 py-2 rounded-lg font-bold transition shadow-sm border border-yellow-300">
                                        <i class="fas fa-plus mr-1"></i> Tambah Pertanyaan
                                    </button>
                                </div>
                                
                                <div id="container-pertanyaan" class="space-y-3">
                                    
                                    <div class="p-4 bg-white rounded-lg border border-yellow-300 shadow-sm relative">
                                        <p class="font-bold text-sm text-gray-800 mb-2">1. Apakah Saudari dalam keadaan sehat jasmani dan rohani?</p>
                                        <input type="hidden" name="tanya_tambahan[]" value="Apakah Saudari dalam keadaan sehat jasmani dan rohani?">
                                        <textarea name="jawab_tambahan[]" rows="1" class="w-full border-gray-300 rounded-lg text-sm bg-gray-50 focus:ring-yellow-500" required>Ya, saya dalam keadaan sehat jasmani dan rohani.</textarea>
                                    </div>

                                    <div class="p-4 bg-white rounded-lg border border-yellow-300 shadow-sm relative">
                                        <p class="font-bold text-sm text-gray-800 mb-2">2. Apakah Saudari bersedia untuk diambil keterangan dan memberikan keterangan yang sebenarnya dalam klarifikasi ini?</p>
                                        <input type="hidden" name="tanya_tambahan[]" value="Apakah Saudari bersedia untuk diambil keterangan dan memberikan keterangan yang sebenarnya dalam klarifikasi ini?">
                                        <textarea name="jawab_tambahan[]" rows="1" class="w-full border-gray-300 rounded-lg text-sm bg-gray-50 focus:ring-yellow-500" required>Ya, saya bersedia.</textarea>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 item-tanya mt-4">
                                        <div>
                                            <input type="text" name="tanya_tambahan[]" class="w-full border-yellow-300 rounded-lg text-sm bg-white focus:ring-yellow-500" placeholder="Ketik Pertanyaan Selanjutnya...">
                                        </div>
                                        <div>
                                            <input type="text" name="jawab_tambahan[]" class="w-full border-yellow-300 rounded-lg text-sm bg-white focus:ring-yellow-500" placeholder="Ketik Jawaban...">
                                        </div>
                                    </div>

                                </div>
                                <p class="text-xs text-yellow-600 mt-4 italic">*Klik tombol "Tambah Pertanyaan" di kanan atas jika ingin menambah baris lagi.</p>
                            </div>

                        </div>

                        <div class="mt-8 flex justify-end gap-3 pt-6 border-t">
                            <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 bg-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-300 transition">Batal</a>
                            <button type="submit" id="btn-submit" class="bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-bold py-3 px-8 rounded-lg shadow-lg flex items-center transform transition hover:-translate-y-1">
                                <i class="fas fa-save mr-2"></i> Simpan & Generate BAP
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        function tambahPertanyaan() {
            const container = document.getElementById('container-pertanyaan');
            
            const div = document.createElement('div');
            div.className = 'grid grid-cols-1 md:grid-cols-2 gap-2 item-tanya relative animate-fade-in-down mt-2';
            
            div.innerHTML = `
                <div class="relative">
                    <input type="text" name="tanya_tambahan[]" class="w-full border-yellow-300 rounded-lg text-sm bg-white focus:ring-yellow-500" placeholder="Pertanyaan selanjutnya..." required>
                </div>
                <div class="relative flex items-center gap-2">
                    <input type="text" name="jawab_tambahan[]" class="w-full border-yellow-300 rounded-lg text-sm bg-white focus:ring-yellow-500" placeholder="Jawaban..." required>
                    <button type="button" onclick="this.parentElement.parentElement.remove()" class="text-red-400 hover:text-red-600 p-1" title="Hapus baris ini">
                        <i class="fas fa-times-circle text-lg"></i>
                    </button>
                </div>
            `;
            
            container.appendChild(div);
        }

        document.getElementById('form-wawancara').addEventListener('submit', function() {
            var btn = document.getElementById('btn-submit');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
            btn.classList.add('opacity-75', 'cursor-not-allowed');
        });
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