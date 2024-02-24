<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Models\UserPostLike;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function getFormCreatPost()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view('creatPost');
    }

    public function creatPost(Request $request)
    {
        Post::create([
            'user_id' => Auth::id(),
            'content' => $request['content'],
        ]);

        return redirect()->route('main');
    }


    public function getPosts()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $users = User::all();
        $user = Auth::user();

        $friends = User::find(Auth::id())->friends;

        $arrFriendId = [];
        foreach ($friends as $key => $elem) {
            $arrFriendId[] = $elem['friend_id'];
        }

        $friendPosts = Post::all()->whereIn('user_id', $arrFriendId);

        $likes = UserPostLike::all()->where('user_id', Auth::id());

        $like = [];
        foreach ($likes as $lik) {
            $like[$lik['post_id']] = $lik['post_id'];
        }

        $comments = Comment::all();

        return view('post', compact('friendPosts', 'users', 'user', 'like', 'comments'));

        //        dd($user->post->contains(5));
    }


    public function likePosts(Request $request)
    {
        if (isset($request->comment)) {
            return $this->creatComment($request);
        }
        User::find(Auth::id())->post()->toggle($request->post_id);

        return redirect()->back();
    }
    public function creatComment(Request $request)
    {

        Comment::create([
            'post_id' => $request->post_id,
            'comment' => $request->comment,
            'user_id' => Auth::id(),
        ]);
        return redirect()->back();
    }


    public function deletePost(Request $request)
    {
        if (isset($request->update)) {

            return $this->updatePost($request);
        }

        $post = Post::find($request->delete);

        $post->delete();

        return redirect()->route('main');
    }


    public function updatePost(Request $request)
    {
        if (isset($request->delete)) {
            return $this->deletePost($request);
        }
        if (isset($request->post_id)) {
            return $this->likePosts($request);
        }
        if (isset($request->update)) {
            $post = Post::find($request->update);

            $post->update([
                'content' => $request['content'],
            ]);

            return redirect()->route('main');
        }
        else {
            return $this->logout($request);
        }

    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
