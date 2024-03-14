<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\CreatePostRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
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
        return view('post.createPost');
    }

    public function createPost(CreatePostRequest $request)
    {
        Post::create([
            'user_id' => Auth::id(),
            'content' => $request['content'],
        ]);

        return response([]);
    }


    public function getPosts(): RedirectResponse|View
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        return view('post.post', compact('user'));

    }

    public function getJsonPosts()
    {
        $user = Auth::user();

        $friendPosts = $user->friendPosts()->with('comment.author', 'author')->get();

        $like = $user->usersLike;

        $arr = [
            'posts' => $friendPosts,
            'like' => $like
        ];

        $posts = json_encode($arr);

        return $posts;
    }


    public function likePosts(int $postId)
    {
        User::find(Auth::id())->likeIt()->toggle($postId);

        return response([]);
    }

    public function creatComment(CreateCommentRequest $request, int $postId)
    {
        $request->validated();
        Comment::create([
            'post_id' => $postId,
            'comment' => $request->comment,
            'user_id' => Auth::id(),
        ]);

        return response([]);
    }


    public function deletePost(Post $post)
    {
        $post->delete();
        return $post;
    }


    public function updatePost(Request $request, Post $post)
    {
        $post->update([
            'content' => $request['content'],
        ]);

        return response([]);

    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
