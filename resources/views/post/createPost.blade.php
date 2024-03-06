@extends('layouts.post.createPost')

@section('content')

    <div class="container light-style flex-grow-1 container-p-y">
        <form action="{{ route('post.create') }}" method="post">
            @csrf
            <h4 class="font-weight-bold py-3 mb-4">
                Creat Post
            </h4>
            <div class="text-right">
                <a class="btn btn-success" href="{{ url()->previous() }}" role="button">Back</a>
            </div>
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a href="{{ route('main') }}" class="btn btn-sm btn-info mb-2">In Profile</a>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade active show" id="account-general">
                <div class="card-body media align-items-center">
                    <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt
                         class="d-block ui-w-80">
                </div>
                @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{Session::get('success')}}
                    </div>
                @endif

                <hr class="border-light m-0">
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">New post</label>
                        @error('content')
                        <p class="error">{{$message}}</p>
                        @enderror
                        <input type="text" id="content" class="form-control mb-1"
                               name="content"
                               placeholder="content"
                               value="">
                    </div>
                </div>
            </div>
            <div class="text-right mt-3">
                <input type="submit" class="btn btn-primary"
                       value="Creat">
            </div>
        </form>
    </div>

@endsection


