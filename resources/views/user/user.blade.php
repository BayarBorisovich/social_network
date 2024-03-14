@extends('layouts.user.userList')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="content" class="content content-full-width">

                    <div class="profile-content">
                        <div class="btn btn-outline-warning">
                            <a href="{{ route('main') }}">In Profile</a>
                        </div>
                        <div class="text-right">
                            <a class="btn btn-success" href="{{ url()->previous() }}" role="button">Back</a>
                        </div>
                        <div class="tab-content p-0">
                            <users-component></users-component>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
