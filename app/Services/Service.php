<?php

namespace App\Services;

use App\Models\Token;
use Illuminate\Filesystem\FilesystemAdapter;
use League\Flysystem\AdapterInterface;

abstract class Service
{
    protected mixed $client;

    protected AdapterInterface $adapter;

    protected FilesystemAdapter $storage;

    public function __call($method, array $parameters)
    {
        return call_user_func_array([$this->storage, $method], $parameters);
    }

    /**
     * Xử lý token và gán vào client.
     *
     * @param Token $token
     */
    abstract public function setToken(Token $token);

    /**
     * Lấy toàn bộ thư mục có trên kho lưu trữ.
     *
     * @param null|string $directory
     *
     * @return array
     */
    public function allDirectories(?string $directory = null): array
    {
        $contents = $this->storage->listContents($directory, true);

        return $this->filterContentsByType($contents, 'dir');
    }

    /**
     * Lọc thông tin tệp dựa vào kiểu tệp.
     *
     * @param array  $contents
     * @param string $type
     *
     * @return array
     */
    protected function filterContentsByType(array $contents, string $type): array
    {
        return collect($contents)
            ->where('type', $type)
            ->values()
            ->all();
    }
}
