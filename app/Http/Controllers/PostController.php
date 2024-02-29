<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Models\UserPostLike;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function getCreatPost(): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view('createPost');
    }

    public function createPost(CreatePostRequest $request): RedirectResponse
    {
        Post::create([
            'user_id' => Auth::id(),
            'content' => $request['content'],
        ]);

        return redirect()->back()->withSuccess('The post was created successfully');
    }


    public function getPosts(): RedirectResponse|View
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $friendPosts = $user->friendPosts()->with('author.comment')->get();

        return view('post', compact('friendPosts',  'user'));

    }


    public function likePosts(Request $request): RedirectResponse
    {
        User::find(Auth::id())->likeIt()->toggle($request->post_id);

        return redirect()->back();
    }

    public function creatComment(Request $request): RedirectResponse
    {
        Comment::create([
            'post_id' => $request->post_id,
            'comment' => $request->comment,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back();
    }


    public function deletePost(Request $request): RedirectResponse
    {
        $post = Post::find($request->delete);

        $post->delete();

        return redirect()->route('main');
    }


    public function updatePost(Request $request): RedirectResponse
    {
        $post = Post::find($request->update);

        $post->update([
            'content' => $request['content'],
        ]);

        return redirect()->route('main');

    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
