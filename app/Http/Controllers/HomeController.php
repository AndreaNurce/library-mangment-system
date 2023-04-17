<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use function GuzzleHttp\Promise\all;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(Request $request)
    {
        $categories = Category::query()->get();

        $booksQuery = Book::query();

        if ($request->filled('filter_by') && $request->get('filter_by') == 'latest'){
            $booksQuery->latest();
        } elseif($request->filled('filter_by') && $request->get('filter_by') == 'most_viewed') {
            $booksQuery->orderByViews();
        } elseif($request->filled('filter_by') && $request->get('filter_by') == 'highlighted'){
            $booksQuery->where('is_highlighted', true);
        }

        $books = $booksQuery->paginate(8);

        return view('main', compact('categories', 'books'));
    }
}
