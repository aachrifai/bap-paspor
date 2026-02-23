<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <x-slot name="header">
        <h2 class="flex items-center font-semibold text-xl text-gray-800 leading-tight">
            
            <a href="{{ route('user.dashboard') }}" class="inline-flex items-center justify-center w-10 h-10 bg-white rounded-full shadow-sm border border-gray-200 text-gray-400 hover:text-blue-600 mr-4 transition transform hover:-translate-x-1" title="Kembali ke Riwayat">
                <i class="fas fa-arrow-left"></i>
            </a>

            Detail Permohonan <span class="text-blue-600 ml-2">#{{ $bap->kode_booking }}</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white p-6 rounded-xl shadow-sm mb-6 border-l-4 {{ $bap->status == 'pending' ? 'border-yellow-400' : ($bap->status == 'revisi_dokumen' ? 'border-red-500' : 'border-blue-500') }}">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold">Status Permohonan</p>
                        <h3 class="text-lg font-bold text-gray-800 mt-1">
                            @if($bap->status == 'pending') Menunggu Validasi Admin
                            @elseif($bap->status == 'revisi_dokumen') Perlu Perbaikan (Revisi)
                            @elseif($bap->status == 'sk_terbit') Selesai (SK Terbit)
                            @else Sedang Diproses
                            @endif
                        </h3>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500">Tanggal Pengajuan</p>
                        <p class="font-medium">{{ \Carbon\Carbon::parse($bap->created_at)->translatedFormat('d F Y, H:i') }} WIB</p>
                    </div>
                </div>
                
                @if($bap->status == 'revisi_dokumen' && $bap->catatan_revisi)
                    <div class="mt-4 bg-red-50 p-3 rounded border border-red-200">
                        <p class="text-red-700 text-sm font-bold"><i class="fas fa-exclamation-circle"></i> Catatan Petugas:</p>
                        <p class="text-red-600 text-sm mt-1">{{ $bap->catatan_revisi }}</p>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <h4 class="font-bold text-gray-700 mb-4 border-b pb-2"><i class="fas fa-file-alt mr-2 text-blue-500"></i> Data Pengajuan</h4>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <label class="text-gray-500 text-xs uppercase">Nama Pemohon</label>
                                <p class="font-semibold text-gray-800">{{ $bap->nama_pemohon }}</p>
                            </div>
                            <div>
                                <label class="text-gray-500 text-xs uppercase">No. WhatsApp</label>
                                <p class="font-semibold text-gray-800">{{ $bap->no_wa }}</p>
                            </div>
                            <div>
                                <label class="text-gray-500 text-xs uppercase">Jenis Layanan</label>
                                <p class="font-semibold text-gray-800 uppercase">{{ $bap->jenis_layanan }}</p>
                            </div>
                            <div>
                                <label class="text-gray-500 text-xs uppercase">Kategori</label>
                                <p class="font-semibold text-gray-800 capitalize">{{ str_replace('_', ' ', $bap->kategori) }}</p>
                            </div>
                            <div>
                                <label class="text-gray-500 text-xs uppercase">Rencana Kedatangan</label>
                                <p class="font-semibold text-blue-600">
                                    <i class="far fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($bap->tanggal_booking)->translatedFormat('d F Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="text-gray-500 text-xs uppercase">Kronologi Kejadian</label>
                            <div class="bg-gray-50 p-3 rounded text-gray-700 text-sm mt-1 border">
                                {{ $bap->kronologi_singkat }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-1">
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <h4 class="font-bold text-gray-700 mb-4 border-b pb-2"><i class="fas fa-paperclip mr-2 text-blue-500"></i> Berkas Lampiran</h4>
                        
                        @if($bap->attachments->count() > 0)
                            <div class="space-y-3">
                                @foreach($bap->attachments as $file)
                                <div class="flex items-center p-2 border rounded hover:bg-gray-50 transition">
                                    <div class="mr-3 text-blue-500">
                                        <i class="fas fa-file-alt text-2xl"></i>
                                    </div>
                                    <div class="flex-1 min-w-0 overflow-hidden">
                                        <p class="text-xs font-bold text-gray-700 truncate">{{ $file->jenis_file }}</p>
                                        <a href="{{ asset('storage/' . $file->path_file) }}" target="_blank" class="text-xs text-blue-600 hover:underline block truncate">
                                            Lihat File
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-400 italic">Tidak ada lampiran.</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>