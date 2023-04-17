<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function __invoke(Request $request)
    {
        $booksStats  = Book::toBase()
            ->selectRaw("count(*) as total_books")
            ->selectRaw("count(case when in_stock = '1' then 1 end) as stock")
            ->selectRaw("count(case when in_stock = '0' then 1 end) as out_of_stock")
            ->selectRaw("count(case when is_highlighted = '1' then 1 end) as highlighted")
            ->selectRaw("count(case when is_highlighted = '0' then 1 end) as normal")
            ->first();

        $usersCount = User::count();

        return view('dashboard', compact('booksStats', 'usersCount'));
    }
}
