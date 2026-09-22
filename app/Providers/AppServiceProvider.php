<?php

namespace App\Providers;

use Illuminate\Console\Events\CommandStarting;
use Illuminate\Support\ServiceProvider;

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
