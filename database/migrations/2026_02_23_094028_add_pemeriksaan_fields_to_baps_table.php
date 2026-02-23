<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('baps', function (Blueprint $table) {
            $table->string('nomor_surat_bap')->nullable();
            $table->string('keterangan_bap')->nullable();
            $table->string('pangkat_petugas')->nullable();
            $table->string('jabatan_petugas')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('baps', function (Blueprint $table) {
            $table->dropColumn(['nomor_surat_bap', 'keterangan_bap', 'pangkat_petugas', 'jabatan_petugas']);
        });
    }
};