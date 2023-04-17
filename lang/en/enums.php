<?php

use App\Enums\LoanRequestStatusEnum;
use App\Enums\StatusEnum;
use App\Enums\GenderEnum;
use App\Enums\UserRoleEnum;
use App\Enums\WeekDaysEnum;

return [

    GenderEnum::class => [
        GenderEnum::MALE    => 'Male',
        GenderEnum::FEMALE  => 'Female',
    ],

    StatusEnum::class => [
        StatusEnum::ACTIVE     => 'Active',
        StatusEnum::SUSPENDED  => 'Suspended',
        StatusEnum::INACTIVE   => 'Inactive',
        StatusEnum::BANNED     => 'Banned',
    ],

    LoanRequestStatusEnum::class => [
        LoanRequestStatusEnum::PENDING  => 'Pending',
        LoanRequestStatusEnum::APPROVED => 'Approved',
        LoanRequestStatusEnum::REJECTED => 'Rejected',
    ],

    UserRoleEnum::class => [
        UserRoleEnum::ADMIN    => 'Admin',
        UserRoleEnum::USER     => 'User',
    ],

    WeekDaysEnum::class => [
        WeekDaysEnum::MONDAY    => 'E Hënë',
        WeekDaysEnum::TUESDAY   => 'E Martë',
        WeekDaysEnum::WEDNESDAY => 'E Mërkure',
        WeekDaysEnum::THURSDAY  => 'E Enjte',
        WeekDaysEnum::FRIDAY    => 'E Premte',
        WeekDaysEnum::SATURDAY  => 'E Shtune',
        WeekDaysEnum::SUNDAY    => 'E Diel',
    ],

];
