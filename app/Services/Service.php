<?php

namespace App\Services;

use App\Models\Token;
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
     * Xử lý token và gán vào client.
     *
     * @param Token $token
     */
    abstract public function setToken(Token $token);
}
