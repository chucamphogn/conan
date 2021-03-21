<?php

namespace App\Models;

use App\Enums\Provider;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Socialite\Two\User as UserTwo;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Lấy tất cả tài khoản người dùng đã thêm vào.
     *
     * @return HasMany
     */
    public function cloudStorageAccounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    /**
     * Lấy các tài khoản GoogleDrive của tài khoản đang đăng nhập.
     *
     * @return HasMany
     */
    public function googleAccounts(): HasMany
    {
        return $this->hasMany(Account::class)
            ->where('provider', Provider::GOOGLE());
    }

    /**
     * Lấy các tài khoản Dropbox của tài khoản đang đăng nhập.
     *
     * @return HasMany
     */
    public function dropboxAccounts(): HasMany
    {
        return $this->hasMany(Account::class)
            ->where('provider', Provider::DROPBOX());
    }

    /**
     * Thêm tài khoản kho lưu trữ vào cơ sở dữ liệu.
     *
     * @param UserTwo  $userSocialite
     * @param Provider $provider
     *
     * @return Account
     */
    public function addCloudStorageAccount(UserTwo $userSocialite, Provider $provider): Account
    {
        return auth()->user()->cloudStorageAccounts()->create([
            'user_id' => auth()->id(),
            'alias_name' => $userSocialite->getName(),
            'email' => $userSocialite->getEmail(),
            'provider' => $provider,
            'access_token' => $userSocialite->token,
            'refresh_token' => $userSocialite->refreshToken,
            'expires_in' => $userSocialite->expiresIn,
        ]);
    }

    /**
     * Lấy token của tài khoản dựa vào địa chỉ email và kho lưu trữ.
     *
     * @param string $email
     * @param string $provider
     *
     * @return \App\Models\Token
     */
    public function getTokenOf(string $email, string $provider): Token
    {
        /** @var \App\Models\Account $account */
        $account = auth()->user()->cloudStorageAccounts()
            ->where('email', $email)
            ->where('provider', $provider)
            ->sole();

        return $account->token();
    }
}
