<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CommentController
{
    public function creatComment(CreateCommentRequest $request, int $postId): JsonResponse
    {
        try {
            $validated = $request->validated();
            $comment = Comment::query()->create([
                'post_id' => $postId,
                'comment' => $validated['comment'],
                'user_id' => Auth::id(),
            ]);

            return response()->json(['message' => 'Comment created successfully', 'comment' => $comment], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to create comment'], 500);
        }
    }

}
