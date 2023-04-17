@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between">
        <h1 class="h3 mb-0 text-gray-800">Huazimi</h1>
        <ol class="breadcrumb"><li class="breadcrumb-item">Detajet e Huazimit</li></ol>
    </div>

    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="card-title m-0 font-weight-bold text-primary">Detajet e Huazimit</h5>
        </div>
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="card-title">Libri</h4>
                <div class="actions">
                        <a href="{{ route('admin.loans.edit', $loan) }}" class="btn btn-warning">
                            <i class="fas fa-pencil-alt"></i> Edito
                        </a>
                        <a href="javascript:void(0);" class="btn btn-danger action-button"
                           title="Delete"
                           data-action="{{ route('admin.loans.destroy', $loan) }}"
                           data-method="DELETE"
                           data-title="Fshije Huazimit"
                           data-message="Jeni te sigurt qe doni te fshini kete huazim!?"
                           data-is-danger="true"
                        >
                            <i class="fas fa-trash-alt"></i> Fshij
                        </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table class="table show-table">
                        <tbody>
                        <tr>
                            <th class="label">ID</th>
                            <td class="value">{{ $loan->id }}</td>
                        </tr>
                        <tr>
                            <th class="label">Perdoruesi</th>
                            <td class="value">{{ $loan->user->full_name }}</td>
                        </tr>
                        <tr>
                            <th class="label">Libri</th>
                            <td class="value">{{ $loan->book->title }}</td>
                        </tr>
                        <tr>
                            <th class="label">Kerkuar me</th>
                            <td class="value">{{ $loan->requested_at?->format('d.m.Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th class="label">Statusi</th>
                            <td class="value">{{ \App\Enums\LoanRequestStatusEnum::getLabel($loan->book_loan_status) }}</td>
                        </tr>
                        <tr>
                            <th class="label">Data e Huazimit</th>
                            <td class="value">{{ $loan->loan_date?->format('d.m.Y') }}</td>
                        </tr>
                        <tr>
                            <th class="label">Data e Kthimit</th>
                            <td class="value">{{ $loan->loan_date?->format('d.m.Y') }}</td>
                        </tr>
                        <tr>
                            <th class="label">Numri i Kopjeve</th>
                            <td class="value">{{ $loan->number_copies }}</td>
                        </tr>
                        <tr>
                            <th class="label">Përditesuar më</th>
                            <td class="value">{{ $loan->updated_at }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {

        });
    </script>
@endsection
