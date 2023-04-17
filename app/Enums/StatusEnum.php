<?php

namespace App\Enums;

final class StatusEnum extends Enum
{
    public const ACTIVE     = 'active';
    public const SUSPENDED  = 'suspended';
    public const INACTIVE   = 'inactive';
    public const BANNED     = 'banned';

    public static function default(): string
    {
        return self::ACTIVE;
    }

    public static function registerStatuses(): array
    {
        return [
            self::ACTIVE,
            self::SUSPENDED,
            self::INACTIVE,
            self::BANNED,
        ];
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
