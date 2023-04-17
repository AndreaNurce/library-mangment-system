<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserStoreRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
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
                $booksQuery = User::query();

                return DataTables::eloquent($booksQuery)
                    ->editColumn('birthdate', function (User $user) {
                        return $user->birthdate?->format('d/m/Y');
                    })
                    ->editColumn('gender', 'admin.users.datatable.gender')
                    ->editColumn('role', 'admin.users.datatable.role')
                    ->editColumn('is_banned', 'admin.users.datatable.is_banned')
                    ->editColumn('status', 'admin.users.datatable.status')
                    ->addColumn('actions', 'admin.users.datatable.actions')
                    ->rawColumns(['gender','role','is_banned','status','actions'])
                    ->make(true);
            } catch (Exception $e) {
                report($e);

                return redirect()->back()->with('error', 'Datatable could not be initialized');
            }
        }

        return view('admin.users.index');
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(UserStoreRequest $request)
    {
        try {
            $isBanned = (bool) $request->input('status') == StatusEnum::BANNED;

            $user = User::query()->create([
                'name'       => $request->input('name'),
                'lastname'   => $request->input('lastname'),
                'password'   => Hash::make($request->input('password')),
                'email'      => $request->input('email'),
                'gender'     => $request->input('gender'),
                'birthdate'  => $request->input('birthdate'),
                'role'       => $request->input('role'),
                'is_banned'  => $isBanned,
                'status'     => $request->input('status'),
                'email_verified_at' => now(),
            ]);

            session()->flash('success', 'Use was created successfully');

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'data' => [
                        'success' => true,
                        'redirect_to' => route('admin.users.index'),
                    ]
                ]);
            }
            return redirect()->route('admin.users.index');

        } catch (Exception $exception) {
            report($exception);
            session()->flash('error', 'User could not be created');
            return response()->json([
                'data' => [
                    'success' => false,
                    'redirect_to' => route('admin.users.index'),
                ]
            ], 500);
        }
    }

    public function show(User $user): View
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        try {

            $isBanned = (bool) $request->input('status') == StatusEnum::BANNED;

            $user->update([
                'name'       => $request->input('name'),
                'lastname'   => $request->input('lastname'),
                'email'      => $request->input('email'),
                'gender'     => $request->input('gender'),
                'birthdate'  => $request->input('birthdate'),
                'role'       => $request->input('role'),
                'is_banned'  => $isBanned,
                'status'     => $request->input('status'),
                'email_verified_at' => now(),
            ]);

            if ($request->filled('password') || $request->input('password') !== ''){
                $user->update([
                    'password'   => Hash::make($request->input('password')),
                ]);
            }

            session()->flash('success', 'User was updated successfully');

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'data' => [
                        'success' => true,
                        'redirect_to' => route('admin.users.index'),
                    ]
                ]);
            }

            return redirect()->route('admin.users.index');

        } catch (Exception $exception) {
            report($exception);
            session()->flash('error', 'User could not be updated');
            return response()->json([
                'data' => [
                    'success' => false,
                    'redirect_to' => route('admin.users.index'),
                ]
            ], 500);
        }
    }

    public function destroy(User $user)
    {
        if (!auth()->check()){
            return redirect()->back()->with('error', 'User is not logged in');
        }

        if (!auth()->user()->isAdmin()){
            return redirect()->back()->with('error', 'You do not have permission to see this section. Admin Only');
        }

        try {
            $user->delete();
            return redirect()
                ->route('admin.users.index')
                ->with('success', 'User was deleted successfully');

        } catch (Exception $exception) {
            report($exception);
            return redirect()->back()->with('error', 'User could not be deleted');
        }
    }

    public function search(Request $request): JsonResponse
    {
        return response()->json(
            User::search(
                $request->get('keyword'),
                $request->get('id')
            )->get()
        );
    }
}
