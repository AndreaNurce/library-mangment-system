<?php

namespace App\Http\Middleware;

use App\Enums\StatusEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CanLoan
{

    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            session()->flash('info', 'Perdoruesi duhet te jete i loguar qe te vazhdoje me tej');
            return redirect()->route('login');
        }

        if (!Auth::user()->isUser()) {
            session()->flash('info', 'Librat mund te huazohen vetem nga perdoruesit');
            return redirect()->back();
        }

        if (Auth::user()->isBanned()) {
            session()->flash('warning', 'Perdoruesi i bere BAN nuk mund te huazoje libra');
            return redirect()->back();
        }

        if (Auth::user()->status !== StatusEnum::ACTIVE) {
            session()->flash('warning', 'Vetem perdoruesit Aktiv mund te huazojne libra');
            return redirect()->back();
        }

        return $next($request);
    }
}
