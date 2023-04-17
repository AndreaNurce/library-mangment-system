<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserStoreRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Models\Loan;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class LoansController extends Controller
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
                $loanQuery = Loan::query()
                ->with(['user', 'book']);

                return DataTables::eloquent($loanQuery)
                    ->editColumn('requested_at', function (Loan $loan) {
                        return $loan->requested_at?->format('d/m/Y H:i');
                    })
                    ->editColumn('loan_date', function (Loan $loan) {
                        return $loan->loan_date?->format('d/m/Y');
                    })
                    ->editColumn('return_date', function (Loan $loan) {
                        return $loan->return_date?->format('d/m/Y');
                    })
                    ->filterColumn('full_name', function ($query, $keyword) {
                        $query->whereHas('user', function ($q) use ($keyword){
                            return $q->where('name', 'LIKE', "%{$keyword}%")
                                ->orWhere('lastname', 'LIKE', "%{$keyword}%");
                        });
                    })
                    ->editColumn('book_loan_status', 'admin.loans.datatable.book_loan_status')
                    ->addColumn('actions', 'admin.loans.datatable.actions')
                    ->rawColumns(['book_loan_status','actions'])
                    ->make(true);
            } catch (Exception $e) {
                report($e);

                return redirect()->back()->with('error', 'Datatable could not be initialized');
            }
        }

        return view('admin.loans.index');
    }

    public function create()
    {
        return redirect()->back()->with('info', 'Work in Progress');
        //return view('admin.loans.create');
    }

    public function store(UserStoreRequest $request)
    {
        return redirect()->back()->with('info', 'Work in Progress');
//        try {
//            $isBanned = (bool) $request->input('status') == StatusEnum::BANNED;
//
//            $user = User::query()->create([
//                'name'       => $request->input('name'),
//                'lastname'   => $request->input('lastname'),
//                'password'   => Hash::make($request->input('password')),
//                'email'      => $request->input('email'),
//                'gender'     => $request->input('gender'),
//                'birthdate'  => $request->input('birthdate'),
//                'role'       => $request->input('role'),
//                'is_banned'  => $isBanned,
//                'status'     => $request->input('status'),
//                'email_verified_at' => now(),
//            ]);
//
//            session()->flash('success', 'Use was created successfully');
//
//            if ($request->ajax() || $request->wantsJson()) {
//                return response()->json([
//                    'data' => [
//                        'success' => true,
//                        'redirect_to' => route('admin.users.index'),
//                    ]
//                ]);
//            }
//            return redirect()->route('admin.users.index');
//
//        } catch (Exception $exception) {
//            report($exception);
//            session()->flash('error', 'User could not be created');
//            return response()->json([
//                'data' => [
//                    'success' => false,
//                    'redirect_to' => route('admin.users.index'),
//                ]
//            ], 500);
//        }
    }

    public function show(Loan $loan): View
    {
        return view('admin.loans.show', compact('loan'));
    }

    public function edit(Loan $loan)
    {
        return redirect()->back()->with('info', 'Work in Progress');
        //return view('admin.loans.edit', compact('loan'));
    }

    public function update(UserUpdateRequest $request, Loan $loan)
    {
        return redirect()->back()->with('info', 'Work in Progress');
//        try {
//            $isBanned = (bool) $request->input('status') == StatusEnum::BANNED;
//
//            $user->update([
//                'name'       => $request->input('name'),
//                'lastname'   => $request->input('lastname'),
//                'email'      => $request->input('email'),
//                'gender'     => $request->input('gender'),
//                'birthdate'  => $request->input('birthdate'),
//                'role'       => $request->input('role'),
//                'is_banned'  => $isBanned,
//                'status'     => $request->input('status'),
//                'email_verified_at' => now(),
//            ]);
//
//            if ($request->filled('password') || $request->input('password') !== ''){
//                $user->update([
//                    'password'   => Hash::make($request->input('password')),
//                ]);
//            }
//
//            session()->flash('success', 'User was updated successfully');
//
//            if ($request->ajax() || $request->wantsJson()) {
//                return response()->json([
//                    'data' => [
//                        'success' => true,
//                        'redirect_to' => route('admin.users.index'),
//                    ]
//                ]);
//            }
//
//            return redirect()->route('admin.users.index');
//
//        } catch (Exception $exception) {
//            report($exception);
//            session()->flash('error', 'User could not be updated');
//            return response()->json([
//                'data' => [
//                    'success' => false,
//                    'redirect_to' => route('admin.users.index'),
//                ]
//            ], 500);
//        }
    }

    public function destroy(Loan $loan)
    {
        if (!auth()->check()){
            return redirect()->back()->with('error', 'User is not logged in');
        }

        if (!auth()->user()->isAdmin()){
            return redirect()->back()->with('error', 'You do not have permission to see this section. Admin Only');
        }

        try {
            $loan->delete();
            return redirect()
                ->route('admin.loans.index')
                ->with('success', 'Loan was deleted successfully');

        } catch (Exception $exception) {
            report($exception);
            return redirect()->back()->with('error', 'Loan could not be deleted');
        }
    }

    public function search(Request $request): JsonResponse
    {
        return response()->json(
            Loan::search(
                $request->get('keyword'),
                $request->get('id')
            )->get()
        );
    }
}
