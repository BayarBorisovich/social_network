@extends('layouts.image.photo')

@section('content')
<form action="{{ route('photo') }}" method="get">
    <div id="content" class="container p-0">
        <div class="profile-header">
            <div class="profile-header-cover"></div>
            <div class="profile-header-content">
                <div class="profile-header-img">
                    <img src="http://localhost/storage/photo/L2z8oGVqhCL8EoohVhyyzfZApuheOrU7zaIBj4ir.jpg" alt/>
                </div>
                <div class="profile-header-info">
                    <h4 class="m-t-sm">Clyde Stanley</h4>
                    <p class="m-b-sm">UXUI + Frontend Developer</p>
                    <a href="{{ route('main') }}" class="btn btn-outline-warning">In Profile</a>
                </div>
            </div>
            <ul class="profile-header-tab nav nav-tabs">
                <li class="nav-item"><a href="https://www.bootdey.com/snippets/view/bs4-profile-with-timeline-posts"
                                        target="__blank" class="nav-link_">POSTS</a></li>
                <li class="nav-item"><a href="https://www.bootdey.com/snippets/view/bs4-profile-about" target="__blank"
                                        class="nav-link_">ABOUT</a></li>
                <li class="nav-item"><a href="https://www.bootdey.com/snippets/view/profile-photos" target="__blank"
                                        class="nav-link_">PHOTOS</a></li>
                <li class="nav-item"><a href="https://www.bootdey.com/snippets/view/profile-videos" target="__blank"
                                        class="nav-link_">VIDEOS</a></li>
                <li class="nav-item"><a href="https://www.bootdey.com/snippets/view/bs4-profile-friend-list"
                                        target="__blank" class="nav-link_ active show">FRIENDS</a></li>
            </ul>
        </div>
        <div class="profile-container">
            <div class="row row-space-20">
                <div class="col-md-8">
                    <div class="tab-content p-0">
                        <div class="tab-pane active show" id="profile-photos">
                            <div class="m-b-10"><b>Photos ({{ count($imageAll) }})</b></div>
                            <ul class="img-grid-list">
                                @isset($imageAll)
                                    @foreach($imageAll as $image)
                                        <li>
                                            <a href="#"><img src="{{ asset("/storage/" . $image->patch) }}" alt=""
                                                             class="img-portrait"/></a>
                                        </li>
                                    @endforeach
                                @endisset
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 hidden-xs hidden-sm">
                    <ul class="profile-info-list">
                        <li class="title">PERSONAL INFORMATION</li>
                        <li>
                            <div class="field">Occupation:</div>
                            <div class="value">UXUI / Frontend Developer</div>
                        </li>
                        <li>
                            <div class="field">Skills:</div>
                            <div class="value">C++, PHP, HTML5, CSS, jQuery, MYSQL, Ionic, Laravel, Phonegap, Bootstrap,
                                Angular JS, Angular JS, Asp.net
                            </div>
                        </li>
                        <li>
                            <div class="field">Birth of Date:</div>
                            <div class="value">1989/11/04</div>
                        </li>
                        <li>
                            <div class="field">Country:</div>
                            <div class="value">San Francisco</div>
                        </li>
                        <li>
                            <div class="field">Address:</div>
                            <div class="value">
                                <address class="m-b-0">
                                    Twitter, Inc.<br/>
                                    1355 Market Street, Suite 900<br/>
                                    San Francisco, CA 94103
                                </address>
                            </div>
                        </li>
                        <li>
                            <div class="field">Phone No.:</div>
                            <div class="value">
                                (123) 456-7890
                            </div>
                        </li>
                        <li class="title">FRIEND LIST (9)</li>
                        <li class="img-list">
                            <a href="#" class="m-b-5"><img src="https://www.bootdey.com/image/150x150/008B8B/000000"
                                                           alt/></a>
                            <a href="#" class="m-b-5"><img src="https://www.bootdey.com/image/150x150/008B8B/000000"
                                                           alt/></a>
                            <a href="#" class="m-b-5"><img src="https://www.bootdey.com/image/150x150/008B8B/000000"
                                                           alt/></a>
                            <a href="#" class="m-b-5"><img src="https://www.bootdey.com/image/150x150/008B8B/000000"
                                                           alt/></a>
                            <a href="#" class="m-b-5"><img src="https://www.bootdey.com/image/150x150/008B8B/000000"
                                                           alt/></a>
                            <a href="#" class="m-b-5"><img src="https://www.bootdey.com/image/150x150/008B8B/000000"
                                                           alt/></a>
                            <a href="#" class="m-b-5"><img src="https://www.bootdey.com/image/150x150/008B8B/000000"
                                                           alt/></a>
                            <a href="#" class="m-b-5"><img src="https://www.bootdey.com/image/150x150/008B8B/000000"
                                                           alt/></a>
                            <a href="#" class="m-b-5"><img src="https://www.bootdey.com/image/150x150/008B8B/000000"
                                                           alt/></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
