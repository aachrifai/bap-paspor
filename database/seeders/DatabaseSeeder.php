<?php

namespace Database\Seeders; // <--- INI YANG HILANG TADI

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Pemohon (User Biasa)
        User::create([
            'name' => 'Budi Pemohon',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // 2. Akun Petugas (Admin BAP)
        User::create([
            'name' => 'Petugas Imigrasi',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'nip' => '199001012023011001'
        ]);

        // 3. Akun Kasubsi (Verifikator)
        User::create([
            'name' => 'Bapak Kasubsi',
            'email' => 'kasubsi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'kasubsi',
            'nip' => '198501012010011002'
        ]);

        // 4. Akun Kasi (Pembuat BAPEN)
        User::create([
            'name' => 'Ibu Kasi',
            'email' => 'kasi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'kasi',
            'nip' => '198001012005012003'
        ]);

        // 5. Akun Kepala Kantor (Pembuat SK)
        User::create([
            'name' => 'Bapak Kakan',
            'email' => 'kakan@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'kakan',
            'nip' => '197501012000011004'
        ]);

        // ... (kode user seeder yang lama biarkan saja) ...

        // 6. SEEDER PERTANYAAN BAP (Standar Imigrasi)
        $pertanyaan = [
            ['urutan' => 1, 'pertanyaan' => 'Apakah Saudara dalam keadaan sehat jasmani dan rohani serta bersedia untuk diperiksa?'],
            ['urutan' => 2, 'pertanyaan' => 'Sebutkan Identitas Diri Saudara selengkapnya (Nama, TTL, Pekerjaan, Alamat)?'],
            ['urutan' => 3, 'pertanyaan' => 'Apakah Saudara pernah memiliki Paspor RI sebelumnya? Jika iya, dimana dibuat dan nomor paspornya?'],
            ['urutan' => 4, 'pertanyaan' => 'Coba ceritakan kronologi kejadian mengapa Paspor Saudara bisa Hilang/Rusak?'],
            ['urutan' => 5, 'pertanyaan' => 'Dimana dan Kapan kejadian tersebut terjadi?'],
            ['urutan' => 6, 'pertanyaan' => 'Apakah ada saksi yang melihat kejadian tersebut?'],
            ['urutan' => 7, 'pertanyaan' => 'Apakah keterangan yang Saudara berikan sudah benar dan jujur tanpa paksaan?'],
        ];

        foreach ($pertanyaan as $tanya) {
            \App\Models\BapQuestion::create($tanya);
        }
    }
}