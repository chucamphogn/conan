<?php

namespace App\Models;

use App\Enums\TokenType;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'token_type',
        'access_token',
        'refresh_token',
        'expires_in',
    ];
    protected $casts = [
        'token_type' => TokenType::class,
    ];

    public function user()
    {
        $this->morphTo();
    }
}
