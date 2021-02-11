<?php

namespace App\Services\Providers\Dropbox;

use Illuminate\Support\Carbon;
use Spatie\Dropbox\TokenProvider;

class Token implements TokenProvider
{
    private string $accessToken;
    private ?string $refreshToken;
    private int $expiresIn;
    private Carbon $updatedAt;

    public function __construct(mixed $token)
    {
        $token = collect($token);
        $this->accessToken = $token->get('access_token');
        $this->refreshToken = $token->get('refresh_token');
        $this->expiresIn = $token->get('expires_in');
        $this->updatedAt = Carbon::parse($token->get('updated_at'));
    }

    public function getToken(): string
    {
        return $this->accessToken;
    }

    public function getAccessToken(): mixed
    {
        return $this->accessToken;
    }

    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }

    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updatedAt;
    }

    public function setAccessToken(string $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function setRefreshToken(?string $refreshToken)
    {
        $this->refreshToken = $refreshToken;
    }

    public function setExpiresIn(int $expiresIn)
    {
        $this->expiresIn = $expiresIn;
    }

    public function setUpdatedAt(Carbon $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}
