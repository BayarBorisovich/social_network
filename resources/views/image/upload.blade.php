@extends('layouts.image.uploadImage')

@section('content')
    <div id="content" class="container p-0">
        <div class="profile-header">
            <div class="profile-header-cover"></div>
            <div class="profile-header-content">
                <div class="profile-header-img">
                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt/>
                </div>
                <div class="profile-header-info">
                    <h4 class="m-t-sm">Clyde Stanley</h4>
                    <p class="m-b-sm">UXUI + Frontend Developer</p>
                    <a href="{{ route('main') }}" class="btn btn-outline-warning">In Profile</a>
                </div>
            </div>
        </div>
        <div class="profile-container">
            <div class="row row-space-20">
                <div class="col-md-12">
                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{Session::get('success')}}
                        </div>
                    @endif
                    <form action="{{ route('image') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="inputImage">Image:</label>
                            <input
                                type="file"
                                name="image"
                                id="inputImage"
                                class="form-control @error('image') is-invalid @enderror">
                            @error('image')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 text-right">
                            <button type="submit" class="btn btn-success">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
            @isset($path)
                <img class="img-fluid" src="{{ asset('/storage/' . $path) }}" alt="">
            @endisset
        </div>
    </div>
@endsection
