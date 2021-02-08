<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self GOOGLE()
 * @method static self DROPBOX()
 */
final class TokenType extends Enum
{
    protected static function values(): array
    {
        return [
            'GOOGLE' => 'google',
            'DROPBOX' => 'dropbox',
        ];
    }
}
