<?php

use App\Http\Controllers\Admin\BooksController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\LoansController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::redirect('/home', '/');

Auth::routes();

/**********************************************
 * Name: ADMIN
 * Url: /admin/*
 * Route: admin.*
 ***********************************************/
Route::prefix('admin')
    ->as('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        Route::get('/dashboard', App\Http\Controllers\Admin\DashboardController::class)->name('dashboard');

        Route::prefix('books')->as('books.')->group(function () {
            Route::get('/')
                ->uses([BooksController::class, 'index'])
                ->name('index');

            Route::get('search')
                ->uses([BooksController::class, 'search'])
                ->name('search');

            Route::get('create')
                ->uses([BooksController::class, 'create'])
                ->name('create');

            Route::post('/')
                ->uses([BooksController::class, 'store'])
                ->name('store');

            Route::get('/{book}')
                ->uses([BooksController::class, 'show'])
                ->name('show');

            Route::get('/{book}/edit')
                ->uses([BooksController::class, 'edit'])
                ->name('edit');

            Route::put('/{book}')
                ->uses([BooksController::class, 'update'])
                ->name('update');

            Route::delete('/{book}')
                ->uses([BooksController::class, 'destroy'])
                ->name('destroy');

        });

        Route::prefix('categories')->as('categories.')->group(function () {
            Route::get('/')
                ->uses([CategoriesController::class, 'index'])
                ->name('index');

            Route::get('search')
                ->uses([CategoriesController::class, 'search'])
                ->name('search');

            Route::get('create')
                ->uses([CategoriesController::class, 'create'])
                ->name('create');

            Route::post('/')
                ->uses([CategoriesController::class, 'store'])
                ->name('store');

            Route::get('/{category}')
                ->uses([CategoriesController::class, 'show'])
                ->name('show');

            Route::get('/{category}/edit')
                ->uses([CategoriesController::class, 'edit'])
                ->name('edit');

            Route::put('/{category}')
                ->uses([CategoriesController::class, 'update'])
                ->name('update');

            Route::delete('/{category}')
                ->uses([CategoriesController::class, 'destroy'])
                ->name('destroy');

        });

        Route::prefix('users')->as('users.')->group(function () {
            Route::get('/')
                ->uses([UsersController::class, 'index'])
                ->name('index');

            Route::get('search')
                ->uses([UsersController::class, 'search'])
                ->name('search');

            Route::get('create')
                ->uses([UsersController::class, 'create'])
                ->name('create');

            Route::post('/')
                ->uses([UsersController::class, 'store'])
                ->name('store');

            Route::get('/{user}')
                ->uses([UsersController::class, 'show'])
                ->name('show');

            Route::get('/{user}/edit')
                ->uses([UsersController::class, 'edit'])
                ->name('edit');

            Route::put('/{user}')
                ->uses([UsersController::class, 'update'])
                ->name('update');

            Route::delete('/{user}')
                ->uses([UsersController::class, 'destroy'])
                ->name('destroy');

        });

        Route::prefix('book-loans')->as('loans.')->group(function () {
            Route::get('/')
                ->uses([LoansController::class, 'index'])
                ->name('index');

            Route::get('search')
                ->uses([LoansController::class, 'search'])
                ->name('search');

            Route::get('create')
                ->uses([LoansController::class, 'create'])
                ->name('create');

            Route::post('/')
                ->uses([LoansController::class, 'store'])
                ->name('store');

            Route::get('/{loan}')
                ->uses([LoansController::class, 'show'])
                ->name('show');

            Route::get('/{loan}/edit')
                ->uses([LoansController::class, 'edit'])
                ->name('edit');

            Route::put('/{loan}')
                ->uses([LoansController::class, 'update'])
                ->name('update');

            Route::delete('/{loan}')
                ->uses([LoansController::class, 'destroy'])
                ->name('destroy');

        });

    });


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('books-details/{slug}')->uses([\App\Http\Controllers\BooksController::class, 'show'])->name('books.show');
Route::get('books-loan/{slug}')->uses([\App\Http\Controllers\BooksController::class, 'loan'])->name('books.loan')->middleware(['auth', 'can.loan']);
Route::post('books-loan/{slug}')->uses([\App\Http\Controllers\BooksController::class, 'loanStore'])->name('books.loan.store')->middleware(['auth', 'can.loan']);
Route::get('categories/{slug}')->uses([\App\Http\Controllers\CategoriesController::class, 'show'])->name('categories.show');

