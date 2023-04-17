@extends('layouts.guest')

@section('content')
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card sigin-container o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block">
                                    <div class="header-container">
                                        <h2 class="signin-heading">Welcome to</h2>
                                        <p class="signin-subtitle"> E.F.E.E LIBRARY </p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 mb-4">{{ __('Reset Password') }}</h1>
                                        </div>
                                        @if (session('status'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('status') }}
                                            </div>
                                        @endif
                                        <form method="POST" action="{{ route('password.email') }}">
                                            @csrf
                                            <div class="form-group">
                                                <input placeholder="Email" id="email" type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <button type="submit" class="btn btn-outline-dark btn-user btn-block">
                                                {{ __('Send Password Reset Link') }}
                                            </button>
                                        </form>
                                        <hr>
                                        <div class="text-center">
                                            @if (Route::has('login'))
                                                <a class="small" href="{{ route('login') }}">
                                                    {{ __('Login?') }}
                                                </a>
                                            @endif
                                        </div>
                                        <div class="text-center">
                                            @if (Route::has('register'))
                                                <a class="small" href="{{ route('register') }}">
                                                    {{ __('Create an Account!') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>

            </div>
        </div>
    </div>
@endsection
