@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between">
        <h1 class="h3 mb-0 text-gray-800">Category</h1>
        <ol class="breadcrumb"><li class="breadcrumb-item">Viewing</li></ol>
    </div>

    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="card-title m-0 font-weight-bold text-primary">Category Details</h5>
        </div>
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="card-title">Libri</h4>
                <div class="actions">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning">
                            <i class="fas fa-pencil-alt"></i> Edito
                        </a>
                        <a href="javascript:void(0);" class="btn btn-danger action-button"
                           title="Delete"
                           data-action="{{ route('admin.categories.destroy', $category) }}"
                           data-method="DELETE"
                           data-title="Delete Category"
                           data-message="Are you sure you want to delete this Category"
                           data-is-danger="true"
                        >
                            <i class="fas fa-trash-alt"></i> Fshije
                        </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table class="table show-table">
                        <tbody>
                            <tr>
                                <th class="label">ID</th>
                                <td class="value">{{ $category->id }}</td>
                            </tr>
                            <tr>
                                <th class="label">Titulli</th>
                                <td class="value">{{ $category->title }}</td>
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
