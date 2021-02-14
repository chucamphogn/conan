<?php

namespace App\Services\Providers\Dropbox;

use App\Models\Token as BaseToken;
use JetBrains\PhpStorm\Pure;
use Spatie\Dropbox\TokenProvider;

/**
 * Tuỳ chỉnh lại lớp Token cho phù hợp với Dropbox Client.
 */
class Token extends BaseToken implements TokenProvider
{
    public function __construct(BaseToken $token)
    {
        $this->setAccessToken($token->getAccessToken());
        $this->setRefreshToken($token->getRefreshToken());
        $this->setExpiresIn($token->getExpiresIn());
        $this->setCreatedAt($token->getCreatedAt());
    }

    #[Pure]
    public function getToken(): string
    {
        return $this->getAccessToken();
    }
}
