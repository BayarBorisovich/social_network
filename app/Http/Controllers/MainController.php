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
        $myPosts = Post::all()->where('user_id', Auth::id());
        $likes = UserPostLike::all()->where('user_id', Auth::id());

        $like = [];
        foreach ($likes as $lik) {
            $like[$lik['post_id']] = $lik['post_id'];
        }

        return view('index.main', compact('user', 'myPosts', 'like'));
    }


}
