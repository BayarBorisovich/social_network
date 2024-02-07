<!doctype html>
<html lang="" class="main">
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>

        <form action="{{route('registrate')}}" method="post">
            <h1 class="registration">Registration</h1>

            @csrf

            <label for="name">Name:</label>
            @error('name')
            <p class="error">{{$message}}</p>
            @enderror
            <input type="text" id="name" name="name" value="{{old('name')}}" placeholder="name" >

            <label for="surname">Surname:</label>
            @error('surname')
            <p class="error">{{$message}}</p>
            @enderror
            <input type="text" id="surname" name="surname" value="{{old('surname')}}" placeholder="surname" >

            <label for="patronymic">Patronymic:</label>
            @error('patronymic')
            <p class="error">{{$message}}</p>
            @enderror
            <input type="text" id="patronymic" name="patronymic" value="{{old('patronymic')}}" placeholder="patronymic" >

            <label for="email">Email:</label>
            @error('email')
            <p class="error">{{$message}}</p>
            @enderror
            <input type="email" id="email" name="email" value="{{old('email')}}" placeholder="email" required>

            <label for="password">Password:</label>
            @error('password')
            <p class="error">{{$message}}</p>
            @enderror
            <input type="password" id="password" name="password" placeholder="password" >

        {{--    @error('password_confirmation') {{$message}} @enderror--}}
        {{--    <label for="password_confirmation">Confirm Password:</label>--}}
        {{--    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="password_confirmation" >--}}


            <label for="phone">Phone:</label>
            @error('phone')
            <p class="error">{{$message}}</p>
            @enderror
            <input type="text" id="phone" name="phone" value="{{old('phone')}}" placeholder="phone" >

            <label for="date of birth">Date of birth:</label>
            @error('date_of_birth')
            <p class="error">{{$message}}</p>
            @enderror
            <input type="text" id="date of birth" name="date of birth" value="{{old('date_of_birth')}}" placeholder="date of birth" >

            <label for="gender">Gender:</label>
            @error('gender')
            <p class="error">{{$message}}</p>
            @enderror
            <input type="text" id="gender" name="gender" value="{{old('gender')}}" placeholder="gender" >

            <label for="about of me">About of me:</label>
            @error('about_of_me')
            <p class="error">{{$message}}</p>
            @enderror
            <input type="text" id="about of me" name="about of me" value="{{old('about_of_me')}}" placeholder="about of me" >

            <input type="submit" value="Register">
        </form>
    </body>
</html>






<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
    }

    .container {
        max-width: 500px;
        margin: auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        margin-bottom: 16px;
    }

    input[type="submit"] {
        background-color: #4CAF50;
        color: #fff;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }
    .error{
        color: red;
    }
</style>
