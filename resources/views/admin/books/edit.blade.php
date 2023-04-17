@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between">
        <h1 class="h3 mb-0 text-gray-800">Books</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Editing</li>
            <li class="breadcrumb-item active">{{$book->title}}</li>
        </ol>
    </div>

    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="card-title m-0 font-weight-bold text-primary">Update the Book info</h5>
            <p class="card-title-desc">Plotesoni formularin me te dhenat e librit qe deshironi te perditesoni!</p>
        </div>
        <div class="card-body">
            <form class="ajax-form" action="{{ route('admin.books.update', ['book' => $book]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Titulli</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Titulli" value="{{ $book->title }}"/>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="author">Autori</label>
                            <input type="text" name="author" id="author" class="form-control" placeholder="Autori" value="{{ $book->author }}"/>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="publisher">Publisher</label>
                            <input type="text" name="publisher" id="publisher" class="form-control" placeholder="Publikuesi" value="{{ $book->publisher }}"/>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="publication_year">Viti i Publikimit</label>
                            <input type="date" name="publication_year" id="publication_year" class="form-control" placeholder="Viti i Publikimit" value="{{ $book->publication_year?->format('Y-m-d') }}"/>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Pershkrimi</label>
                            <textarea class="form-control" name="description" id="description" placeholder="Pershkrimi">{{ $book->description }}</textarea>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cover_image_url">Imaxhi i Kopertines</label>
                            <input type="file" name="cover_image_url" id="cover_image_url" class="form-control" placeholder="Imazhi i kopertines"/>
                            <small class="text-muted">Lereni bosh ne menyre qe mos te ndryshoni imazhin</small>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="categories">Categorite</label>
                            <select name="categories[]" id="categories" class="form-control" multiple="multiple" style="width: 100%">
                                @foreach($book->categories as $category)
                                    <option value="{{$category->id}}" selected>
                                        {{$category->title}}
                                    </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pages">Faqe</label>
                            <input type="number" name="pages" id="pages" class="form-control" placeholder="Faqe" value="{{ $book->pages }}"/>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price">Çmimi</label>
                            <input type="number" name="price" id="price" class="form-control" placeholder="Çmimi" value="{{ $book->price }}"/>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="isbn">ISBN</label>
                            <input type="text" name="isbn" id="isbn" class="form-control" placeholder="ISBN" value="{{ $book->isbn }}"/>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="copies">Nr i Kopjet</label>
                            <input type="number" name="copies" id="copies" class="form-control" placeholder="Nr i Kopjet" value="{{ $book->copies }}"/>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary mr-1 submit-btn">
                                Përditso <i class="fa fa-spinner fa-spin d-none"></i>
                            </button>
                            <a href="{{route('admin.books.index')}}" class="btn btn-secondary"> <i class="fas fa-arrow-left"></i>
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
            // Services Search
            $('#categories').select2({
                placeholder: "Zgjidhni Kategorite",
                allowClear: true,
                ajax: {
                    url: "{{ route('admin.categories.search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            keyword: params.term,
                        };
                    },
                    processResults: function (data, params) {
                        return {
                            results: $.map(data, function (response) {
                                return {
                                    id: response.id,
                                    text: response.title,
                                };
                            })
                        };
                    },
                    cache: false,
                }
            });

        });
    </script>
@endsection
