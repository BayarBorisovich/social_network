<!doctype html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <title>  </title>
    </head>
    <body>
        <h1 class="login">Login</h1>
        <form action="" method="post">

            @csrf

            <label for="email">Email:</label>
            @error('email')
            <p class="error">{{$message}}</p>
            @enderror
            <input type="email" id="email" name="email" value="{{old('email')}}" placeholder="email" required>


            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="password" >

            <input type="submit" value="Log In">
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
    .login{
       color: black;
    }
    .error{
        color: red;
    }
</style>
