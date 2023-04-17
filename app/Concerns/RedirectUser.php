<?php

namespace App\Concerns;

use Illuminate\Support\Facades\Auth;

trait RedirectUser
{
    public function redirectTo(): string
    {
        if (session()->has('redirect_url')) {
            return session()->get('redirect_url');
        }

        if (! Auth::check()) {
            return route('home');
        }

        if (Auth::user()->isAdmin()) {
            return route('admin.dashboard');
        }

        return route('home');
    }
}
