<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('baps', function (Blueprint $table) {
            $table->string('nomor_sk')->nullable();
            $table->string('alasan_sk')->nullable(); 
            $table->string('nomor_paspor_lama')->nullable();
            $table->string('kanim_penerbit_lama')->nullable();
            $table->date('tgl_keluar_paspor_lama')->nullable();
            $table->date('tgl_habis_paspor_lama')->nullable();
            $table->string('jabatan_ttd_sk')->nullable(); 
            $table->string('nama_ttd_sk')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('baps', function (Blueprint $table) {
            $table->dropColumn([
                'nomor_sk', 'alasan_sk', 'nomor_paspor_lama', 'kanim_penerbit_lama', 
                'tgl_keluar_paspor_lama', 'tgl_habis_paspor_lama', 'jabatan_ttd_sk', 'nama_ttd_sk'
            ]);
        });
    }
};