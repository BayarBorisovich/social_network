@extends('layouts.user.auth')

@section('content')

    <body>
    <form action="{{route('register')}}" method="post">
        <h1 class="registration">Registration</h1>
        @csrf

        <label for="name">Name:</label>
        @error('name')
        <p class="error">{{$message}}</p>
        @enderror
        <input type="text" id="name" name="name" value="{{old('name')}}" placeholder="name">

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

        {{--    @error('password_confirmation') {{$message}} @enderror--}}
        {{--    <label for="password_confirmation">Confirm Password:</label>--}}
        {{--    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="password_confirmation" >--}}


        <input type="submit" value="Register">
        <a href="{{ route('login') }}" class="login">Login</a>
    </form>
    </body>

@endsection
