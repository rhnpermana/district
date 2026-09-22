<?php

namespace App\Providers;

use Illuminate\Console\Events\CommandStarting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; 

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
        // --- TAMBAHAN UNTUK VERCEL: Paksa Laravel menggunakan HTTPS ---
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }
        // --------------------------------------------------------------

        // Kode bawaan kamu sebelumnya untuk Seeder
        $this->app['events']->listen(CommandStarting::class, function (CommandStarting $event) {
            if ($event->command === 'db:seed' && $event->input->getOption('class') === 'fresh') {
                $event->input->setOption('class', 'Database\\Seeders\\DatabaseSeeder');
            }

            if ($event->command === 'migrate:fresh' && $event->input->getOption('seeder') === 'fresh') {
                $event->input->setOption('seeder', 'Database\\Seeders\\DatabaseSeeder');
            }
        });
    }
}