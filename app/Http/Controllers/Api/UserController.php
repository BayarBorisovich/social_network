<?php

namespace App\Http\Controllers\Api;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController
{
    public function getJsonUsers()
    {
        $id = Auth::id();
        dd($id);

        $friends = User::find($id)->friends;

        $myFriends = Friend::where('friend_id', $id)->get();

        $friendsId = [];
        foreach ($friends as $friend) {
            $friendsId[$friend->id] = $friend->id;

        }

        foreach ($myFriends as $myFriend) {
            $friendsId[$myFriend->user_id] = $myFriend->user_id;
        }

        $users = User::all();

        $allUsers = [
            'users' => $users,
            'friendIds' => $friendsId
        ];

        $users = json_encode($allUsers);

        return $users;
    }
}
