<?php

namespace App\Services;

use Google\Exception as GoogleException;
use Google_Client as GoogleClient;
use Google_Service_Drive as GoogleServiceDriveBase;
use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter;
use League\Flysystem\Filesystem;

/**
 * @property GoogleClient $client
 * @property GoogleDriveAdapter $adapter
 */
final class GoogleServiceDrive extends Service
{
    private GoogleServiceDriveBase $service;

    /**
     * @throws GoogleException
     */
    public function __construct()
    {
        $this->client = new GoogleClient();
        $this->client->setAuthConfig(config('services.google'));

        $this->service = new GoogleServiceDriveBase($this->client);

        $this->adapter = new GoogleDriveAdapter($this->service, 'root', [
            'additionalFetchField' => 'trashed',
        ]);

        $this->storage = new Filesystem($this->adapter);
    }

    public function clearCache()
    {
        $this->client->getCache()->clear();
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->storage, $name], $arguments);
    }
}
