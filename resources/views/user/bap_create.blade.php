<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-edit mr-2 text-blue-600"></i> {{ __('Pendaftaran BAP Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm animate-pulse" role="alert">
                <div class="flex">
                    <div class="py-1"><i class="fas fa-exclamation-circle mr-3 text-red-600 text-xl"></i></div>
                    <div>
                        <p class="font-bold">Gagal Menyimpan Jadwal</p>
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border-t-4 border-blue-600 mb-10">
                <div class="p-8 text-gray-900">
                    
                    <div class="mb-8 border-b pb-4 flex justify-between items-center">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">Formulir Pengajuan BAP</h3>
                            <p class="text-sm text-gray-500 mt-1">Silakan lengkapi data di bawah ini dengan benar.</p>
                        </div>
                        <div class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
                            <i class="fas fa-edit mr-1"></i> Formulir Digital
                        </div>
                    </div>

                    <form action="{{ route('user.bap.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="bg-gray-50 p-6 rounded-xl mb-8 border border-gray-100">
                            <h4 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
                                <i class="fas fa-user-circle text-blue-500 mr-2"></i> Data Pemohon
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="relative">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-id-card text-gray-400"></i>
                                        </div>
                                        <input type="text" value="{{ Auth::user()->name }}" readonly class="pl-10 block w-full bg-gray-200 border-gray-300 rounded-lg text-gray-500 cursor-not-allowed sm:text-sm">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp (Aktif)</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fab fa-whatsapp text-green-500 text-lg"></i>
                                        </div>
                                        <input type="number" name="no_wa" placeholder="0812..." value="{{ old('no_wa') }}" required class="pl-10 block w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-blue-50 p-6 rounded-xl mb-8 border border-blue-100">
                            <h4 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
                                <i class="fas fa-file-alt text-blue-500 mr-2"></i> Detail Layanan & Jadwal
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Layanan</label>
                                    <select name="jenis_layanan" id="jenis_layanan_input" onchange="checkQuota()" class="block w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                        <option value="reguler" {{ old('jenis_layanan') == 'reguler' ? 'selected' : '' }}>Reguler (Biasa)</option>
                                        <option value="lasles" {{ old('jenis_layanan') == 'lasles' ? 'selected' : '' }}>Layanan Prioritas (Lasles)</option>
                                    </select>
                                    
                                    <div id="warning-lasles" class="hidden mt-2 bg-purple-100 border border-purple-300 text-purple-800 p-2 rounded text-xs font-bold shadow-sm">
                                        <i class="fas fa-clock mr-1"></i> WAJIB hadir sebelum Pukul 10.00 WIB.
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori Masalah</label>
                                    <select name="kategori" class="block w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                        <option value="kehilangan" {{ old('kategori') == 'kehilangan' ? 'selected' : '' }}>Paspor Hilang</option>
                                        <option value="rusak" {{ old('kategori') == 'rusak' ? 'selected' : '' }}>Paspor Rusak</option>
                                        <option value="beda_data" {{ old('kategori') == 'beda_data' ? 'selected' : '' }}>Perbedaan Data</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Rencana Kedatangan</label>
                                    <div class="relative">
                                        <input type="date" 
                                               id="tanggal_input"
                                               name="tanggal_booking" 
                                               min="{{ date('Y-m-d') }}" 
                                               value="{{ old('tanggal_booking') }}"
                                               required 
                                               onchange="checkQuota()"
                                               class="block w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 pl-10">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="far fa-calendar-alt text-blue-500"></i>
                                        </div>
                                    </div>
                                    <p id="kuota-status" class="text-[10px] mt-1 font-semibold text-gray-500">
                                        *Silakan pilih tanggal untuk cek kuota.
                                    </p>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kronologi Singkat</label>
                                <textarea name="kronologi_singkat" rows="3" required class="block w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Ceritakan secara singkat penyebab kehilangan/kerusakan...">{{ old('kronologi_singkat') }}</textarea>
                            </div>
                        </div>

                        <div class="mb-8">
                            <div class="flex justify-between items-end mb-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    <i class="fas fa-paperclip text-gray-400 mr-1"></i> Upload Lampiran (Surat Lapor Polisi / KTP / KK)
                                </label>
                                <button type="button" onclick="clearFiles()" class="text-xs text-red-500 hover:text-red-700 font-bold hidden transition" id="btn-reset">
                                    <i class="fas fa-trash"></i> Hapus Semua
                                </button>
                            </div>
                            
                            <div class="flex items-center justify-center w-full group">
                                <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-blue-300 rounded-xl cursor-pointer bg-blue-50 hover:bg-blue-100 transition duration-300 ease-in-out group-hover:border-blue-500">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <div class="bg-white p-3 rounded-full shadow-sm mb-3">
                                            <i class="fas fa-cloud-upload-alt text-3xl text-blue-500"></i>
                                        </div>
                                        <p class="mb-1 text-sm text-gray-700 font-semibold">Klik untuk pilih file</p>
                                        <p class="text-xs text-gray-500">Format: JPG, PNG, PDF (Max 5MB/file)</p>
                                    </div>
                                    <input id="dropzone-file" name="files[]" type="file" multiple class="hidden" onchange="addFiles(this)" />
                                </label>
                            </div>

                            <div id="file-preview" class="mt-4 hidden animate-fade-in-down">
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">File yang akan diupload:</p>
                                <div id="file-list" class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end border-t pt-6">
                            <button type="submit" id="btn-submit" class="flex items-center bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-bold py-3 px-8 rounded-lg shadow-lg transform transition hover:-translate-y-1 hover:shadow-xl">
                                <i class="fas fa-paper-plane mr-2"></i> Kirim Permohonan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const dt = new DataTransfer();

        function addFiles(input) {
            const files = input.files;
            const previewContainer = document.getElementById('file-preview');
            const fileList = document.getElementById('file-list');
            const btnReset = document.getElementById('btn-reset');

            for (let i = 0; i < files.length; i++) {
                let isDuplicate = false;
                for (let j = 0; j < dt.items.length; j++) {
                    if (dt.items[j].getAsFile().name === files[i].name) { isDuplicate = true; }
                }
                if (!isDuplicate) dt.items.add(files[i]);
            }

            input.files = dt.files;

            if (dt.files.length > 0) {
                previewContainer.classList.remove('hidden');
                btnReset.classList.remove('hidden');
                fileList.innerHTML = ''; 

                for (let i = 0; i < dt.files.length; i++) {
                    const file = dt.files[i];
                    const fileSize = (file.size/1024).toFixed(1);
                    
                    let iconClass = 'fa-file';
                    let colorClass = 'text-gray-500';
                    if(file.type.includes('pdf')) { iconClass = 'fa-file-pdf'; colorClass = 'text-red-500'; }
                    else if(file.type.includes('image')) { iconClass = 'fa-file-image'; colorClass = 'text-purple-500'; }

                    const div = document.createElement('div');
                    div.className = 'flex items-center p-3 bg-white border border-gray-200 rounded-lg shadow-sm';
                    div.innerHTML = `
                        <div class="mr-3"><i class="fas ${iconClass} ${colorClass} text-xl"></i></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">${file.name}</p>
                            <p class="text-xs text-gray-500">${fileSize} KB</p>
                        </div>
                        <div><i class="fas fa-check-circle text-green-500"></i></div>
                    `;
                    fileList.appendChild(div);
                }
            }
        }

        function clearFiles() {
            dt.items.clear();
            document.getElementById('dropzone-file').value = "";
            document.getElementById('file-list').innerHTML = "";
            document.getElementById('file-preview').classList.add('hidden');
            document.getElementById('btn-reset').classList.add('hidden');
        }

        // FUNGSI BARU: CEK KUOTA REAL-TIME BERDASARKAN LAYANAN & TANGGAL
        function checkQuota() {
            const dateInput = document.getElementById('tanggal_input').value;
            const layananInput = document.getElementById('jenis_layanan_input').value;
            const statusText = document.getElementById('kuota-status');
            const btnSubmit = document.getElementById('btn-submit');
            const warningLasles = document.getElementById('warning-lasles');

            // Munculkan peringatan Jam 10 khusus LASLES
            if(layananInput === 'lasles') {
                warningLasles.classList.remove('hidden');
            } else {
                warningLasles.classList.add('hidden');
            }

            // Hanya proses cek kuota jika tanggal sudah dipilih
            if (!dateInput) return;

            // Tampilkan loading
            statusText.innerHTML = '<span class="text-blue-500"><i class="fas fa-spinner fa-spin"></i> Mengecek ketersediaan...</span>';
            btnSubmit.disabled = true;
            btnSubmit.classList.add('opacity-50', 'cursor-not-allowed');

            // Panggil Controller via Fetch API (Kirim tanggal & layanan)
            fetch(`{{ route('user.check_kuota') }}?date=${dateInput}&layanan=${layananInput}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'full') {
                        // JIKA PENUH
                        statusText.innerHTML = `<span class="text-red-600 font-bold"><i class="fas fa-times-circle"></i> ${data.message}</span>`;
                        
                        // Alert Popup
                        Swal.fire({
                            icon: 'error',
                            title: 'Kuota Habis',
                            text: 'Pilih layanan atau tanggal yang lain.',
                            confirmButtonColor: '#d33'
                        });

                        // Tetap disable tombol submit
                        btnSubmit.disabled = true;
                        document.getElementById('tanggal_input').value = ''; // Reset tanggal
                    } else {
                        // JIKA AMAN
                        statusText.innerHTML = `<span class="text-green-600 font-bold"><i class="fas fa-check-circle"></i> ${data.message}</span>`;
                        
                        // Aktifkan tombol submit
                        btnSubmit.disabled = false;
                        btnSubmit.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    statusText.innerHTML = '<span class="text-red-500">Gagal mengecek kuota.</span>';
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Cek kondisi awal saat halaman load (Misal kembali dari validasi error)
            const layananAwal = document.getElementById('jenis_layanan_input').value;
            if(layananAwal === 'lasles') {
                document.getElementById('warning-lasles').classList.remove('hidden');
            }

            @if($errors->any())
                let errorMsg = "<ul class='text-left text-sm'>";
                @foreach ($errors->all() as $error)
                    errorMsg += "<li>• {{ $error }}</li>";
                @endforeach
                errorMsg += "</ul>";

                Swal.fire({
                    icon: 'error',
                    title: 'Oops, ada yang kurang...',
                    html: errorMsg,
                    confirmButtonColor: '#d33',
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'warning',
                    title: 'Kuota Penuh!',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#d33',
                });
            @endif
        });
    </script>
</x-app-layout>