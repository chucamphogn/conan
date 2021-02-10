<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client as DropboxClient;
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
        $this->token = $this->parseToken($token);

        /**
         * Do thư viện hỗ trợ không tự động làm mới access token khi hết hạn nên phải tự viết hàm làm mới access token
         */
        if ($this->isAccessTokenExpired()) {
            // Lấy access_token mới dựa vào refresh_token
            $newToken = $this->getAccessTokenWithRefreshToken($this->token['refresh_token']);

            // Cập nhật lại access_token trong cơ sở dữ liệu
            $newToken = auth()->user()->dropboxAccounts()->updateOrCreate([
                'id' => $this->token['id'],
            ], $newToken);

            // Gán lại token mới vào DropboxClient
            $this->setToken($newToken);
        }

        $this->client->setAccessToken($this->token['access_token']);
    }

    /**
     * Kiểm tra access token đã hết hạn hay chưa
     *
     * @return bool
     */
    private function isAccessTokenExpired(): bool
    {
        // Lấy ngày cập nhật token + thời gian hết hạn
        $expiredDay = $this->token['updated_at']->addSeconds($this->token['expires_in']);

        // Nếu ngày hết hạn <= ngày hiện tại thì token đã hết hạn
        return $expiredDay->lessThanOrEqualTo(now());
    }

    /**
     * Làm mới access token dựa vào refresh token
     *
     * @param string $refreshToken
     *
     * @return array
     */
    private function getAccessTokenWithRefreshToken(string $refreshToken): array
    {
        $response = Http::withBasicAuth(
            config('services.dropbox.client_id'),
            config('services.dropbox.client_secret')
        )->asForm()->post('https://api.dropbox.com/oauth2/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
        ]);

        return $response->json();
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->storage, $name], $arguments);
    }
}
