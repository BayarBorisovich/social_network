<?php

namespace App\Services;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    public function friends(int $id): Collection|null
    {
        $friends = User::find($id)->friends;

        if (!$friends) {
            return null;
        }

        $imAFriends = Friend::find($id)->ImAFriend;

        if (!$imAFriends) {
            return null;
        }

        $arrFriendId = [];
        foreach ($friends as $friend) {
            $arrFriendId[] = $friend->id;

        }

        foreach ($imAFriends as $imAFriend) {
            $arrFriendId[] = $imAFriend->id;
        }

        $allFriends = User::all()->find($arrFriendId);
        if (!$allFriends) {
            return null;
        }
        return $allFriends;
    }

}
