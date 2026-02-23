<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon; // <--- TAMBAHKAN INI

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Set lokalisasi waktu ke Bahasa Indonesia
        Carbon::setLocale('id');
    }
}