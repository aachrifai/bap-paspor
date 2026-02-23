<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bap extends Model
{
    use HasFactory;

    // KITA GANTI $fillable MENJADI $guarded = [];
    // Artinya: Izinkan semua kolom diisi (termasuk kolom baru pertanyaan_tambahan, dll)
    // Ini jauh lebih fleksibel daripada menulis satu per satu.
    protected $guarded = []; 

    // Relasi 1: BAP milik satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi 2: BAP punya banyak Lampiran (Attachments)
    public function attachments()
    {
        return $this->hasMany(BapAttachment::class);
    }
}