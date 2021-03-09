<?php

namespace App\Services;

use App\Enums\Provider;
use App\Models\Token;
use App\Services\Providers\Dropbox\DropboxClient;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client;
use Spatie\FlysystemDropbox\DropboxAdapter;

/**
 * @property DropboxClient  $client
 * @property DropboxAdapter $adapter
 */
final class DropboxService extends Service
{
    public function __construct()
    {
        $clientId = config('services.dropbox.client_id');
        $clientSecret = config('services.dropbox.client_secret');

        $this->client = new DropboxClient([$clientId, $clientSecret]);
        $this->adapter = new DropboxAdapter($this->client);

        Storage::extend(Provider::DROPBOX()->getValue(), function () {
            return new Filesystem($this->adapter, ['case_sensitive' => false]);
        });

        $this->storage = Storage::drive(Provider::DROPBOX()->getValue());
    }

    public function setToken(Token $token)
    {
        $this->client->setAccessToken($token);

        // Xử lý khi access token hết hạn
        if ($this->client->isAccessTokenExpired()) {
            // Lấy access_token mới dựa vào refresh_token, access token sẽ được tự động apply
            $newToken = $this->client->fetchAccessTokenWithRefreshToken();

            $token->update($newToken);
        }
    }

    public function recentlyModifiedFiles(int $limit = 10): Collection
    {
        return parent::recentlyModifiedFiles()
            /*
             * Lấy thumbnail của tệp tin
             * @see https://www.dropbox.com/developers/documentation/http/documentation#files-get_thumbnail
             */
            ->map(function ($file) {
                // Dropbox không hỗ trợ tạo thumbnail với những tệp tin >= 20MB
                if ($file['size'] >= 20_000_000) {
                    return $file;
                }

                $thumbnailLink = Cache::remember(md5($file['path']), 120, function () use ($file) {
                    try {
                        // Dropbox trả hình ảnh về ở dạng binary, cần chuyển về base64 để hiển thị lên website
                        $image = $this->client->getThumbnail($file['path'], size: Client::THUMBNAIL_SIZE_L);

                        return 'data:image/jpeg;base64,' . base64_encode($image);
                    } catch (Exception) {
                        /*
                         * Trả về '' để cache, nếu để null thì không thể cache được
                         * '' có nghĩa là tệp tin này không có thumbnail
                         */
                        return '';
                    }
                });

                $file['thumbnailLink'] = empty($thumbnailLink) ? null : $thumbnailLink;

                return $file;
            });
    }

    public function recentlyModifiedDirectories(int $limit = 10): Collection
    {
        /*
         * Do Dropbox không hỗ trợ "lastModified" của thư mục nên sẽ lấy thời gian chỉnh sửa gần đây nhất của tệp tin
         * trong thư mục đó làm "lastModified" cho thư mục
         *
         * FixMe: Chưa tối ưu vì tốn rất nhiều request để lấy thông tin "Thời gian sửa đổi" của thư mục
         */
        return collect($this->directories())
            ->map(function ($directory) {
                $lastModified = collect($this->allFiles($directory['path']))->max('timestamp');
                $directory['timestamp'] = $lastModified;

                return $directory;
            })
            ->sortByDesc('timestamp')
            ->take($limit);
    }
}
