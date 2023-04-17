<?php

namespace App\Enums;

final class WeekDaysEnum extends Enum
{
    public const MONDAY    = 'monday';
    public const TUESDAY   = 'tuesday';
    public const WEDNESDAY = 'wednesday';
    public const THURSDAY  = 'thursday';
    public const FRIDAY    = 'friday';
    public const SATURDAY  = 'saturday';
    public const SUNDAY    = 'sunday';

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
