<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('baps', function (Blueprint $table) {
            
            // 1. Cek dulu, kalau kolom 'hasil_pemeriksaan' BELUM ada, baru buat.
            if (!Schema::hasColumn('baps', 'hasil_pemeriksaan')) {
                $table->text('hasil_pemeriksaan')->nullable();
            }

            // 2. Cek 'alasan'
            if (!Schema::hasColumn('baps', 'alasan')) {
                $table->string('alasan')->nullable();
            }

            // 3. Cek 'pendapat_petugas'
            if (!Schema::hasColumn('baps', 'pendapat_petugas')) {
                $table->text('pendapat_petugas')->nullable();
            }

            // 4. Cek 'pertanyaan_tambahan' (Target Utama)
            if (!Schema::hasColumn('baps', 'pertanyaan_tambahan')) {
                $table->text('pertanyaan_tambahan')->nullable();
            }

            // 5. Jaga-jaga jika kolom petugas belum ada juga
            if (!Schema::hasColumn('baps', 'nama_petugas')) {
                $table->string('nama_petugas')->nullable();
            }
            if (!Schema::hasColumn('baps', 'nip_petugas')) {
                $table->string('nip_petugas')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('baps', function (Blueprint $table) {
            // Kita biarkan kosong agar aman saat rollback sebagian
            // atau bisa drop column satu per satu jika mau strict
        });
    }
};