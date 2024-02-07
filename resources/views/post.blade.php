<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<header class="header">

    <form action="{{ route('post') }}" method="get">
        <div class="main">
            <h1>POSTS</h1>
        </div>
        @foreach($users as $key => $user)
            @foreach($friendPosts as $key => $friend)
                @if($user['id'] === $friend['user_id'])

                <div class="user">
                    <p> {{$user['name']}} </p>
                    <p class="date"> {{$friend['created_at']}}</p>
                </div>

                <div class="post">
                    <p> {{$friend['content']}}</p>

                </div>
                @endif
            @endforeach
        @endforeach
    </form>
</header>
</body>
</html>
<style>
    .header{
        background-color: white;
    }
     form {
         width: 1000px;
         margin: 0 auto;
     }
    .user{
        margin-left: 20px;
        background-color: white;
        width: 180px;
        border-radius: 10px;
        border: 2px solid #1c42a8;
        padding-left: 20px;
        color: #1c42a8;
        letter-spacing: 1px;
        margin-top: 50px;
        line-height: 0.3;
    }

    .post {
        background-color: white;
        align-content: center;
        width: 1000px;
        color: black;
        padding-left: 20px;

    }

    .main{
        background-color: #618fe5;
        color: white;
        margin: 0 auto;
        width: 200px;
        padding-left: 105px;
        align-content: start;
        border-radius: 10px;
        letter-spacing: 3px;
    }
    .date {
        font-size: 12px;
    }
</style>
