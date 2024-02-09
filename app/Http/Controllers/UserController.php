<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Friend;
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

    public function getPosts()
    {

        if (!Auth::check()) {
            return redirect()->route('login');
        }


        $friends = User::find(Auth::id())->friends;
        foreach ($friends as $key => $elem) {
            $arrFriendId[] = $elem['friend_id'];
        }

        $friendPosts = Post::all()->whereIn('user_id', $arrFriendId);

        $users = User::all();

        return view('post', compact('friendPosts', 'users'));

    }

    public function friends()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $friends = User::find(Auth::id())->friends;

        foreach ($friends as $key => $elem) {
            $arrFriendId[] = $elem['friend_id'];
        }
        $friends = User::all()->find($arrFriendId);

        $user = Auth::user();

        return view('friends', compact('user', 'friends'));
    }

//    public function likes()
//    {
//        auth()->user()
//    }
}
