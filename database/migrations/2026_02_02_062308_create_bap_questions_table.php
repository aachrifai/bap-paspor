<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('bap_questions', function (Blueprint $table) {
        $table->id();
        $table->text('pertanyaan'); // Isi pertanyaan
        $table->string('variable_name')->nullable(); // Untuk mapping (opsional)
        $table->integer('urutan')->default(0); // Agar bisa diurutkan
        $table->boolean('is_active')->default(true); // Bisa dimatikan jika tidak dipakai
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bap_questions');
    }
};
