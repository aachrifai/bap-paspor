<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Perbaiki Permohonan BAP') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-red-800 uppercase">Alasan Revisi (Pesan dari Petugas):</h3>
                        <p class="text-sm text-red-700 mt-1 italic">"{{ $bap->catatan_revisi }}"</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('user.bap.update', $bap->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">No. WhatsApp</label>
                        <input type="number" name="no_wa" value="{{ $bap->no_wa }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-bold mb-2">Jenis Layanan</label>
                            <select name="jenis_layanan" class="w-full border rounded px-3 py-2">
                                <option value="reguler" {{ $bap->jenis_layanan == 'reguler' ? 'selected' : '' }}>Reguler</option>
                                <option value="lasles" {{ $bap->jenis_layanan == 'lasles' ? 'selected' : '' }}>Lasles (Percepatan)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">Kategori</label>
                            <select name="kategori" class="w-full border rounded px-3 py-2">
                                <option value="hilang" {{ $bap->kategori == 'hilang' ? 'selected' : '' }}>Kehilangan</option>
                                <option value="rusak" {{ $bap->kategori == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                <option value="beda_data" {{ $bap->kategori == 'beda_data' ? 'selected' : '' }}>Perubahan Data</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Kronologi Singkat</label>
                        <textarea name="kronologi_singkat" rows="4" class="shadow border rounded w-full py-2 px-3">{{ $bap->kronologi_singkat }}</textarea>
                    </div>

                    <div class="mb-6 bg-yellow-50 p-4 rounded border border-yellow-200">
                        <label class="block text-gray-800 text-sm font-bold mb-2">Upload Dokumen Baru (Jika perlu diganti)</label>
                        <p class="text-xs text-gray-500 mb-2">*Kosongkan jika tidak ingin mengubah dokumen yang sudah diupload.</p>
                        <input type="file" name="files[]" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"/>
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline">
                            <i class="fas fa-paper-plane mr-2"></i> Kirim Perbaikan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>