@extends('layouts.post.post')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-right">
                    <a class="btn btn-success" href="{{ url()->previous() }}" role="button">Back</a>
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
                                    <a href="{{ route('main') }}" class="btn btn-sm btn-info mb-2">In Profile</a>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="profile-content">

                        <div class="tab-content p-0">

                            <div class="tab-pane fade active show" id="profile-post">
                                <ul class="timeline">
                                    <component-posts></component-posts>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
