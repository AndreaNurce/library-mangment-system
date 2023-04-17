<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'E.F.E.E') }}</title>

    <!-- Custom fonts for this template-->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{ asset('css/index.css')}}" rel="stylesheet">
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Custom styles for this template-->
    <link href="{{ asset('css/custom.css')}}" rel="stylesheet">
    @yield('styles')
    @stack('styles')

</head>
<body class="auth-container">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark ">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="{{url('/')}}">{{ config('app.name', 'E.F.E.E') }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">MORE</a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('home', ['filter_by' => 'latest']) }}">
                                <i class="fas fa-bars fa-sm fa-fw mr-2 text-gray-400"></i>
                                Te fundit
                            </a>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('home', ['filter_by' => 'most_viewed']) }}">
                                <i class="fas fa-eye fa-sm fa-fw mr-2 text-gray-400"></i>
                                Me te SHikuarat
                            </a>
                            <a class="dropdown-item" href="{{ route('home', ['filter_by' => 'highlighted']) }}">
                                <i class="fas fa-check fa-sm fa-fw mr-2 text-gray-400"></i>
                                Te Zgjedhurat
                            </a>
                        </div>
                    </li>
                    @if($categories->isNotEmpty())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="categoryDropdown" href="#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Kategorite</a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="categoryDropdown">
                                @foreach($categories as $category)
                                    <a class="dropdown-item" href="{{ route('categories.show', ['slug' => $category->slug]) }}">
                                        <i class="fas fa-minus fa-sm fa-fw mr-2 text-gray-400"></i>
                                        {{ $category->title }}
                                    </a>
                                @endforeach
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
            <form class="d-flex">
                @guest
                    @if (Route::has('login'))
                        <a class="btn " href="{{ route('login') }}">{{ __('Login') }}</a>
                    @endif

                    @if (Route::has('register'))
                        <a class="btn " href="{{ route('register') }}">{{ __('Register') }}</a>
                    @endif
                @else
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="navbarDropdown">
                                @if(auth()->user()->isAdmin())
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}" >
                                        <i class="fas fa-home fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Paneli
                                    </a>
                                @endif
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                @endguest
            </form>
        </div>
    </nav>

    @yield('content')

    @include('_partials.logout-modal')
    <!-- Footer-->
    <footer class="py-5" style="background: transparent">
        <div class="container"><p class="m-0 text-center text-white">Copyright &copy; E.F.E.E  {{ date('Y') }}</p></div>
    </footer>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/index.min.js')}}"></script>
    {{-- TOASTR.JS --}}
    <script>
        // toastr.options = {
        //     "closeButton": true,
        //     "debug": false,
        //     "progressBar": true,
        //     "preventDuplicates": false,
        //     "positionClass": "toast-top-right",
        //     "onclick": null,
        //     "showDuration": "500",
        //     "hideDuration": "1000",
        //     "timeOut": "5000",
        //     "extendedTimeOut": "1000",
        //     "showEasing": "swing",
        //     "hideEasing": "linear",
        //     "showMethod": "fadeIn",
        //     "hideMethod": "fadeOut"
        // };
        @if(Session::has('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if(Session::has('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if(Session::has('info'))
            toastr.info("{{ session('info') }}");
        @endif

        @if(Session::has('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif
    </script>
    @yield('scripts')
</body>
</html>
