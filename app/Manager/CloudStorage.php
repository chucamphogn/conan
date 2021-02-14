<?php

namespace App\Manager;

use App\Enums\Provider;
use App\Services\DropboxService;
use App\Services\GoogleServiceDrive;
use App\Services\Service;
use Illuminate\Support\Manager;

class CloudStorage extends Manager
{
    public function getDefaultDriver(): string
    {
        return 'google';
    }

    public function driver($driver = null): Service
    {
        if ($driver instanceof Provider) {
            $driver = $driver->value;
        }

        return parent::driver($driver);
    }

    public function createGoogleDriver(): GoogleServiceDrive
    {
        return new GoogleServiceDrive();
    }

    public function createDropboxDriver(): DropboxService
    {
        return new DropboxService();
    }
}
