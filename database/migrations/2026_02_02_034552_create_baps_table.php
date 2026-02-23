<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('baps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Data Pemohon
            $table->string('nama_pemohon');
            $table->string('no_wa');
            $table->enum('jenis_layanan', ['lasles', 'reguler']);
            $table->enum('kategori', ['kehilangan', 'rusak', 'beda_data']);
            $table->text('kronologi_singkat')->nullable(); // Inputan awal user

            // Booking
            $table->date('tanggal_booking');
            $table->string('kode_booking')->unique(); // Generate otomatis nanti (misal: BAP-001)

            // Data Hasil Wawancara BAP (Dibutuhkan oleh Admin saat Wawancara)
            $table->text('hasil_pemeriksaan')->nullable();
            $table->text('alasan')->nullable();
            $table->text('pendapat_petugas')->nullable();
            $table->json('pertanyaan_tambahan')->nullable();
            $table->string('nama_petugas')->nullable();
            $table->string('nip_petugas')->nullable();

            // File Path (Hasil Generate PDF per Tahap)
            $table->string('file_bap')->nullable();   // Hasil Admin
            $table->string('file_bapen')->nullable(); // Hasil Kasi
            $table->string('file_sk')->nullable();    // Hasil Kakan (Kepala Kantor)

            // STATUS LENGKAP
            $table->enum('status', [
                'pending',              // Baru masuk
                'revisi_dokumen',       // Ditolak Admin, suruh revisi
                'validasi_admin',       // Admin sedang cek
                'verifikasi_ok',        // <--- FIX ERROR: Admin acc, siap wawancara
                'proses_bap',           // Sedang / Selesai BAP
                'review_kasubsi',       // Admin sudah selesai, oper ke Kasubsi
                'proses_bapen',         // Kasubsi ACC, oper ke Kasi
                'review_kakan',         // Kasi ACC, oper ke Kakan
                'sk_terbit',            // Selesai
                'selesai'               // Diambil
            ])->default('pending');

            $table->text('catatan_revisi')->nullable(); // Jika ada tolak berkas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baps');
    }
};