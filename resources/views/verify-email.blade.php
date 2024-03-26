@extends('layouts.user.registrateLogin')

@section('content')
    <h1 class="log_in">Подтвердите e-mail</h1>

    <p>Необходимо подтверждение e-mail</p>
    <a href="{{ route('verification.send') }}" class="registrate">Отправить повторно</a>
@endsection
