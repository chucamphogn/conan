<?php

namespace App\Manager;

use App\Enums\Provider;
use App\Services\Dropbox\DropboxService;
use App\Services\Google\GoogleServiceDrive;
use App\Services\Service;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Manager;

final class CloudStorage extends Manager
{
    public function getDefaultDriver(): string
    {
        return Provider::GOOGLE()->getValue();
    }

    /**
     * @param null|Provider|string $driver
     *
     * @return FilesystemAdapter|Service
     */
    public function driver($driver = null): Service | FilesystemAdapter
    {
        if ($driver instanceof Provider) {
            $driver = $driver->getValue();
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
