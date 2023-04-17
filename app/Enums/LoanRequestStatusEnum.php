<?php

namespace App\Enums;

class LoanRequestStatusEnum extends Enum
{

    public const PENDING   = 'pending';
    public const APPROVED  = 'approved';
    public const REJECTED  = 'rejected';

    public static function default(): string
    {
        return self::PENDING;
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
