<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function show(string $slug)
    {
        $category = Category::query()
            ->where('slug', $slug)
            ->first();

        if (!$category){
            return redirect()->back()->with('error', 'Category is not valid');
        }

        $books = Book::query()
            ->whereHas('categories', function ($query) use ($category){
                return $query->where('categories.slug', $category->slug);
            })
            ->paginate(12);

        return view('categories-books', compact('books'));
    }
}
