<?php

namespace App\Http\Controllers;


use App\Models\Post;
use App\Models\User;
use App\Models\Friend;
use App\Models\UserPostLike;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class MainController extends Controller
{
    public function getForm()
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
//        dd($like);

        return view('main', compact('user', 'myPosts', 'like'));
    }

}
