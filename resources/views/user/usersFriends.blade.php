@extends('layouts.user.userList')

@section('content')

    <div class="container">
        <form action="{{ route('usersFriends', $userId) }}">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-right">
                        <a class="btn btn-success" href="{{ url()->previous(), $userId }}" role="button">Back</a>
                    </div>
                    <div id="content" class="content content-full-width">

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
                                        <a href="{{ route('main') }}" class="btn btn-xs btn-yellow">In Profile</a>
                                    </div>

                                </div>

                            </div>
                        </div>


                        <div class="profile-content">

                            <div class="tab-content p-0">

                                <div class="tab-pane fade in active show" id="profile-friends">
                                    <h4 class="m-t-0 m-b-20">Friend List ({{ count($friends) }})</h4>

                                    <div class="row row-space-2">
                                        @if(isset($friends))
                                            @foreach($friends as $friend)
                                                <div class="col-md-6 m-b-2">
                                                    <div class="p-10 bg-white">
                                                        <div class="media media-xs overflow-visible">

                                                            <a class="media-left" href="javascript:;">
                                                                <img
                                                                    src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                                                    alt
                                                                    class="media-object img-circle">
                                                            </a>
                                                            <div class="media-body valign-middle">
                                                                <b class="text-inverse">{{ $friend->name }}</b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <h4> "You don't have any friends" </h4>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
