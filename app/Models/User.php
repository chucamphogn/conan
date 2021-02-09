<?php

namespace App\Models;

use App\Enums\Provider;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Uuid;

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
     * Lấy tất cả tài khoản người dùng đã thêm vào
     *
     * @return HasMany
     */
    public function cloudStorage(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    /**
     * Lấy các tài khoản GoogleDrive của tài khoản đang đăng nhập
     *
     * @return HasMany
     */
    public function googleAccounts(): HasMany
    {
        return $this->hasMany(Account::class)
            ->where('provider', Provider::GOOGLE());
    }

    /**
     * Lấy các tài khoản Dropbox của tài khoản đang đăng nhập
     *
     * @return HasMany
     */
    public function dropboxAccounts(): HasMany
    {
        return $this->hasMany(Account::class)
            ->where('provider', Provider::DROPBOX());
    }
}
