<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\UserPostLike;
use Illuminate\Support\Facades\Auth;


class MainController extends Controller
{
    public function getMain()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $user = Auth::user();
//        $myPosts = Post::all()->where('user_id', Auth::id());

        return view('index.main', compact('user'));
    }

    public function getJsonMain()
    {
        $myPosts = Post::all()->where('user_id', Auth::id());

        $posts = json_encode($myPosts);

        return $posts;
    }


}
