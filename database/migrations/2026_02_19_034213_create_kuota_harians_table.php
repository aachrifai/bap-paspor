<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('kuota_harians', function (Blueprint $table) {
        $table->id();
        $table->date('tanggal')->unique();
        $table->integer('kuota_reguler')->default(3); // Default reguler
        $table->integer('kuota_lasles')->default(2);  // Default lasles
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuota_harians');
    }
};
