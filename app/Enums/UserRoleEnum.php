<?php

namespace App\Enums;

final class UserRoleEnum extends Enum
{
    public const ADMIN = 1;
    public const USER  = 2;

    public static function default(): int
    {
        return self::USER;
    }

    public static function toArrayWithLabels(): array
    {
        return collect(self::toArray())->map(function ($item) {
            $enum = self::class;
            return __("enums.$enum.$item");
        })->toArray();
    }

    public static function getLabel(string $type): string
    {
        $enum = self::class;
        return __("enums.$enum.$type");
    }
}
