<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('baps', function (Blueprint $table) {
            // Data Identitas Tambahan
            $table->string('tempat_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('agama')->nullable();
            $table->text('alamat_lengkap')->nullable();

            // Data Dokumen
            $table->string('nik_ktp')->nullable();
            $table->date('tgl_keluar_ktp')->nullable();
            $table->string('no_kk')->nullable();
            $table->date('tgl_keluar_kk')->nullable();
            $table->string('no_akta')->nullable();
            $table->date('tgl_keluar_akta')->nullable();
            
            // Data Pejabat (Kasubsi)
            $table->string('nama_kasubsi')->nullable();
            $table->string('nip_kasubsi')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('baps', function (Blueprint $table) {
            $table->dropColumn([
                'tempat_lahir', 'tgl_lahir', 'pendidikan', 'pekerjaan', 'agama', 'alamat_lengkap',
                'nik_ktp', 'tgl_keluar_ktp', 'no_kk', 'tgl_keluar_kk', 'no_akta', 'tgl_keluar_akta',
                'nama_kasubsi', 'nip_kasubsi'
            ]);
        });
    }
};