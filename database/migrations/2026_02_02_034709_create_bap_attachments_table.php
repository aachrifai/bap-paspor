<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('bap_attachments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('bap_id')->constrained()->onDelete('cascade');
        $table->string('jenis_file'); // KTP, KK, Surat Lapor Polisi
        $table->string('path_file');  // Lokasi penyimpanan
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bap_attachments');
    }
};
