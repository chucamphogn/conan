<?php

namespace App\Services;

use App\Models\Account;
use App\Services\Providers\Dropbox\DropboxClient;
use League\Flysystem\Filesystem;
use Spatie\FlysystemDropbox\DropboxAdapter;

/**
 * @property DropboxClient $client
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
        $this->storage = new Filesystem($this->adapter, ['case_sensitive' => false]);
    }

    /**
     * Xử lý token khi gán vào Dropbox API
     *
     * @param mixed $token
     */
    public function setToken(mixed $token)
    {
        $this->client->setAccessToken($token);

        // Xử lý khi access token hết hạn
        if ($this->client->isAccessTokenExpired()) {
            // Lấy access_token mới dựa vào refresh_token
            $newToken = $this->client->fetchAccessTokenWithRefreshToken();

            // Trích 2 trường access_token và expires_in của token mới để cập nhật vào csdl
            $values = collect($newToken)->only('access_token', 'expires_in')->toArray();

            // Cập nhật lại access_token và expires_in trong cơ sở dữ liệu
            $newToken = tap(Account::find(collect($token)->get('id')))->update($values);

            // Gán lại token vào client
            $this->setToken($newToken);
        }
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->storage, $name], $arguments);
    }
}
