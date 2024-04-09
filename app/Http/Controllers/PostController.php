<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\CreatePostRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Services\RabbitService;
use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private UserService $userService;
    private RabbitService $rabbitService;

    public function __construct(UserService $userService, RabbitService $rabbitService)
    {
        $this->userService = $userService;
        $this->rabbitService = $rabbitService;
    }

    public function getCreatPost(): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view('post.createPost');
    }

    /**
     * @throws \Exception
     */
    public function createPost(CreatePostRequest $request)
    {
        $user = Auth::user();

        Post::create([
            'user_id' => $user->id,
            'content' => $request['content'],
        ]);

        $queue = 'post';

        $data = [
            'content' => $request['content'],
            'id' => $user->id,
        ];

        $this->rabbitService->publich($data, $queue);

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

    public function getJsonPosts(): JsonResponse
    {
        $user = Auth::user();

        $friendPosts = $user->friendPosts()->with('comment.author', 'author')->get();

        $like = $user->usersLike;

        $arr = [
            'posts' => $friendPosts,
            'like' => $like
        ];

        return response()->json(['posts' => $arr]);
    }


    public function likePosts(int $postId)
    {
        User::find(Auth::id())->likeIt()->toggle($postId);

        return response([]);
    }

    public function creatComment(CreateCommentRequest $request, int $postId): Response
    {
        $request->validated();
        Comment::create([
            'post_id' => $postId,
            'comment' => $request->comment,
            'user_id' => Auth::id(),
        ]);

        return response([]);
    }


    public function deletePost(Post $post): Response
    {
        $post->delete();
        return response([]);
    }


    public function updatePost(Request $request, Post $post): Response
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
