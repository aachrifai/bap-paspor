<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-file-signature mr-2 text-indigo-600"></i> Pengisian Berita Acara Pendapat (BAPEN)
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    
                    <div class="bg-indigo-50 border-l-4 border-indigo-500 p-4 mb-8 rounded-r-lg">
                        <h3 class="font-bold text-indigo-800">Review Data Pemohon: <strong>{{ strtoupper($bap->nama_pemohon) }}</strong></h3>
                        <p class="text-sm text-indigo-700 mt-1">Kode: {{ $bap->kode_booking }} | Alasan BAP: {{ $bap->alasan_pemeriksaan }}</p>
                    </div>

                    <form id="form-bapen" action="{{ route('kasi.bapen.simpan', $bap->id) }}" method="POST">
                        @csrf
                        
                        <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                            <div class="flex justify-between items-center border-b pb-3 mb-4">
                                <label class="block font-bold text-gray-800 text-lg">
                                    <i class="fas fa-list-ol text-blue-500 mr-2"></i> Poin-poin Pendapat Kasi
                                </label>
                            </div>
                            
                            <p class="text-sm text-gray-500 mb-6">*Tambahkan poin utama untuk angka 1,2,3. Tambahkan anak poin untuk rincian dokumen a,b,c.</p>

                            <div id="container-pendapat" class="space-y-6">
                                <div class="pendapat-item bg-blue-50 border border-blue-200 p-4 rounded-lg relative" data-index="0">
                                    <div class="flex gap-3">
                                        <div class="font-bold text-blue-700 mt-2 text-lg angka-poin">1.</div>
                                        <div class="flex-1">
                                            <textarea name="pendapat_utama[0]" rows="2" class="w-full border-blue-300 rounded-lg text-sm focus:ring-blue-500" required placeholder="Ketik pendapat utama di sini...">Benar bahwa yang bersangkutan telah kehilangan Paspor RI...</textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="pl-8 mt-3 space-y-2 sub-container" id="sub-container-0"></div>
                                    
                                    <div class="pl-8 mt-2">
                                        <button type="button" onclick="tambahSub(0)" class="text-xs bg-white text-blue-600 font-bold px-3 py-1.5 rounded border border-blue-300 hover:bg-blue-100 transition shadow-sm">
                                            + Tambah Anak Poin (a, b, c)
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <button type="button" onclick="tambahPendapat()" class="mt-6 w-full bg-gray-100 text-gray-700 border-2 border-dashed border-gray-300 font-bold py-3 rounded-lg hover:bg-gray-200 transition">
                                <i class="fas fa-plus-circle mr-1"></i> Tambah Poin Utama Baru
                            </button>

                        </div>

                        <div class="mt-8 flex justify-end gap-3 pt-6 border-t">
                            <button type="submit" id="btn-submit" class="bg-gradient-to-r from-indigo-600 to-blue-700 hover:from-indigo-700 hover:to-blue-800 text-white font-bold py-3 px-8 rounded-lg shadow-lg flex items-center transform transition hover:-translate-y-1">
                                <i class="fas fa-print mr-2"></i> Simpan & Cetak BAPEN
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        let pendapatIndex = 1;

        // Fungsi Menambah Poin Utama (1, 2, 3...)
        function tambahPendapat() {
            const container = document.getElementById('container-pendapat');
            const div = document.createElement('div');
            div.className = 'pendapat-item bg-blue-50 border border-blue-200 p-4 rounded-lg relative animate-fade-in-down';
            div.setAttribute('data-index', pendapatIndex);

            div.innerHTML = `
                <button type="button" onclick="hapusItem(this)" class="absolute top-2 right-2 text-red-400 hover:text-red-600 bg-white rounded-full p-1 shadow-sm" title="Hapus Poin Utama"><i class="fas fa-times-circle text-lg"></i></button>
                <div class="flex gap-3">
                    <div class="font-bold text-blue-700 mt-2 text-lg angka-poin">•</div>
                    <div class="flex-1 pr-6">
                        <textarea name="pendapat_utama[${pendapatIndex}]" rows="2" class="w-full border-blue-300 rounded-lg text-sm focus:ring-blue-500" required placeholder="Ketik pendapat utama di sini..."></textarea>
                    </div>
                </div>
                <div class="pl-8 mt-3 space-y-2 sub-container" id="sub-container-${pendapatIndex}"></div>
                <div class="pl-8 mt-2">
                    <button type="button" onclick="tambahSub(${pendapatIndex})" class="text-xs bg-white text-blue-600 font-bold px-3 py-1.5 rounded border border-blue-300 hover:bg-blue-100 transition shadow-sm">+ Tambah Anak Poin (a, b, c)</button>
                </div>
            `;
            container.appendChild(div);
            pendapatIndex++;
            updateNomorPoin();
        }

        // Fungsi Menambah Anak Poin (a, b, c...)
        function tambahSub(index) {
            const subContainer = document.getElementById(`sub-container-${index}`);
            const div = document.createElement('div');
            div.className = 'flex gap-2 relative animate-fade-in-down items-start';
            div.innerHTML = `
                <span class="font-bold text-gray-500 mt-2 huruf-poin">-</span>
                <input type="text" name="pendapat_sub[${index}][]" class="flex-1 border-gray-300 rounded-lg text-sm focus:ring-blue-500 bg-white" placeholder="Rincian sub-poin (misal: KTP NIK 330...)" required>
                <button type="button" onclick="this.parentElement.remove(); updateNomorPoin();" class="text-red-400 hover:text-red-600 mt-2" title="Hapus Anak Poin"><i class="fas fa-trash"></i></button>
            `;
            subContainer.appendChild(div);
            updateNomorPoin();
        }

        // Fungsi Hapus Poin Utama
        function hapusItem(btn) {
            btn.closest('.pendapat-item').remove();
            updateNomorPoin();
        }

        // Merapikan Urutan Angka 1,2,3 dan a,b,c secara visual
        function updateNomorPoin() {
            const items = document.querySelectorAll('.pendapat-item');
            items.forEach((item, i) => {
                item.querySelector('.angka-poin').innerText = (i + 1) + '.';
                
                const subs = item.querySelectorAll('.huruf-poin');
                const abjad = 'abcdefghijklmnopqrstuvwxyz';
                subs.forEach((sub, j) => {
                    sub.innerText = abjad[j] + '.';
                });
            });
        }

        // Animasi Submit
        document.getElementById('form-bapen').addEventListener('submit', function() {
            var btn = document.getElementById('btn-submit');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
            btn.classList.add('opacity-75', 'cursor-not-allowed');
        });
    </script>
    <style>.animate-fade-in-down { animation: fadeInDown 0.3s ease-out; } @keyframes fadeInDown { 0% { opacity: 0; transform: translateY(-10px); } 100% { opacity: 1; transform: translateY(0); } }</style>
</x-app-layout>