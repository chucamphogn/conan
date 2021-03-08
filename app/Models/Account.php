<?php

namespace App\Models;

use App\Enums\Provider;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use Uuid;

    protected $fillable = [
        'user_id',
        'alias_name',
        'email',
        'provider',
        'access_token',
        'refresh_token',
        'expires_in',
    ];

    protected $casts = [
        'provider' => Provider::class,
    ];

    protected $hidden = ['access_token', 'refresh_token', 'expires_in'];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    /**
     * Map thông tin token vào class Token.
     *
     * @return Token
     *
     * @see Token
     */
    public function token(): Token
    {
        $token = new Token();

        $token->setAccessToken($this->getAttribute('access_token'))
            ->setRefreshToken($this->getAttribute('refresh_token'))
            ->setExpiresIn($this->getAttribute('expires_in'))
            ->setCreatedAt($this->getAttribute('updated_at'));

        return $token;
    }
}
