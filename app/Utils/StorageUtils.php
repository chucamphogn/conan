<?php

namespace App\Utils;

use App\Enums\Provider;
use App\Models\Account;
use Google\Client as GoogleClient;
use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client as DropboxClient;
use Spatie\FlysystemDropbox\DropboxAdapter;

final class StorageUtils
{
    /**
     * Gán token vào client
     * Nếu cần thay đổi token của Google thì phải gọi hàm `StorageUtils#clearGoogleAccessToken`
     *
     * @param string|Provider $driver
     * @param Account $account
     * @see StorageUtils::clearGoogleAccessToken()
     */
    public static function setAccessToken(string|Provider $driver, Account $account)
    {
        if ($driver instanceof Provider) {
            $driver = $driver->value;
        }

        $method = Str::camel("get_{$driver}_client");

        $client = StorageUtils::{$method}();

        if ($driver === Provider::DROPBOX()->value) {
            $client->setAccessToken($account->access_token);
        } else {
            $client->setAccessToken($account->toJson());
        }
    }

    /**
     * Xoá token của Google
     * Cách này sẽ xoá luôn cache của Google
     */
    public static function clearGoogleAccessToken()
    {
        $client = self::getGoogleClient();

        $client->getCache()->clear();
    }

    /**
     * Trả về Google client
     *
     * @return GoogleClient
     */
    public static function getGoogleClient(): GoogleClient
    {
        /** @var Filesystem|FilesystemAdapter $storage */
        $storage = Storage::disk('google');

        /** @var GoogleDriveAdapter $googleDriveAdapter */
        $googleDriveAdapter = $storage->getAdapter();

        return $googleDriveAdapter->getService()->getClient();
    }

    /**
     * Trả về Dropbox client
     *
     * @return DropboxClient
     */
    public static function getDropboxClient(): DropboxClient
    {
        /** @var Filesystem|FilesystemAdapter $storage */
        $storage = Storage::disk('dropbox');

        /** @var DropboxAdapter $dropboxAdapter */
        $dropboxAdapter = $storage->getAdapter();

        return $dropboxAdapter->getClient();
    }
}
