@extends('layouts.post.createPost')

@section('content')

    <div class="container light-style flex-grow-1 container-p-y">
        <form action="{{ route('post.create') }}" method="get">
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
            </div>
            <create-component> </create-component>
        </form>
    </div>

@endsection


