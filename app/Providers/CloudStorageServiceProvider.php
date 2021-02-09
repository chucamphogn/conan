<?php

namespace App\Providers;

use Google_Client as GoogleClient;
use Google_Service_Drive as GoogleServiceDrive;
use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client as DropboxClient;
use Spatie\FlysystemDropbox\DropboxAdapter;

class CloudStorageServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Storage::extend('google', function ($app, $config) {
            $client = new GoogleClient();
            $client->setAuthConfig(config('services.google'));

            $service = new GoogleServiceDrive($client);

            $adapter = new GoogleDriveAdapter($service, 'root', [
                'additionalFetchField' => 'trashed'
            ]);

            return new Filesystem($adapter);
        });

        Storage::extend('dropbox', function ($app, $config) {
            $client = new DropboxClient();

            $adapter = new DropboxAdapter($client);

            return new Filesystem($adapter, ['case_sensitive' => false]);
        });
    }

    public function register()
    {
        //
    }
}
