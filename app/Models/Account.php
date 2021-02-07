<?php

namespace App\Models;

use App\Enums\TokenType;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use Uuid;

    protected $fillable = [
        'user_id',
        'alias_name',
        'email',
        'token_type',
        'access_token',
        'refresh_token',
        'expires_in',
    ];

    protected $casts = [
        'token_type' => TokenType::class,
    ];

    public $timestamps = false;

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
