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

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
