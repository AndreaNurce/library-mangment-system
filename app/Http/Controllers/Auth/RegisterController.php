<?php

namespace App\Http\Controllers\Auth;

use App\Concerns\RedirectUser;
use App\Models\User;
use App\Enums\GenderEnum;
use App\Enums\StatusEnum;
use App\Enums\UserRoleEnum;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    use RedirectUser;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'      => ['required', 'string', 'max:255'],
            'lastname'  => ['required', 'string', 'max:255'],
            'gender'    => ['required', 'string', 'in:'.GenderEnum::toString()],
            'birthdate' => ['required', 'date'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
        ]);
    }

    protected function create(array $data)
    {
        try {
            return User::create([
                'name'      => $data['name'],
                'lastname'  => $data['lastname'],
                'gender'    => $data['gender'],
                'birthdate' => $data['birthdate'],
                'role'      => UserRoleEnum::USER,
                'is_banned' => false,
                'status'    => StatusEnum::ACTIVE,
                'email'     => $data['email'],
                'password'  => Hash::make($data['password']),
            ]);

        } catch (\Throwable $th) {
            report($th);
        }
    }

    protected function registered(Request $request, $user)
    {
        return redirect()
            ->intended($this->redirectTo())
            ->with('success', 'Welcome:  '. $user->name . ' you are registered');
    }
}
