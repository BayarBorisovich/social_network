@extends('layouts.user.updateUser')
@section('content')

    <body>
    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="Admin"
                                     class="rounded-circle p-1 bg-primary" width="110">
                                <div class="mt-3">
                                    <h4>{{ $user->name }}</h4>
{{--                                    <p class="text-secondary mb-1">дата рождения</p>--}}
                                    <p class="text-muted font-size-sm">{{ $user->email }}</p>
                                    <a href="{{ route('main') }}" class="btn btn-outline-primary">In Profile</a>
                                </div>
                            </div>
                            <hr class="my-4">
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            @if(Session::has('success'))
                                <div class="alert alert-success">
                                    {{Session::get('success')}}
                                </div>
                            @endif
                            <form action="{{ route('addUpdateUser') }}" method="post">
                                @csrf
                                <h3 class="mb-3">Data</h3>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" id=name" class="form-control" name="name"
                                               value="{{ $user->name }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" id="email" class="form-control" name="email"
                                               value="{{ $user->email }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="submit" class="btn btn-primary px-4" value="Save Changes">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('updateUserInformation') }}" method="post">
                                @csrf
                                <h3 class="mb-3">Information</h3>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Surname</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" id=surname" class="form-control" name="surname"
                                               value="{{ $user->information ? $user->information->surname : '' }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Patronymic</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" id="patronymic" class="form-control" name="patronymic"
                                               value="{{ $user->information ? $user->information->patronymic : '' }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Telephone</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" id="telephone" class="form-control" name="telephone"
                                               value="{{ $user->information ? $user->information->telephone : '' }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">City</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" id="city" class="form-control" name="city"
                                               value="{{ $user->information ? $user->information->city : '' }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">About me</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" id="about_me" class="form-control" name="about_me"
                                               value="{{ $user->information ? $user->information->about_me : '' }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="submit" class="btn btn-primary px-4" value="Save Changes">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

    </script>
    </body>

@endsection
