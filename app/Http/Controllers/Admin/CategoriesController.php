<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BookStoreRequest;
use App\Http\Requests\Admin\BookUpdateRequest;
use App\Http\Requests\Admin\CategoryStoreRequest;
use App\Http\Requests\Admin\CategoryUpdateRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class CategoriesController extends Controller
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
                $booksQuery = Category::query();

                return DataTables::eloquent($booksQuery)
                    ->addColumn('actions', 'admin.categories.datatable.actions')
                    ->rawColumns(['actions'])
                    ->make(true);
            } catch (Exception $e) {
                report($e);

                return redirect()->back()->with('error', 'Datatable could not be initialized');
            }
        }

        return view('admin.categories.index');
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(CategoryStoreRequest $request)
    {
        try {
            Category::query()->create([
                'title'       => $request->input('title'),
            ]);

            session()->flash('success', 'Category was created successfully');

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'data' => [
                        'success' => true,
                        'redirect_to' => route('admin.categories.index'),
                    ]
                ]);
            }
            return redirect()->route('admin.categories.index');

        } catch (Exception $exception) {
            report($exception);
            session()->flash('error', 'Category could not be created');
            return response()->json([
                'data' => [
                    'success' => false,
                    'redirect_to' => route('admin.categories.index'),
                ]
            ], 500);
        }
    }

    public function show(Category $category): View
    {
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        try {
            $category->update([
                'title' => $request->input('title'),
            ]);

            session()->flash('success', 'Category was updated successfully');

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'data' => [
                        'success' => true,
                        'redirect_to' => route('admin.categories.index'),
                    ]
                ]);
            }

            return redirect()->route('admin.categories.index');

        } catch (Exception $exception) {
            report($exception);
            session()->flash('error', 'Category could not be updated');
            return response()->json([
                'data' => [
                    'success' => false,
                    'redirect_to' => route('admin.categories.index'),
                ]
            ], 500);
        }
    }

    public function destroy(Category $category)
    {
        if (!auth()->check()){
            return redirect()->back()->with('error', 'User is not logged in');
        }

        if (!auth()->user()->isAdmin()){
            return redirect()->back()->with('error', 'You do not have permission to see this section. Admin Only');
        }

        try {
            $category->delete();
            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Category was deleted successfully');

        } catch (Exception $exception) {
            report($exception);
            return redirect()->back()->with('error', 'Category could not be deleted');
        }
    }

    public function search(Request $request): JsonResponse
    {
        return response()->json(
            Category::search(
                $request->get('keyword'),
                $request->get('id')
            )->get()
        );
    }
}
