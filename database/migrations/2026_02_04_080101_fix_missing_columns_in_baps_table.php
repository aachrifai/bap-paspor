<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('baps', function (Blueprint $table) {
            
            // 1. Cek & Buat 'hasil_pemeriksaan'
            if (!Schema::hasColumn('baps', 'hasil_pemeriksaan')) {
                $table->text('hasil_pemeriksaan')->nullable();
            }

            // 2. Cek & Buat 'alasan'
            if (!Schema::hasColumn('baps', 'alasan')) {
                $table->string('alasan')->nullable();
            }

            // 3. Cek & Buat 'pendapat_petugas'
            if (!Schema::hasColumn('baps', 'pendapat_petugas')) {
                $table->text('pendapat_petugas')->nullable();
            }

            // 4. Cek & Buat 'pertanyaan_tambahan'
            if (!Schema::hasColumn('baps', 'pertanyaan_tambahan')) {
                $table->text('pertanyaan_tambahan')->nullable();
            }

            // 5. Cek & Buat 'nama_petugas' (INI YANG BIKIN ERROR TADI)
            if (!Schema::hasColumn('baps', 'nama_petugas')) {
                $table->string('nama_petugas')->nullable();
            }

            // 6. Cek & Buat 'nip_petugas'
            if (!Schema::hasColumn('baps', 'nip_petugas')) {
                $table->string('nip_petugas')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('baps', function (Blueprint $table) {
            // Biarkan kosong agar aman
        });
    }
};