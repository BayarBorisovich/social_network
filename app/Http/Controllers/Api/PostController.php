<?php
//
//namespace App\Http\Controllers\Api;
//
//use Illuminate\Support\Facades\Auth;
//
//class PostController
//{
//    public function getJsonPosts()
//    {
//        $user = auth()->user();
//        dd($user);
//        $friendPosts = $user->friendPosts()->with('comment.author', 'author')->get();
//
//        $like = $user->usersLike;
//
//        $arr = [
//            'posts' => $friendPosts,
//            'like' => $like
//        ];
//
//        $posts = json_encode($arr);
//
//        return $posts;
//    }
//}
