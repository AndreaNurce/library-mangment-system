<?php

namespace App\Http\Controllers;

use App\Enums\LoanRequestStatusEnum;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Loan;
use Carbon\Carbon;

class BooksController extends Controller
{
    public function show(string $slug)
    {
        $book = Book::query()->where('slug', $slug)->first();

        if (!$book){
            return redirect()->back()->with('error','Book was not found');
        }

        if (! (auth()->check() && auth()->user()->isAdmin())) {
            $expireAt = now()->addHours(1);
            views($book)->cooldown($expireAt)->record();
        }

        $topBooks = Book::query()->orderByViews()->limit(4)->get();

        return view('book-details', compact('book', 'topBooks'));
    }


    public function loan(Request $request, string $slug)
    {
        $book = Book::query()
            ->where('slug', $slug)
            ->where('in_stock', true)
            ->first();

        if (!$book){
            return redirect()->back()->with('error','Book was not found');
        }

        if (! (auth()->check() && auth()->user()->isAdmin())) {
            $expireAt = now()->addHours(1);
            views($book)->cooldown($expireAt)->record();
        }

        $availableBooks = $book->getAvailableStock();

        $topBooks = Book::query()->orderByViews()->limit(4)->get();

        return view('book-loan', compact('book', 'topBooks', 'availableBooks'));
    }

    public function loanStore(Request $request, string $slug)
    {
        $book = Book::query()->where('slug', '=', $slug)
            ->where('in_stock', true)
            ->first();

        if (!$book){
            return redirect()->back()->with('error','Book was not found');
        }

        $availableBooks = $book->getAvailableStock();

        $validator = Validator::make($request->all(), [
            'copies' => ['required','numeric','min:1', 'max:'.$availableBooks],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->input('copies') > $availableBooks) {
            return redirect()->back()->with('error', 'You can not Request more than you have books available');
        }

        Loan::query()->create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'requested_at' => Carbon::now(),
            'book_loan_status' => LoanRequestStatusEnum::APPROVED,
            'loan_date' => Carbon::now(),
            'number_copies' => $request->input('copies'),
        ]);

        return redirect()->route('home')->with('success', 'You loan have been approved automatically by the system. Enjoy the Reading');
    }
}
