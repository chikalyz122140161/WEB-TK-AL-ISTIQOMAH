<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    // Function ini menjalankan logika {register} pada file ini.
    // Secara umum function ini membantu controller, model, atau service menyelesaikan tugas tertentu di aplikasi.
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    // Function ini menjalankan logika {boot} pada file ini.
    // Secara umum function ini membantu controller, model, atau service menyelesaikan tugas tertentu di aplikasi.
    public function boot(): void
    {
        Carbon::setLocale('id');
    }
}
