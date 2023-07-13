<?php

namespace MirakmalSulton\PManager\Providers;

use Illuminate\Support\ServiceProvider;

class PManagerProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $this->publishes([
            __DIR__ . '/../../config/pmanager.php' => config_path('pmanager.php'),
        ]);
    }
}