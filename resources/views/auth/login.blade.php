@extends('layouts.user.auth')

@section('content')

    <body>
    <h1 class="log_in">Login</h1>
    <form action="" method="post">

        @csrf

        <label for="email">Email:</label>
        @error('email')
        <p class="error">{{$message}}</p>
        @enderror
        <input type="email" id="email" name="email" value="{{old('email')}}" placeholder="email" required>


        <label for="password">Password:</label>
        @error('password')
        <p class="error">{{$message}}</p>
        @enderror
        <input type="password" id="password" name="password" placeholder="password">

        <input type="submit" value="Log In">
        <a href="{{ route('register') }}" class="register">Register</a>
    </form>
    </body>

@endsection
