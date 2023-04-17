@extends('layouts.guest')

@section('content')
    <!-- Product section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="{{ $book->path ?? 'https://dummyimage.com/600x700/dee2e6/6c757d.jpg' }}" style="max-width: 600px" alt="..." /></div>
                <div class="col-md-6">
                    <div class="small mb-1">ISBN: {{$book->isbn}}</div>
                    <h1 class="display-5 fw-bolder">{{$book->title}}</h1>
                    <div class="fs-5 mb-5">
                        <span>Kopje: {{$book->getAvailableStock() }}</span> || <span>{{ display_price($book->price) }}</span>
                    </div>
                    <p class="lead">{{ getNWords($book->description, 50) }}</p>
                    <div class="d-flex">
                        <a href="{{ route('books.loan', ['slug' => $book->slug]) }}" class="btn btn-info">Pronoto Librin</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related items section-->
    <section class="py-5 bg-light">
        <div class="container px-4 px-lg-5 mt-5">
            <h2 class="fw-bolder mb-4">Most Viewed Books</h2>
            <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-3 row-cols-xl-4 justify-content-center">
                @foreach($topBooks as $mostViewedBook)
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Sale badge-->
                            @if($mostViewedBook->is_highlighted)
                                <div class="badge bg-primary text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Highlighted</div>
                            @endif
                            @if($mostViewedBook->getAvailableStock() <= 0)
                                <div class="badge bg-warning text-white position-absolute" style="top: 0.5rem; left: 0.5rem">out of stock</div>
                            @endif
                            <!-- Product image-->
                            <img class="card-img-top" src="{{ $mostViewedBook->path ?? 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg' }}" style="max-width: 450px" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">{{ str_tease($mostViewedBook->title, 50)}}</h5>
                                    <!-- Product reviews-->
                                    <div class="d-flex justify-content-center small text-warning mb-2">
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                    </div>
                                    <!-- Product price-->
                                    <span>{{ display_price($mostViewedBook->price) }}</span>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-primary mt-auto" href="{{ route('books.loan', ['slug' => $mostViewedBook->slug]) }}">Rent it out</a></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
