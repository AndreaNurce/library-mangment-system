@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between">
        <h1 class="h3 mb-0 text-gray-800">Category</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Editing</li>
            <li class="breadcrumb-item active">{{$category->title}}</li>
        </ol>
    </div>

    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="card-title m-0 font-weight-bold text-primary">Update the Category title</h5>
        </div>
        <div class="card-body">
            <form class="ajax-form" method="POST" action="{{ route('admin.categories.update', ['category' => $category]) }}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Titulli</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Titulli" value="{{ $category->title }}"/>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary mr-1 submit-btn">
                                Përditso <i class="fa fa-spinner fa-spin d-none"></i>
                            </button>
                            <a href="{{route('admin.categories.index')}}" class="btn btn-secondary"> <i class="fas fa-arrow-left"></i>
                                Kthehu Mbrapa
                            </a>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {

        });
    </script>
@endsection
