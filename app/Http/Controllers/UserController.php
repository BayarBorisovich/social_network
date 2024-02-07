<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\UserFriends;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController
{
    public function getFormRegistrate(): View
    {
        return view('registrate');
    }

    public function postRegistrate(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'surname' => 'required|string',
            'patronymic' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string', //confirmed
            'phone' => 'required|string|max:14',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string',
            'about_of_me' => 'string|nullable',
        ]);
        $data = $request->all();
        $check = $this->create($data);

        return redirect()->route('login');

    }

    public function create($data)
    {
        return User::create([
            '_token' => $data['_token'],
            'name' => $data['name'],
            'surname' => $data['surname'],
            'patronymic' => $data['patronymic'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'date_of_birth' => $data['date_of_birth'],
            'gender' => $data['gender'],
            'about_of_me' => $data['about_of_me'],
        ]);
    }

    public function getFormLogin(): View
    {
        return view('login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => ['required'],
            'password' => ['required'], //confirmed
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            throw Validationexception::withMessages([
                'email' => 'These credentials do not match our records.'
            ]);
        }

        return redirect()->route('main');

    }

    public function getFormPost(): \Illuminate\View\View
    {
        return view('post');
    }

    public function getPost()
    {
        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('login');
        }
        $users = User::all();

        $userFriends = User::find($userId)->userFriends;
        foreach ($userFriends as $key => $elem) {
            $arrFriendId[] = $elem['friend_id'];
        }

        $posts = Post::all();

        $friendPosts = $posts->intersect(Post::whereIn('user_id', $arrFriendId)->get());

        return view('post', compact('friendPosts', 'users'));

    }

    public function friends()
    {
        $userId = Auth::id();

        if (!$userId) {
            return redirect()->route('login');
        }
        $user = User::all()->find($userId);

        $userFriends = User::find($userId)->userFriends;

        foreach ($userFriends as $key => $elem) {
            $arrFriendId[] = $elem['friend_id'];
        }
        $friends = User::all()->find($arrFriendId);

        $userFriendsAll = UserFriends::all();

        $friendsOfFriends = $userFriendsAll->intersect(UserFriends::whereIn('user_id', $arrFriendId)->get());
////        dd($friendsOfFriends);
//        foreach ($friendsOfFriends as $key => $friendsOfFriend) {
//            foreach ($friends as $key => $friend) {
//                if ($friend->id === $friendsOfFriend['user_id']) {
//                    echo $friend->id;
//                }
//            }
//        }
//
//        die();
        return view('friend', compact('user', 'friends', 'friendsOfFriends'));
    }
}
