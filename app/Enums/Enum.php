<?php

namespace App\Enums;

use App\Exceptions\EnumClassCannotBeInitiated;
use ReflectionClass;

abstract class Enum
{
    public static function toArray(bool $associative = false): array
    {
        $constants = (new ReflectionClass(static::class))->getConstants();
        return array_combine($constants, $constants);
    }

    public static function toString(string $glue = ','): string
    {
        //$glue = ',';
        return implode($glue, self::toArray());
    }
}
