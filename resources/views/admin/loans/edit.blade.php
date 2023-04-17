@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between">
        <h1 class="h3 mb-0 text-gray-800">Perdorues</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Editing</li>
            <li class="breadcrumb-item active">{{$user->full_name}}</li>
        </ol>
    </div>

    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="card-title m-0 font-weight-bold text-primary">Perditso Perdoruesin</h5>
            <p class="card-title-desc">Plotesoni formularin me te dhenat e perdoruesit qe deshironi te perditesoni!</p>
        </div>
        <div class="card-body">
            <form class="ajax-form" action="{{ route('admin.users.update', ['user' => $user]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Emrin</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ $user->name }}"/>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lastname">Lastname</label>
                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Lastname" value="{{ $user->lastname }}"/>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="{{ $user->email }}"/>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Passwordi</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Fjalekalimi"/>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description">Gjinia</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="male" value="{{ \App\Enums\GenderEnum::MALE }}" @checked($user->gender ==  \App\Enums\GenderEnum::MALE)>
                                <label class="form-check-label" for="male">Mashkull</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="{{ \App\Enums\GenderEnum::FEMALE }}" @checked($user->gender ==  \App\Enums\GenderEnum::FEMALE)>
                                <label class="form-check-label" for="female">Femer</label>
                            </div>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="birthdate">Datelindja</label>
                            <input type="date" name="birthdate" id="birthdate" class="form-control" placeholder="Datelindja" value="{{ $user->birthdate?->toDateString() }}"/>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="role">Roli</label>
                            <select name="role" id="role" class="form-control select2" style="width: 100%">
                                <option value="">Selektoni nje Rol</option>
                                @foreach(\App\Enums\UserRoleEnum::toArray() as $role)
                                    <option value="{{ $role }}" @selected($user->role == $role)>{{ \App\Enums\UserRoleEnum::getLabel($role) }}</option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Statusi</label>
                            <select name="status" id="status" class="form-control select2" style="width: 100%">
                                <option value="">Selektoni Statusin</option>
                                @foreach(\App\Enums\StatusEnum::toArray() as $status)
                                    <option value="{{ $status }}" @selected($user->status == $status)>{{ \App\Enums\StatusEnum::getLabel($status) }}</option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" role="alert"><strong></strong></span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary mr-1 submit-btn">
                                Krijo <i class="fa fa-spinner fa-spin d-none"></i>
                            </button>
                            <a href="{{route('admin.users.index')}}" class="btn btn-secondary"> <i class="fas fa-arrow-left"></i>
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
