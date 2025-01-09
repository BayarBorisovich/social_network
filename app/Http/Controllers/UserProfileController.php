<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserProfileController
{
    public function getTheUsersHomePage(int $friendId): RedirectResponse|View
    {
        $user = User::query()->findOrFail($friendId);

        $myPosts = $user->posts;

        return view('user.mainPageUser', compact('user', 'myPosts', 'friendId'));
    }

    public function getFormUsersFriends(int $userId): RedirectResponse|View
    {
        $user = User::query()->findOrFail($userId);

        $friends = User::query()->find($userId)->friends;

        return view('user.usersFriends', compact('user', 'friends', 'userId'));

    }
}
