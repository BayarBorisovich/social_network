@extends('layouts.user.registrateLogin')

@section('content')

    <body>
    <form action="{{route('registrate')}}" method="post">
        <h1 class="registration">Registration</h1>
        @csrf

        <label for="name">Name:</label>
        @error('name')
        <p class="error">{{$message}}</p>
        @enderror
        <input type="text" id="name" name="name" value="{{old('name')}}" placeholder="name">

        <label for="surname">Surname:</label>
        @error('surname')
        <p class="error">{{$message}}</p>
        @enderror
        <input type="text" id="surname" name="surname" value="{{old('surname')}}" placeholder="surname">

        <label for="patronymic">Patronymic:</label>
        @error('patronymic')
        <p class="error">{{$message}}</p>
        @enderror
        <input type="text" id="patronymic" name="patronymic" value="{{old('patronymic')}}" placeholder="patronymic">

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


        <label for="phone">Phone:</label>
        @error('phone')
        <p class="error">{{$message}}</p>
        @enderror
        <input type="text" id="phone" name="phone" value="{{old('phone')}}" placeholder="phone">

        <label for="date of birth">Date of birth:</label>
        @error('date_of_birth')
        <p class="error">{{$message}}</p>
        @enderror
        <input type="text" id="date of birth" name="date of birth" value="{{old('date_of_birth')}}"
               placeholder="date of birth">

        <label for="gender">Gender:</label>
        @error('gender')
        <p class="error">{{$message}}</p>
        @enderror
        <input type="text" id="gender" name="gender" value="{{old('gender')}}" placeholder="gender">

        <label for="about of me">About of me:</label>
        @error('about_of_me')
        <p class="error">{{$message}}</p>
        @enderror
        <input type="text" id="about of me" name="about of me" value="{{old('about_of_me')}}" placeholder="about of me">

        <input type="submit" value="Register">
        <a href="{{ route('login') }}" class="login">Login</a>
    </form>
    </body>

@endsection
