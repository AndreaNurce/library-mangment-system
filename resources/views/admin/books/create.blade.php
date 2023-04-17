@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between">
        <h1 class="h3 mb-0 text-gray-800">Books</h1>
        <ol class="breadcrumb"><li class="breadcrumb-item">Create</li></ol>
    </div>

    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="card-title m-0 font-weight-bold text-primary">Create a new Entry for a book</h5>
            <p class="card-title-desc">Plotesoni formularin me te dhenat e librit qe do shtoni ne koleksion!</p>
        </div>
        <div class="card-body">
            <form class="ajax-form" method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Titulli</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Titulli"/>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="author">Autori</label>
                            <input type="text" name="author" id="author" class="form-control" placeholder="Autori"/>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="publisher">Publisher</label>
                            <input type="text" name="publisher" id="publisher" class="form-control" placeholder="Publikuesi"/>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="publication_year">Viti i Publikimit</label>
                            <input type="date" name="publication_year" id="publication_year" class="form-control" placeholder="Viti i Publikimit"/>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Pershkrimi</label>
                            <textarea class="form-control" name="description" id="description" placeholder="Pershkrimi"></textarea>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cover_image_url">Imaxhi i Kopertines</label>
                            <input type="file" name="cover_image_url" id="cover_image_url" class="form-control" placeholder="Imazhi i kopertines"/>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="categories">Categorite</label>
                            <select name="categories[]" id="categories" class="form-control" multiple="multiple" style="width: 100%"></select>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pages">Faqe</label>
                            <input type="number" name="pages" id="pages" class="form-control" placeholder="Faqe"/>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price">Çmimi</label>
                            <input type="number" name="price" id="price" class="form-control" placeholder="Çmimi"/>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="isbn">ISBN</label>
                            <input type="text" name="isbn" id="isbn" class="form-control" placeholder="ISBN"/>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="copies">Nr i Kopjet</label>
                            <input type="number" name="copies" id="copies" class="form-control" placeholder="Nr i Kopjet"/>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <label for="is_highlighted">Eshte i Perzgjedhur?</label>
                            <input type="checkbox" name="is_highlighted" id="is_highlighted"  class="form-control" value="1">
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary mr-1 submit-btn">
                                Krijo <i class="fa fa-spinner fa-spin d-none"></i>
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
