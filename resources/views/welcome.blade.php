<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sistem BAP Online - Kantor Imigrasi</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            /* Custom Scrollbar */
            ::-webkit-scrollbar { width: 8px; }
            ::-webkit-scrollbar-track { background: #f1f5f9; }
            ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
            ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
            
            /* Gradient Text */
            .text-gradient {
                background: linear-gradient(to right, #2563eb, #4f46e5);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
        </style>
    </head>
    <body class="antialiased bg-slate-50 font-sans text-slate-800">

        <nav class="fixed w-full z-50 transition-all duration-300 bg-white/80 backdrop-blur-md border-b border-white/20 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    
                    <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                        <div class="relative">
                            <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full blur opacity-25 group-hover:opacity-50 transition duration-200"></div>
                            <img src="{{ asset('img/logo_imigrasi.png') }}" alt="Logo" class="relative h-12 w-auto">
                        </div>
                        <div class="flex flex-col">
                            <span class="font-extrabold text-xl tracking-tight text-slate-800 group-hover:text-blue-600 transition">Sistem BAP Online</span>
                            <span class="text-[10px] font-bold tracking-widest text-slate-500 uppercase">Kantor Imigrasi Kelas I TPI</span>
                        </div>
                    </a>
                    
                    <div class="flex items-center gap-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 rounded-full font-semibold text-sm text-white bg-slate-900 hover:bg-slate-800 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="hidden md:inline-block font-semibold text-slate-600 hover:text-blue-600 transition text-sm">Masuk</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-6 py-2.5 rounded-full font-bold text-sm text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition-all transform hover:-translate-y-0.5">
                                        Daftar Sekarang
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
            <div class="absolute inset-0 bg-slate-50">
                <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"></div>
                <div class="absolute left-0 right-0 top-0 -z-10 m-auto h-[310px] w-[310px] rounded-full bg-blue-500 opacity-20 blur-[100px]"></div>
                <div class="absolute right-0 top-0 -z-10 h-[500px] w-[500px] rounded-full bg-indigo-500 opacity-10 blur-[100px]"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <span class="inline-block py-1 px-3 rounded-full bg-blue-100 text-blue-700 text-xs font-bold uppercase tracking-wider mb-6 border border-blue-200">
                    Layanan Digital Terintegrasi
                </span>
                <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-slate-900 mb-6 leading-tight">
                    Pengurusan Paspor <br>
                    <span class="text-gradient">Cepat & Transparan</span>
                </h1>
                <p class="text-lg md:text-xl text-slate-600 max-w-2xl mx-auto mb-10 leading-relaxed">
                    Solusi modern untuk BAP Paspor Hilang, Rusak, atau Perubahan Data. 
                    Pantau status permohonan Anda secara real-time dari mana saja.
                </p>
                
                @if (Route::has('register'))
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('register') }}" class="px-8 py-4 rounded-full font-bold text-white bg-slate-900 hover:bg-slate-800 shadow-xl hover:shadow-2xl transition transform hover:-translate-y-1 flex items-center justify-center gap-2">
                            Mulai Pengajuan <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="#alur" class="px-8 py-4 rounded-full font-bold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 hover:border-slate-300 shadow-sm transition flex items-center justify-center gap-2">
                            <i class="fas fa-info-circle text-blue-600"></i> Pelajari Alur
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <section class="py-24 bg-white relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl font-bold text-slate-900 mb-4">Kenapa Menggunakan Sistem Ini?</h2>
                    <p class="text-slate-500">Kami mendigitalkan proses birokrasi untuk memberikan pengalaman pelayanan publik terbaik bagi Anda.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="group p-8 rounded-3xl bg-slate-50 hover:bg-white border border-slate-100 hover:border-blue-100 shadow-sm hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-300">
                        <div class="w-14 h-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-2xl mb-6 shadow-lg shadow-blue-500/30 group-hover:scale-110 transition duration-300">
                            <i class="fas fa-file-contract"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Penggantian Paspor</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Khusus untuk permohonan paspor hilang, rusak, atau perubahan data yang memerlukan proses BAP secara mendetail.</p>
                    </div>

                    <div class="group p-8 rounded-3xl bg-slate-50 hover:bg-white border border-slate-100 hover:border-green-100 shadow-sm hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300">
                        <div class="w-14 h-14 rounded-2xl bg-green-500 text-white flex items-center justify-center text-2xl mb-6 shadow-lg shadow-green-500/30 group-hover:scale-110 transition duration-300">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Efisien & Cepat</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Pangkas waktu antrian. Upload dokumen dari rumah, verifikasi online, dan datang hanya untuk pengambilan foto.</p>
                    </div>

                    <div class="group p-8 rounded-3xl bg-slate-50 hover:bg-white border border-slate-100 hover:border-purple-100 shadow-sm hover:shadow-2xl hover:shadow-purple-500/10 transition-all duration-300">
                        <div class="w-14 h-14 rounded-2xl bg-purple-600 text-white flex items-center justify-center text-2xl mb-6 shadow-lg shadow-purple-500/30 group-hover:scale-110 transition duration-300">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Transparan & Aman</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Pantau setiap tahapan proses. Notifikasi real-time memastikan Anda selalu tahu status permohonan Anda.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-24 bg-slate-900 text-white overflow-hidden relative">
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-blue-600 rounded-full blur-3xl opacity-20"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 bg-indigo-600 rounded-full blur-3xl opacity-20"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    
                    <div>
                        <span class="text-blue-400 font-bold tracking-widest uppercase text-sm">Persyaratan Penting</span>
                        <h2 class="text-4xl font-bold mt-2 mb-6">Siapkan Dokumen Sebelum Mengajukan</h2>
                        <p class="text-slate-400 text-lg mb-8">Pastikan kelengkapan dokumen fisik maupun digital Anda valid agar proses verifikasi berjalan lancar tanpa penolakan.</p>
                        
                        <div class="bg-slate-800/50 backdrop-blur border border-slate-700 p-6 rounded-2xl mb-6">
                            <h4 class="text-red-400 font-bold mb-2 flex items-center"><i class="fas fa-exclamation-circle mr-2"></i> Peringatan Hukum</h4>
                            <p class="text-slate-300 text-sm">Memberikan keterangan palsu dapat dikenakan sanksi pidana sesuai <strong>UU Keimigrasian</strong>.</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center gap-4 bg-white/5 p-4 rounded-xl border border-white/10 hover:bg-white/10 transition">
                            <div class="w-10 h-10 rounded-full bg-green-500/20 text-green-400 flex items-center justify-center shrink-0">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="font-medium">Surat Lapor Kepolisian (Asli) untuk kasus hilang</span>
                        </div>
                        <div class="flex items-center gap-4 bg-white/5 p-4 rounded-xl border border-white/10 hover:bg-white/10 transition">
                            <div class="w-10 h-10 rounded-full bg-green-500/20 text-green-400 flex items-center justify-center shrink-0">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="font-medium">KTP Elektronik & Kartu Keluarga (Asli & Copy)</span>
                        </div>
                        <div class="flex items-center gap-4 bg-white/5 p-4 rounded-xl border border-white/10 hover:bg-white/10 transition">
                            <div class="w-10 h-10 rounded-full bg-green-500/20 text-green-400 flex items-center justify-center shrink-0">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="font-medium">Fisik Paspor Lama (Untuk kasus rusak)</span>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section id="alur" class="py-24 bg-slate-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="text-blue-600 font-bold uppercase tracking-wider text-sm">Workflow</span>
                    <h2 class="text-3xl font-bold text-slate-900 mt-2">5 Langkah Mudah</h2>
                </div>

                <div class="relative">
                    <div class="hidden md:block absolute top-10 left-0 w-full h-1 bg-slate-200 rounded-full"></div>

                    <div class="grid grid-cols-1 md:grid-cols-5 gap-8 relative z-10">
                        @php
                            $steps = [
                                ['icon' => '1', 'title' => 'Daftar Akun', 'desc' => 'Buat akun dan login.'],
                                ['icon' => '2', 'title' => 'Isi Formulir', 'desc' => 'Input data & upload dok.'],
                                ['icon' => '3', 'title' => 'Verifikasi', 'desc' => 'Pemeriksaan online.'],
                                ['icon' => '4', 'title' => 'Wawancara', 'desc' => 'Datang untuk BAP & Foto.'],
                                ['icon' => 'check', 'title' => 'Selesai', 'desc' => 'SK BAP Diterbitkan.']
                            ];
                        @endphp

                        @foreach($steps as $step)
                        <div class="flex flex-col items-center text-center group">
                            <div class="w-20 h-20 rounded-2xl bg-white border-4 {{ $step['icon'] == 'check' ? 'border-green-500 text-green-500' : 'border-white text-blue-600' }} shadow-xl flex items-center justify-center text-2xl font-bold mb-6 group-hover:-translate-y-2 transition duration-300 {{ $step['icon'] != 'check' ? 'group-hover:border-blue-500 group-hover:text-blue-600' : '' }}">
                                @if($step['icon'] == 'check') <i class="fas fa-check"></i> @else {{ $step['icon'] }} @endif
                            </div>
                            <h4 class="text-lg font-bold text-slate-900 mb-2">{{ $step['title'] }}</h4>
                            <p class="text-sm text-slate-500 px-2">{{ $step['desc'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="text-center mt-20">
                     @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 rounded-full font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-lg shadow-blue-500/40 hover:shadow-blue-500/60 transition-all transform hover:-translate-y-1">
                            Buat Permohonan Sekarang
                        </a>
                     @endif
                </div>
            </div>
        </section>

        <footer class="bg-white border-t border-slate-200 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('img/logo_imigrasi.png') }}" alt="Logo" class="h-10 w-auto opacity-90 grayscale hover:grayscale-0 transition duration-300">
                    <div>
                        <span class="font-bold text-lg text-slate-800 block">Sistem BAP Online</span>
                        <p class="text-slate-500 text-sm">Kantor Imigrasi Kelas I TPI</p>
                    </div>
                </div>
                <div class="text-slate-500 text-sm text-center md:text-right">
                    <p>&copy; {{ date('Y') }} Hak Cipta Dilindungi Undang-Undang.</p>
                    <p class="text-xs mt-1">Didesain untuk Pelayanan Publik yang Lebih Baik.</p>
                </div>
            </div>
        </footer>

    </body>
</html>