<?php

namespace App\Enums;

final class GenderEnum extends Enum
{
    public const MALE   = 'M';
    public const FEMALE = 'F';

    public static function default(): string
    {
        return self::MALE;
    }

    public static function genders(): array
    {
        return [
            self::MALE,
            self::FEMALE,
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
