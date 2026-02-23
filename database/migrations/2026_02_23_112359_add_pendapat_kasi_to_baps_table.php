<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('baps', function (Blueprint $table) {
            $table->json('pendapat_kasi')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('baps', function (Blueprint $table) {
            $table->dropColumn('pendapat_kasi');
        });
    }
};