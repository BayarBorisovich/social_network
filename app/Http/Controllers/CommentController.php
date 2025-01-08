<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Models\Comment;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CommentController
{
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
}
