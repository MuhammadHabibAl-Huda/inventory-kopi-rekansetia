<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set zona waktu default ke WIB (Asia/Jakarta)
        date_default_timezone_set('Asia/Jakarta');

        // Set bahasa tanggal Carbon ke Bahasa Indonesia
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
    }
}