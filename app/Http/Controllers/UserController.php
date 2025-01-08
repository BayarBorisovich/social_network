<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function showFormsUsers(): RedirectResponse|View
    {
        return view('user.user');
    }

    public function getUsers(): JsonResponse
    {
        $id = Auth::id();

        $friendsId = $this->userService->getFriendIds($id);

        $users = User::all();

        return response()->json([
            'users' => $users,
            'friendIds' => $friendsId
        ]);
    }

}
