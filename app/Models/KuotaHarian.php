<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuotaHarian extends Model
{
    use HasFactory;
    
    // Ubah fillable menjadi ini:
    protected $fillable = ['tanggal', 'kuota_reguler', 'kuota_lasles'];
}