<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BapQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['pertanyaan', 'urutan', 'is_active'];
}