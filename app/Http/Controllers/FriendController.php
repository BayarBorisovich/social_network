<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class FriendController
{
    private UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function showFormFriends(): RedirectResponse|View
    {
        $user = Auth::user();

        return view('user.friends', compact('user'));
    }
    public function addFriend(int $userId)
    {
        Friend::create([
            'user_id' => Auth::id(),
            'friend_id' => $userId,
        ]);

        return response([]);

    }

    public function getFriends(): JsonResponse
    {
        $id = Auth::id();

        $friends = $this->userService->friends($id);

        return response()->json(['friends' => $friends]);
    }

    public function deleteFriend(int $friendId)
    {
        $userId = Auth::id();

        $friend = Friend::where('user_id', $userId)->where('friend_id', $friendId)->first();

        $imAFriend = Friend::where('user_id', $friendId)->where('friend_id', $userId)->first();

        if (!empty($friend)) {
            $friend->delete();
        } else {
            $imAFriend->delete();
        }

        return response([]);
    }
}
