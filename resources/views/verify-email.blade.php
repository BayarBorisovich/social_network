@extends('layouts.index.main')

@section('content')
    <h1 class="log_in mb-3">Пожалуйста подтвердите свой e-mail</h1>

    @if(Session::has('message'))
        <div class="alert alert-success">
            {{Session::get('message')}}
        </div>
    @endif
    <form action="{{ route('verification.send') }}" method="post">
        @csrf
        <input type="submit" class="btn btn-success mb-3" value="Отправить e-mail повторно">
    </form>
@endsection
