@extends('layouts.user.userList')

@section('content')

<div class="container">
    <form action="{{ route('friends') }}" method="get">
        <div class="row">
            <div class="col-md-12">
                <div id="content" class="content content-full-width">
                    <div class="text-right">
                        <a class="btn btn-success" href="{{ url()->previous() }}" role="button">Back</a>
                    </div>
                    <div class="profile">
                        <div class="profile-header">

                            <div class="profile-header-cover"></div>


                            <div class="profile-header-content">

                                <div class="profile-header-img">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt>
                                </div>


                                <div class="profile-header-info">
                                    <h4 class="m-t-10 m-b-5">{{ $user->name }}</h4>
                                    <p class="m-b-10">{{ $user->about_of_me }}</p>
                                    <a href="{{ route('main') }}" class="btn btn-outline-warning">In Profile</a>
                                </div>

                            </div>


                            <ul class="profile-header-tab nav nav-tabs">
                                <li class="nav-item"><a
                                        href="{{ route('post') }}"
                                        target="__blank" class="nav-link_">POSTS</a></li>
                                <li class="nav-item"><a href="#"
                                                        target="__blank" class="nav-link_">PHOTOS</a></li>
                                <li class="nav-item"><a
                                        href="{{ route('friends') }}"
                                        target="__blank" class="nav-link_ active show">FRIENDS</a></li>
                            </ul>

                        </div>
                    </div>


                    <div class="profile-content">

                        <div class="tab-content p-0">

                            <friend-component></friend-component>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection
