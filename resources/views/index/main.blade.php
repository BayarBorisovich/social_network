@extends('layouts.index.main')

@section('content')
<div class="container">
    <div class="text-right" id="app">
        <form method="post" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Logout</button>
        </form>
    </div>
    <div class="profile-page tx-13">
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="profile-header">
                    <div class="cover">
                        <div class="gray-shade">
                            <weather-component></weather-component>
                        </div>
                        <figure>
                            <img src="https://bootdey.com/img/Content/bg1.jpg" class="img-fluid"
                                 alt="profile cover">
                        </figure>
                        <div class="cover-body d-flex justify-content-between align-items-center">
                            <div>
                                <img class="profile-pic" src="https://bootdey.com/img/Content/avatar/avatar6.png"
                                     alt="profile">
                                <span class="profile-name">{{ $user->name }}</span>
                            </div>
                            <div class="d-none d-md-block">
                                <button class="btn btn-outline-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round"
                                         class="feather feather-edit btn-icon-prepend">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                    <a class="" href="{{ route('profile') }}">Edit profile</a>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="header-links">
                        <ul class="links d-flex align-items-center mt-3 mt-md-0">
                            <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-columns mr-1 icon-md">
                                    <path
                                        d="M12 3h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7m0-18H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h7m0-18v18"></path>
                                </svg>
                                <a class="pt-1px d-none d-md-block" href="{{ route('post.create') }}">Creat Post</a>
                            </li>
                            <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-columns mr-1 icon-md">
                                    <path
                                        d="M12 3h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7m0-18H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h7m0-18v18"></path>
                                </svg>
                                <a class="pt-1px d-none d-md-block" href="{{ route('post') }}">Posts by friends</a>
                            </li>
                            <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-users mr-1 icon-md">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                                <a class="pt-1px d-none d-md-block" href="{{ route('friends') }}">Friends <span
                                        class="text-muted tx-12"></span></a>
                            </li>
                            <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-image mr-1 icon-md">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                                <a class="pt-1px d-none d-md-block" href="{{ route('photo') }}">Photos</a>
                            </li>
                            <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-image mr-1 icon-md">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                                <a class="pt-1px d-none d-md-block" href="{{ route('image') }}">Upload an image</a>
                            </li>
                            <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-users mr-1 icon-md">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                                <a class="pt-1px d-none d-md-block" href="{{ route('user') }}">Users<span
                                        class="text-muted tx-12"></span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row profile-body">

            <div class="d-none d-md-block col-md-4 col-xl-3 left-wrapper">
                <div class="card rounded">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h6 class="card-title mb-0">About</h6>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round"
                                         class="feather feather-more-horizontal icon-lg text-muted pb-3px">
                                        <circle cx="12" cy="12" r="1"></circle>
                                        <circle cx="19" cy="12" r="1"></circle>
                                        <circle cx="5" cy="12" r="1"></circle>
                                    </svg>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-edit-2 icon-sm mr-2">
                                            <path
                                                d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        </svg>
                                        <span class>Edit</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-git-branch icon-sm mr-2">
                                            <line x1="6" y1="3" x2="6" y2="15"></line>
                                            <circle cx="18" cy="6" r="3"></circle>
                                            <circle cx="6" cy="18" r="3"></circle>
                                            <path d="M18 9a9 9 0 0 1-9 9"></path>
                                        </svg>
                                        <span class>Update</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-eye icon-sm mr-2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                        <span class>View all</span></a>
                                </div>
                            </div>
                        </div>
                        <p>{{ $user->about_of_me }}</p>
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Joined:</label>
                            <p class="text-muted">{{ $user->created_at->toDayDateTimeString() }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Lives:</label>
                            <p class="text-muted">{{ $user->information ? $user->information->city : '-' }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">{{ $user->email }}:</label>
                            <p class="text-muted"><a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                                     data-cfemail="cba6ae8ba5a4a9a7aebea2e5a8a4a6">[email&#160;protected]</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-8 col-xl-6 middle-wrapper">
                <div class="row">
                    <component-main></component-main>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
