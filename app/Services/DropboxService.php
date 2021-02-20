<?php

namespace App\Services;

use App\Models\Token;
use App\Services\Providers\Dropbox\DropboxClient;
use League\Flysystem\Filesystem;
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
        $this->storage = new Filesystem($this->adapter, ['case_sensitive' => false]);
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->storage, $name], $arguments);
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
}
