<?php

namespace App\Services\Dropbox;

use App\Models\Token as BaseToken;
use Illuminate\Support\Facades\Http;
use JetBrains\PhpStorm\ArrayShape;
use ReflectionProperty;
use Spatie\Dropbox\Client;

/**
 * Do lớp Spatie\Dropbox\Client để tokenProvider ở private nên phải dùng Reflection để có thể thao tác với
 * tokenProvider trong lớp Spatie\Dropbox\Client.
 */
final class DropboxClient extends Client
{
    /**
     * Lấy access token từ client.
     *
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->getTokenProvider()->getToken();
    }

    /**
     * Gán token vào client.
     *
     * @param BaseToken|string $accessToken
     *
     * @return $this
     */
    public function setAccessToken(BaseToken | string $accessToken): self
    {
        $this->setTokenProvider(new Token($accessToken));

        return $this;
    }

    /**
     * Kiểm tra xem access token đã hết hạn hay chưa.
     *
     * @return bool
     */
    public function isAccessTokenExpired(): bool
    {
        $tokenProvider = $this->getTokenProvider();

        // Ngày hết hạn access token
        $expiredDay = $tokenProvider->getCreatedAt()->addSeconds($tokenProvider->getExpiresIn());

        // Ngày hết hạn <= ngày hiện tại => Token đã hết hạn
        return $expiredDay->lessThanOrEqualTo(now());
    }

    /**
     * Trả về thông tin access token sau khi được làm mới.
     *
     * @return array
     */
    #[ArrayShape(['access_token' => 'string', 'expires_in' => 'int'])]
    public function fetchAccessTokenWithRefreshToken(): array
    {
        $currentToken = $this->getTokenProvider();

        // Gửi yêu cầu làm mới access token
        $newToken = Http::withBasicAuth(
            config('services.dropbox.client_id'),
            config('services.dropbox.client_secret')
        )->asForm()->post('https://api.dropbox.com/oauth2/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $currentToken->getRefreshToken(),
        ])->json();

        $currentToken->setAccessToken($newToken['access_token']);
        $currentToken->setExpiresIn($newToken['expires_in']);

        // Apply thông tin token mới vào Dropbox Client
        $this->setTokenProvider($currentToken);

        // Trả về thông tin access token mới
        return [
            'access_token' => $currentToken->getAccessToken(),
            'expires_in' => $currentToken->getExpiresIn(),
        ];
    }

    /**
     * Trả về ReflectionProperty truy cập vào biến private tokenProvider.
     *
     * @return ReflectionProperty
     */
    private function getTokenProviderReflection(): ReflectionProperty
    {
        $reflectionProperty = new ReflectionProperty(parent::class, 'tokenProvider');
        $reflectionProperty->setAccessible(true);

        return $reflectionProperty;
    }

    /**
     * Trả về giá trị của token provider dựa vào ReflectionProperty.
     *
     * @param null|ReflectionProperty $reflectionProperty
     *
     * @return Token
     */
    private function getTokenProvider(?ReflectionProperty $reflectionProperty = null): Token
    {
        $reflectionProperty = $reflectionProperty ?: $this->getTokenProviderReflection();

        return $reflectionProperty->getValue($this);
    }

    /**
     * Gán giá trị vào tokenProvider dựa vào ReflectionProperty.
     *
     * @param Token                   $token
     * @param null|ReflectionProperty $reflectionProperty
     */
    private function setTokenProvider(Token $token, ?ReflectionProperty $reflectionProperty = null)
    {
        $reflectionProperty = $reflectionProperty ?: $this->getTokenProviderReflection();

        $reflectionProperty->setValue($this, $token);
    }
}
