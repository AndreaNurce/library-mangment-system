@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between">
        <h1 class="h3 mb-0 text-gray-800">Book</h1>
        <ol class="breadcrumb"><li class="breadcrumb-item">Viewing</li></ol>
    </div>

    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="card-title m-0 font-weight-bold text-primary">Book Details</h5>
        </div>
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="card-title">Libri</h4>
                <div class="actions">
                        <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-warning">
                            <i class="fas fa-pencil-alt"></i> Edito
                        </a>
                        <a href="javascript:void(0);" class="btn btn-danger action-button"
                           title="Delete"
                           data-action="{{ route('admin.books.destroy', $book) }}"
                           data-method="DELETE"
                           data-title="Delete Book"
                           data-message="Are you sure you want to delete this book"
                           data-is-danger="true"
                        >
                            <i class="fas fa-trash-alt"></i> Delete
                        </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table class="table show-table">
                        <tbody>
                        <tr>
                            <th class="label">ID</th>
                            <td class="value">{{ $book->id }}</td>
                        </tr>
                        <tr>
                            <th class="label">Titulli</th>
                            <td class="value">{{ $book->title }}</td>
                        </tr>
                        <tr>
                            <th class="label">Autori</th>
                            <td class="value">{{ $book->author }}</td>
                        </tr>
                        <tr>
                            <th class="label">Viti i Publikimit</th>
                            <td class="value">{{ $book->publication_year?->format('d.m.Y') }}</td>
                        </tr>
                        <tr>
                            <th class="label">Publikuesi</th>
                            <td class="value">{{ $book->publisher }}</td>
                        </tr>
                        <tr>
                            <th class="label">Faqe</th>
                            <td class="value">{{ $book->pages }}</td>
                        </tr>
                        <tr>
                            <th class="label">Çmimi</th>
                            <td class="value">{{ $book->price }}</td>
                        </tr>
                        <tr>
                            <th class="label">ISBN</th>
                            <td class="value">{{ $book->isbn }}</td>
                        </tr>
                        <tr>
                            <th class="label">Kopje</th>
                            <td class="value">{{ $book->copies }}</td>
                        </tr>
                        <tr>
                            <th class="label">Krijuar më</th>
                            <td class="value">{{ $book->created_at }}</td>
                        </tr>
                        <tr>
                            <th class="label">Përditesuar më</th>
                            <td class="value">{{ $book->updated_at }}</td>
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
