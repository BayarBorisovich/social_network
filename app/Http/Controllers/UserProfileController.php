<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserProfileController
{
    public function getTheUsersHomePage($friendId): RedirectResponse|View
    {
        $user = User::find($friendId);

        $myPosts = $user->post;

        return view('user.mainPageUser', compact('user', 'myPosts', 'friendId'));
    }

    public function getFormUsersFriends(int $userId): RedirectResponse|View
    {
        $user = User::find($userId);

        $friends = User::find($userId)->friends;

        return view('user.usersFriends', compact('user', 'friends', 'userId'));

    }
}
