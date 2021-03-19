<?php

namespace App\Services\Google;

use App\Enums\Provider;
use App\Models\Token;
use App\Services\Service;
use Google\Exception as GoogleException;
use Google_Client as GoogleClient;
use Google_Service_Drive as GoogleServiceDriveBase;
use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use ReflectionMethod;

/**
 * @property GoogleClient       $client
 * @property GoogleDriveAdapter $adapter
 */
final class GoogleServiceDrive extends Service
{
    private GoogleServiceDriveBase $service;

    private array $additionalFetchField = [
        'thumbnailLink',
    ];

    private array $defaultParams = [
        // 'files.list' => [
        //     'pageSize' => 15,
        // ],
    ];

    /**
     * @throws GoogleException
     */
    public function __construct()
    {
        $this->client = new GoogleClient();
        $this->client->setAuthConfig(config('services.google'));

        $this->service = new GoogleServiceDriveBase($this->client);

        $this->adapter = new GoogleDriveAdapter($this->service, 'root', [
            'additionalFetchField' => join(',', $this->additionalFetchField),
            'defaultParams' => $this->defaultParams,
        ]);

        Storage::extend(Provider::GOOGLE()->getValue(), function () {
            return new Filesystem($this->adapter);
        });

        $this->storage = Storage::drive(Provider::GOOGLE()->getValue());
    }

    public function setToken(Token $token)
    {
        // Khi thay đổi token thì cần clear cache để token cũ được bỏ, cụ thể xem thêm ở GoogleClient::setAccessToken()
        $this->clearCache();

        $this->client->setAccessToken($token->toGoogleJsonStructure());

        // FixMe: Xảy ra lỗi làm mới access_token khi refresh_token hết hạn. Buộc người dùng đăng nhập lại
        if ($this->client->isAccessTokenExpired() && $this->client->getRefreshToken()) {
            $refreshToken = $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
            $token->update($refreshToken);
        }
    }

    /**
     * Xoá cache Google Service Drive.
     */
    public function clearCache()
    {
        $this->client->getCache()->clear();
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    public function recentlyModifiedFiles(int $limit = 10): Collection
    {
        $normaliseObject = new ReflectionMethod($this->adapter::class, 'normaliseObject');
        $normaliseObject->setAccessible(true);

        $response = $this->service->files->listFiles([
            'pageSize' => $limit,
            'q' => 'mimeType != "application/vnd.google-apps.folder"',
            'fields' => 'files(id,name,mimeType,modifiedTime,parents,permissions,size,webContentLink,webViewLink,thumbnailLink)',
            'orderBy' => 'modifiedTime desc',
        ]);

        $files = collect();

        foreach ($response->getFiles() as $file) {
            $files[] = $normaliseObject->invoke($this->adapter, $file, null);
        }

        return $files;
    }
}
