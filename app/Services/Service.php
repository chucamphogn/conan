<?php

namespace App\Services;

use App\Models\Token;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Collection;
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
     * @param null|string $directory Lấy n thư mục trong $directory, nếu để trống thì sẽ duyệt từ root
     * @param bool        $recursive Cho phép duyệt đệ quy để lấy luôn những thư mục con
     *
     * @return array Danh sách thư mục
     */
    public function directories(?string $directory = null, bool $recursive = false): array
    {
        $contents = $this->storage->listContents($directory, $recursive);

        return $this->filterContentsByType($contents, 'dir');
    }

    /**
     * @param null|string $directory Lấy n thư mục trong $directory, nếu để trống thì sẽ duyệt từ root
     *
     * @return array Danh sách thư mục
     */
    public function allDirectories(?string $directory = null): array
    {
        return $this->directories($directory, true);
    }

    /**
     * @param null|string $directory Lấy n tệp tin trong $directory, nếu để trống thì sẽ duyệt từ root
     * @param bool        $recursive Duyệt đệ quy để lấy các tệp tin con
     *
     * @return array Danh sách thư mục
     */
    public function files(?string $directory = null, bool $recursive = false): array
    {
        $contents = $this->storage->listContents($directory, $recursive);

        return $this->filterContentsByType($contents, 'file');
    }

    /**
     * @param null|string $directory Lấy n tệp tin trong $directory, nếu để trống thì sẽ duyệt từ root
     *
     * @return array Danh sách thư mục
     */
    public function allFiles(?string $directory = null): array
    {
        return $this->files($directory, true);
    }

    /**
     * Lấy danh sách tệp tin có lần sửa đổi gần đây nhất.
     *
     * @param int $limit Giới hạn lấy ra n tệp tin
     *
     * @return Collection Danh sách tệp tin
     */
    public function recentlyModifiedFiles(int $limit = 10): Collection
    {
        return collect($this->allFiles())->sortByDesc('timestamp')->take($limit);
    }

    /**
     * Lấy danh sách thư mục có lần sửa đổi gần đây nhất.
     *
     * @param int $limit Giới hạn lấy ra n thư mục
     *
     * @return Collection Danh sách thư mục
     */
    public function recentlyModifiedDirectories(int $limit = 10): Collection
    {
        return collect($this->directories())->sortByDesc('timestamp')->take($limit);
    }

    protected function filterContentsByType(array $contents, string $type): array
    {
        return collect($contents)
            ->where('type', $type)
            ->values()
            ->all();
    }
}
