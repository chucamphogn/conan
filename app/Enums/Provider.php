<?php

namespace App\Enums;

use Closure;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self GOOGLE()
 * @method static self DROPBOX()
 */
final class Provider extends Enum
{
    protected static function values(): Closure
    {
        return function (string $name): string {
            return mb_strtolower($name);
        };
    }
}
