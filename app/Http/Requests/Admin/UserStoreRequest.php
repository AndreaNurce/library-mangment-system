<?php

namespace App\Http\Requests\Admin;

use App\Enums\GenderEnum;
use App\Enums\StatusEnum;
use App\Enums\UserRoleEnum;
use App\Rules\ISBN;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'name'       => ['required','string','min:3','max:191'],
            'lastname'   => ['required','string','min:3','max:191'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'string',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()],
            'gender'    => ['required', 'string', 'in:'.GenderEnum::toString()],
            'birthdate' => ['required','date', 'before:today'],
            'role'     => ['required', 'numeric', 'in:'.UserRoleEnum::toString()],
            'status'     => ['required', 'string', 'in:'.StatusEnum::toString()],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'      => __('Emri'),
            'lastname'  => __('Mbiemri'),
            'email'     => __('Email'),
            'password'  => __('Fjalekalimi'),
            'gender'    => __('Gjinia'),
            'birthdate' => __('Datelindja'),
            'role'      => __('Roli'),
            'status'    => __('statusi'),
        ];
    }
}
