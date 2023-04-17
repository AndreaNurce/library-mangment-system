@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between">
        <h1 class="h3 mb-0 text-gray-800">Perdoruesi</h1>
        <ol class="breadcrumb"><li class="breadcrumb-item">Detajet</li></ol>
    </div>

    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="card-title m-0 font-weight-bold text-primary">Detajet e Perdoruesit</h5>
        </div>
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="card-title">Libri</h4>
                <div class="actions">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                            <i class="fas fa-pencil-alt"></i> Edito
                        </a>
                        <a href="javascript:void(0);" class="btn btn-danger action-button"
                           title="Delete"
                           data-action="{{ route('admin.users.destroy', $user) }}"
                           data-method="DELETE"
                           data-title="Fshije Perdoruesin"
                           data-message="Jeni te sigurt qe doni te fshini kete perdorues!?"
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
                            <td class="value">{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <th class="label">Emri</th>
                            <td class="value">{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th class="label">Mbiemri</th>
                            <td class="value">{{ $user->lastname }}</td>
                        </tr>
                        <tr>
                            <th class="label">Datelindja</th>
                            <td class="value">{{ $user->birthdate?->format('d.m.Y') }}</td>
                        </tr>
                        <tr>
                            <th class="label">Email</th>
                            <td class="value">{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th class="label">Gjinia</th>
                            <td class="value">{{ \App\Enums\GenderEnum::getLabel($user->gender) }}</td>
                        </tr>
                        <tr>
                            <th class="label">Statusi</th>
                            <td class="value">{{ \App\Enums\StatusEnum::getLabel($user->status) }}</td>
                        </tr>
                        <tr>
                            <th class="label">Krijuar më</th>
                            <td class="value">{{ $user->created_at }}</td>
                        </tr>
                        <tr>
                            <th class="label">Përditesuar më</th>
                            <td class="value">{{ $user->updated_at }}</td>
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
