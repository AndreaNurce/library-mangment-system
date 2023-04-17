<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use Carbon\Carbon;
use App\Models\User;
use App\Enums\UserRoleEnum;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->create([
            'name'      => 'Super',
            'lastname'  => 'Admin',
            'gender'    => 'M',
            'birthdate' => Carbon::parse('1989-08-05'),
            'role'      => UserRoleEnum::ADMIN,
            'is_banned' => false,
            'status'    => StatusEnum::ACTIVE,
            'email'     => 'admin@admin.com',
            'password'  => Hash::make('password'),
        ]);

        User::query()->create([
            'name'      => 'John',
            'lastname'  => 'Doe',
            'gender'    => 'M',
            'birthdate' => Carbon::parse('1995-06-05'),
            'role'      => UserRoleEnum::USER,
            'is_banned' => false,
            'status'    => StatusEnum::ACTIVE,
            'email'     => 'john@example.com',
            'password'  => Hash::make('password'),
        ]);
    }
}
