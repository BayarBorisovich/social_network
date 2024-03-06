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

                            <div class="tab-pane fade in active show" id="profile-friends">
                                <h4 class="m-t-0 m-b-20">Users List ({{ count($users) }})</h4>

                                <div class="row row-space-2">

                                    @foreach($users as $user)
                                        <div class="col-md-6 m-b-2">
                                            <div class="p-10 bg-white">
                                                <div class="media media-xs overflow-visible">

                                                    <a class="media-left" href="javascript:;">
                                                        <img
                                                            src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                                            alt
                                                            class="media-object img-circle">
                                                    </a>
                                                    {{ $user->id }}
                                                    <div class="media-body valign-middle">
                                                        <a href="{{ route('mainUser', $user) }}"
                                                           class="btn btn-xs btn-yellow">{{ $user->name }}</a>
                                                    </div>

                                                    <div
                                                        class="media-body valign-middle text-right overflow-visible">
                                                        <div class="btn-group dropdown">
                                                            <form action="{{ route('user')}}" method="post"
                                                                  class="addFriend">
                                                                <div class="media-body valign-middle">
                                                                    @csrf
                                                                    <input type="text" id="" class="form-control"
                                                                           name="id"
                                                                           placeholder="id" hidden=""
                                                                           value="{{ $user->id }}">
                                                                    @if(!isset($friendsId[$user->id]))
                                                                        <input type="submit"
                                                                               class="btn btn-primary"
                                                                               name="submit_form"
                                                                               value="Add to friends">
                                                                    @else
                                                                        <input type="button"
                                                                               class="btn btn-success"
                                                                               value="Friend" id="friend">
                                                                    @endif
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
