<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('kakan.dashboard') }}" class="mr-4 text-gray-500 hover:text-indigo-600">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight"><i class="fas fa-file-signature text-blue-600 mr-2"></i> Pembuatan SK Kakanim</h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-xl sm:rounded-lg">
                
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-8 rounded-r-lg">
                    <h3 class="font-bold text-blue-800">Data Pemohon: <strong>{{ strtoupper($bap->nama_pemohon) }}</strong></h3>
                    <p class="text-sm text-blue-700 mt-1">Kode: {{ $bap->kode_booking }} | Keterangan BAP: {{ $bap->keterangan_bap }}</p>
                </div>

                <form id="form-sk" action="{{ route('kakan.storeSk', $bap->id) }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                            <h3 class="font-bold text-gray-800 mb-4 border-b border-gray-200 pb-2"><i class="fas fa-passport mr-2 text-blue-500"></i> Detail Dokumen Lama (Untuk Konsideran)</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs font-bold text-gray-500">Nomor SK (Surat Keputusan)</label>
                                    <input type="text" name="nomor_sk" id="nomor_sk" placeholder="WIM.13.IMI.7-623 GR.03.01 TAHUN 2026" required class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-500">Keterangan / Alasan SK</label>
                                    <input type="text" name="alasan_sk" value="{{ $bap->keterangan_bap ?? 'Hilang Habis Berlaku' }}" required class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-500">Nomor Paspor Lama</label>
                                    <input type="text" name="nomor_paspor_lama" required class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-500">Dikeluarkan di (Kanim Lama)</label>
                                    <input type="text" name="kanim_penerbit_lama" placeholder="Contoh: Kantor Imigrasi Semarang" required class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-500">Tanggal Keluar Paspor Lama</label>
                                    <input type="date" name="tgl_keluar_paspor_lama" required class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-500">Tanggal Habis Paspor Lama</label>
                                    <input type="date" name="tgl_habis_paspor_lama" required class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <div class="bg-indigo-50 p-5 rounded-lg border border-indigo-200 relative">
                            <span class="absolute top-4 right-4 bg-green-100 text-green-700 text-xs font-bold px-2 py-1 border border-green-300 rounded"><i class="fas fa-magic"></i> Auto-Save Aktif</span>
                            <h3 class="font-bold text-indigo-800 mb-4 border-b border-indigo-200 pb-2"><i class="fas fa-user-tie mr-2 text-indigo-500"></i> Penandatangan SK</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs font-bold text-gray-500">Jabatan Penandatangan (Plh / Kepala Kantor)</label>
                                    <input type="text" name="jabatan_ttd_sk" id="jabatan_ttd_sk" placeholder="Contoh: Kepala Kantor, ATAU Plh. Kepala Kantor," required class="w-full border-indigo-300 rounded-lg text-sm focus:ring-indigo-500">
                                    <p class="text-xs text-indigo-500 mt-1">*Bisa diisi <b>Plh. Kepala Kantor,</b> atau <b>a.n. Kepala Kantor,</b></p>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-500">Nama Pejabat</label>
                                    <input type="text" name="nama_ttd_sk" id="nama_ttd_sk" placeholder="Nama lengkap tanpa gelar" required class="w-full border-indigo-300 rounded-lg text-sm focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="mt-8 flex justify-end gap-3 pt-6 border-t">
                        <button type="submit" id="btn-submit" class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-3 px-8 rounded-lg shadow-lg flex items-center transform transition hover:-translate-y-1">
                            <i class="fas fa-print mr-2"></i> Terbitkan SK Final
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Ingat isian penandatangan dan nomor surat terakhir
            const fieldsToRemember = ['jabatan_ttd_sk', 'nama_ttd_sk', 'nomor_sk'];
            fieldsToRemember.forEach(field => {
                const savedValue = localStorage.getItem('memori_sk_' + field);
                if (savedValue) { document.getElementById(field).value = savedValue; }
            });
        });

        document.getElementById('form-sk').addEventListener('submit', function() {
            ['jabatan_ttd_sk', 'nama_ttd_sk', 'nomor_sk'].forEach(field => {
                const input = document.getElementById(field);
                if(input && input.value) { localStorage.setItem('memori_sk_' + field, input.value); }
            });
            var btn = document.getElementById('btn-submit');
            btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...'; btn.classList.add('opacity-75');
        });
    </script>
</x-app-layout>