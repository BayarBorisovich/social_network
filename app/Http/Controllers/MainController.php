<?php

namespace App\Http\Controllers;


use App\Models\Post;
use App\Models\User;
use App\Models\UserFriends;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class MainController extends Controller
{
    public function getForm(): View
    {
        $userId = Auth::id();

        $user = User::all()->find($userId);


        return view('main', compact('user'));
    }


}
