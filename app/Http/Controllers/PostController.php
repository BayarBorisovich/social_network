<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Models\UserPostLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function getCreatPost()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view('createPost');
    }

    public function createPost(CreatePostRequest $request)
    {
        Post::create([
            'user_id' => Auth::id(),
            'content' => $request['content'],
        ]);

        return redirect()->back()->withSuccess('The post was created successfully');
    }


    public function getPosts()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $users = User::all();

        $user = Auth::user();

        $friendPosts = $user->friendPosts;

        $likes = $user->userLike;

//        $posts = Post::with('likes')->get();
//        dd($posts);
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
        User::find(Auth::id())->likes()->toggle($request->post_id);

        return redirect()->back();
    }

    public function creatComment(Request $request)
    {
        if (isset($request->comment)) {

            Comment::create([
                'post_id' => $request->post_id,
                'comment' => $request->comment,
                'user_id' => Auth::id(),
            ]);

            return redirect()->back();
        }
        return $this->likePosts($request);
    }


    public function deletePost(Request $request)
    {
        $post = Post::find($request->delete);

        $post->delete();

        return redirect()->route('main');
    }


    public function updatePost(Request $request)
    {
        $post = Post::find($request->update);

        $post->update([
            'content' => $request->content,
        ]);

        return redirect()->route('main');

    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
