<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BookStoreRequest;
use App\Http\Requests\Admin\BookUpdateRequest;
use App\Models\Book;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class BooksController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check()){
            return redirect()->back()->with('error', 'User is not logged in');
        }

        if (!auth()->user()->isAdmin()){
            return redirect()->back()->with('error', 'You do not have permission to see this section. Admin Only');
        }

        if ($request->ajax() || $request->wantsJson()) {
            try {
                $booksQuery = Book::query();

                return DataTables::eloquent($booksQuery)
                    ->editColumn('publication_year', function (Book $book) {
                        return $book->publication_year?->format('d/m/Y');
                    })
                    ->editColumn('price', function (Book $book) {
                        return display_price($book->price);
                    })
                    ->editColumn('in_stock', 'admin.books.datatable.in_stock')
                    ->addColumn('actions', 'admin.books.datatable.actions')
                    ->rawColumns(['in_stock','actions'])
                    ->make(true);
            } catch (Exception $e) {
                report($e);

                return redirect()->back()->with('error', 'Datatable could not be initialized');
            }
        }

        return view('admin.books.index');
    }

    public function create(): View
    {
        return view('admin.books.create');
    }

    public function store(BookStoreRequest $request)
    {
        try {
            $path = null;
            if ($request->hasFile('cover_image_url')){
                $file = $request->file('cover_image_url');
                $timestamp = time();
                $filename = $file->getClientOriginalName();
                // $path = '/books/covers/' . $timestamp . '_' . Str::of($filename)->lower()->replace(' ', '_');
                // Storage::disk('local')->put($path, File::get($file));

                $name = $timestamp . '_' . Str::of($filename)->lower()->replace(' ', '_');
                $path = Storage::disk('public')->putFileAs('books', $request->file('cover_image_url'), $name);
            }

            $book = Book::query()->create([
                'title'       => $request->input('title'),
                'author'      => $request->input('author'),
                'publisher'   => $request->input('publisher'),
                'description' => $request->input('description'),
                'cover_image_url' => $path,
                'publication_year' => $request->input('publication_year'),
                'pages' => $request->input('pages'),
                'price' => $request->input('price'),
                'isbn' => $request->input('isbn'),
                'in_stock' => $request->input('copies') > 0,
                'is_highlighted' => $request->boolean('is_highlighted'),
                'copies' => $request->input('copies'),
            ]);

            $book->categories()
                ->attach($request->input('categories'));

            session()->flash('success', 'Book was created successfully');

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'data' => [
                        'success' => true,
                        'redirect_to' => route('admin.books.index'),
                    ]
                ]);
            }
            return redirect()->route('admin.books.index');

        } catch (Exception $exception) {
            report($exception);
            session()->flash('error', 'Book could not be created');
            return response()->json([
                'data' => [
                    'success' => false,
                    'redirect_to' => route('admin.books.index'),
                ]
            ], 500);
        }
    }

    public function show(Book $book): View
    {
        return view('admin.books.show', compact('book'));
    }

    public function edit(Book $book): View
    {
        return view('admin.books.edit', compact('book'));
    }

    public function update(BookUpdateRequest $request, Book $book)
    {
        try {
            $path = null;

            if ($request->hasFile('cover_image_url')){

                if($book->path && File::exists($book->path)){
                    Storage::delete($book->path);
                }

                $file = $request->file('cover_image_url');
                $timestamp = time();
                $filename = $file->getClientOriginalName();

                // $path = '/books/covers/' . $timestamp . '_' . Str::of($filename)->lower()->replace(' ', '_');
                // Storage::disk('local')->put($path, File::get($file));

                $name = $timestamp . '_' . Str::of($filename)->lower()->replace(' ', '_');
                $path = Storage::disk('public')->putFileAs('books', $request->file('cover_image_url'), $name);
            }

            $book->update([
                'title'       => $request->input('title'),
                'author'      => $request->input('author'),
                'publisher'   => $request->input('publisher'),
                'description' => $request->input('description'),
                'cover_image_url' => $path,
                'publication_year'   => $request->input('publication_year'),
                'pages' => $request->input('pages'),
                'price' => $request->input('price'),
                'isbn' => $request->input('isbn'),
                'copies' => $request->input('copies'),
                'in_stock' => $request->input('copies') > 0,
            ]);

            $book->categories()->sync($request->input('categories'));

            session()->flash('success', 'Book was updated successfully');

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'data' => [
                        'success' => true,
                        'redirect_to' => route('admin.books.index'),
                    ]
                ]);
            }

            return redirect()->route('admin.books.index');

        } catch (Exception $exception) {
            report($exception);
            session()->flash('error', 'Book could not be updated');
            return response()->json([
                'data' => [
                    'success' => false,
                    'redirect_to' => route('admin.books.index'),
                ]
            ], 500);
        }
    }

    public function destroy(Book $book)
    {
        if (!auth()->check()){
            return redirect()->back()->with('error', 'User is not logged in');
        }

        if (!auth()->user()->isAdmin()){
            return redirect()->back()->with('error', 'You do not have permission to see this section. Admin Only');
        }

        try {
            $book->delete();
            return redirect()
                ->route('admin.books.index')
                ->with('success', 'Book was deleted successfully');

        } catch (Exception $exception) {
            report($exception);
            return redirect()->back()->with('error', 'Book could not be deleted');
        }
    }

    public function search(Request $request): JsonResponse
    {
        return response()->json(
            Book::search(
                $request->get('keyword'),
                $request->get('id')
            )->get()
        );
    }
}
