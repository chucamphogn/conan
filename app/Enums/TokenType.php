<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self GOOGLE()
 * @method static self DROP_BOX()
 */
final class TokenType extends Enum
{
    protected static function values(): array
    {
        return [
            'GOOGLE' => 'google',
            'DROP_BOX' => 'drop_box',
        ];
    }
}
