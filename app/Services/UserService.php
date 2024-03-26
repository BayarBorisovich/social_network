<?php

namespace App\Services;

use App\Models\Friend;
use App\Models\User;

class UserService
{
    public function friends(int $id)
    {
        $friends = User::find($id)->friends;

        $imAFriends = Friend::find($id)->ImAFriend;

        $arrFriendId = [];
        foreach ($friends as $friend) {
            $arrFriendId[] = $friend->id;

        }

        foreach ($imAFriends as $imAFriend) {
            $arrFriendId[] = $imAFriend->id;
        }
        return User::all()->find($arrFriendId);
    }

}
