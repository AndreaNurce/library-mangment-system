@extends('layouts.guest')

@section('content')
    <!-- CAROUSEL -->
    <div id="carouselExample" class="carousel slide w-100" data-ride="carousel" data-interval="3000">
        <div class="carousel-indicators">
            <button type="button" data-target="#carouselExample" data-slide-to="0" class="active"></button>
            <button type="button" data-target="#carouselExample" data-slide-to="1"></button>
            <button type="button" data-target="#carouselExample" data-slide-to="2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="https://thumbs.dreamstime.com/b/coffee-book-quotes-happiness-cup-coffee-good-book-coffee-book-quotes-224723601.jpg" alt="First slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Social Facilities Center</h5>
                    <p>University Campus</p>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="https://wallpaperaccess.com/full/266281.jpg" alt="Second slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Anastasios G. Leventis</h5>
                    <p>University House</p>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="https://c.ndtvimg.com/2021-04/7ejj5718_world-book-day_625x300_21_April_21.jpg?im=Resize=(1230,900)" alt="Third slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Faculty of Engineering</h5>
                    <p>University Campus</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                @foreach($books as $book)
                    <div class="col mb-5">
                        <div class="card h-100">
                            @if($book->is_highlighted)
                                <div class="badge bg-primary text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Highlighted</div>
                            @endif
                            @if($book->getAvailableStock() <= 0)
                                <div class="badge bg-warning text-white position-absolute" style="top: 0.5rem; left: 0.5rem">out of stock</div>
                            @endif

                            <!-- Product image-->
                            <img class="card-img-top" src="{{ $book->path ?? 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg' }}" style="max-width: 450px"  alt="{{$book->title}}" />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">{{ str_tease($book->title, 25)}}</h5>
                                    <!-- Product price-->
                                    Kopje: {{$book->getAvailableStock()}} - {{ display_price($book->price) }}
                                </div>
                                <div class="text-center p-4 pt-0">
                                    <a class="btn btn-outline-success btn-sm mt-auto" href="{{ route('books.show', ['slug' => $book->slug]) }}">Shiko me shume</a>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                @foreach($book->categories as $category)
                                    <span class="badge bg-info text-white"><small>{{$category->title}}</small></span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    {{ $books->links() }}
                </ul>
            </nav>
        </div>
    </section>
@endsection
