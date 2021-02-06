<?php

namespace App\Models;

use App\Enums\TokenType;
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
     * Lấy tất cả token thuộc về tài khoản đang đăng nhập
     * @return HasMany
     */
    public function cloudStorage(): HasMany
    {
        return $this->hasMany(Token::class);
    }

    /**
     * Lấy các token GoogleDrive của tài khoản đang đăng nhập
     * @return HasMany
     */
    public function googleAccounts(): HasMany
    {
        return $this->hasMany(Token::class)
            ->where('token_type', TokenType::GOOGLE());
    }
}
