<?php

namespace App\Services;

use Carbon\Carbon;
use League\Flysystem\AdapterInterface;
use League\Flysystem\Filesystem;

/**
 * @method array listContents($directory = '', $recursive = false)
 */
abstract class Service
{
    protected mixed $client;

    protected AdapterInterface $adapter;

    protected Filesystem $storage;

    /**
     * @var array<string, string, string, int, Carbon>
     */
    protected array $token = [
        'id' => '',
        'access_token' => '',
        'refresh_token' => '',
        'expires_in' => 0,
        'updated_at' => null,
    ];

    public function setToken(mixed $token)
    {
        $this->clearCache();
        $this->token = $this->parseToken($token);
        call_user_func_array([$this->client, 'setAccessToken'], (array) json_encode($this->token, true));
    }

    public function clearCache()
    {
    }

    protected function parseToken(mixed $token): array
    {
        $token = collect($token)->only('id', 'access_token', 'refresh_token', 'expires_in', 'updated_at')->toArray();

        $token['updated_at'] = Carbon::parse($token['updated_at']);

        return $token;
    }
}
