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
    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    protected static function values(): Closure
    {
        return function (string $name): string {
            return mb_strtolower($name);
        };
    }
}
