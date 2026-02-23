<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BapAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'bap_id',
        'jenis_file', // KTP, KK, Surat Lapor
        'path_file'
    ];

    // Relasi: Lampiran ini milik satu BAP
    public function bap()
    {
        return $this->belongsTo(Bap::class);
    }
}