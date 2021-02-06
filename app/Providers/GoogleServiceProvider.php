<?php

namespace App\Providers;

use Google_Client;
use Illuminate\Support\ServiceProvider;

class GoogleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Google_Client::class, function () {
            $client = new Google_Client();
            $client->setAuthConfig(config('services.google'));

            return $client;
        });
    }

    public function boot()
    {
        //
    }
}
