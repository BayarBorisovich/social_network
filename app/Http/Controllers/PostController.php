<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Post;
use App\Services\RabbitService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private RabbitService $rabbitService;

    public function __construct(RabbitService $rabbitService)
    {
        $this->rabbitService = $rabbitService;
    }

    public function showCreatePosts(): View|RedirectResponse
    {
        return view('post.createPost');
    }

    public function create(CreatePostRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();

        $post = Post::query()->create([
            'user_id' => $user->id,
            'content' => $data['content'],
        ]);

        try {
            $this->rabbitService->publish([
                'content' => $post->content,
                'id' => $user->id,
            ], 'post');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to publish message'], 500);
        }

        return response()->json(['message' => 'Post created successfully']);
    }


    public function showFormFriendsPosts(): RedirectResponse|View
    {
        $user = Auth::user();

        return view('post.post', compact('user'));

    }

    public function getFriendsPosts(): JsonResponse
    {
        $user = Auth::user();

        $friendPosts = $user->friendPosts()->with('comment.author', 'author')->get();
        $likes = $user->usersLike;

        return response()->json([
            'posts' => $friendPosts,
            'likes' => $likes,
        ]);
    }

    public function delete(Post $post): Response
    {
        $post->delete();
        return response([]);
    }

    public function update(Request $request, Post $post): Response
    {
        $post->update([
            'content' => $request['content'],
        ]);

        return response([]);
    }
}
