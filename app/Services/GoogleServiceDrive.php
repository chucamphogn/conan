<?php

namespace App\Services;

use App\Models\Account;
use Google\Exception as GoogleException;
use Google_Client as GoogleClient;
use Google_Service_Drive as GoogleServiceDriveBase;
use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter;
use Illuminate\Support\Carbon;
use JetBrains\PhpStorm\ArrayShape;
use League\Flysystem\Filesystem;

/**
 * @property GoogleClient       $client
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

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->storage, $name], $arguments);
    }

    public function setToken(mixed $token)
    {
        $this->clearCache();

        $this->client->setAccessToken($this->parseToken($token));

        if ($this->client->isAccessTokenExpired() && $this->client->getRefreshToken()) {
            $refreshToken = $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
            Account::find(collect($token)->get('id'))->update($refreshToken);
        }
    }

    #[ArrayShape(['access_token' => 'string', 'refresh_token' => 'string', 'expires_in' => 'int', 'created' => 'int'])]
    public function parseToken(mixed $token): array
    {
        $token = collect($token);

        return [
            'access_token' => $token->get('access_token'),
            'refresh_token' => $token->get('refresh_token'),
            'expires_in' => $token->get('expires_in'),
            'created' => Carbon::parse($token->get('updated_at'))->timestamp,
        ];
    }

    public function clearCache()
    {
        $this->client->getCache()->clear();
    }
}
