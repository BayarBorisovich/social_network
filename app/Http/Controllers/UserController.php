<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Post;
use App\Models\User;
use App\Models\Friend;
use App\Models\UserPostLike;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
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

    public function getFormUpdateUser()
    {
        $user = Auth::user();
        return view('updateUser', compact('user'));
    }

    public function updateUser(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $user->update([
            'name' => $request->name,
            'surname' => $request->surname,
            'patronymic' => $request->patronymic,
            'email' => $request->email,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'about_of_me' => $request->about_of_me,
        ]);

        return redirect()->route('updateUser');
    }


    public function getFormUsers()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $friends = User::find(Auth::id())->friends;

        $myFriends = Friend::where('friend_id', Auth::id())->get();

        foreach ($friends as $friend) {
            $friendsId[$friend['friend_id']] = $friend['friend_id'];
        }

        foreach ($myFriends as $myFriend) {
            $friendsId[$myFriend['user_id']] = $myFriend['user_id'];
        }

        $users = User::all();

        $id = Auth::id();

        if (!isset($friendsId)) {
            return view('user', compact('users', 'id'));
        }

        return view('user', compact('users', 'friendsId', 'id'));
    }

    public function addFriend(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $users = User::all();

        Friend::create([
            'user_id' => Auth::id(),
            'friend_id' => $request['id'],
        ]);

        $friends = User::find(Auth::id())->friends;
        foreach ($friends as $friend) {
            $friendsId[$friend['friend_id']] = $friend['friend_id'];
        }

        return view('user', compact('users', 'friendsId'));

    }

    public function getFormFriends()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $friends = User::find(Auth::id())->friends;

        $myFriends = Friend::where('friend_id', Auth::id())->get();

        foreach ($friends as $friend) {
            $arrFriendId[] = $friend['friend_id'];

        }
        foreach ($myFriends as $myFriend) {
            $arrFriendId[] = $myFriend['user_id'];
        }

        $user = Auth::user();

        if (!isset($arrFriendId)) {
            return view('friends', compact('user', 'friends'));
        }

        $friends = User::all()->find($arrFriendId);
//        dd($friends);
        return view('friends', compact('user', 'friends'));
    }

    public function deletingFromFriends(Request $request)
    {

        $friends = Friend::where('user_id', Auth::id())->where('friend_id', $request['friend_id'])->first();
        $myFriends = Friend::where('user_id', $request['friend_id'])->where('friend_id', Auth::id())->first();

        if (isset($friends->user_id)) {

            $del = Friend::find($friends->id);
            $del->delete();

        } else {

            $del = Friend::find($myFriends->id);
            $del->delete();
        }
        return redirect()->route('friends');
    }

    public function getTheUsersHomePage($friendId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = User::find($friendId);
        $myPosts = Post::all()->where('user_id', $friendId);

        return view('mainPageUser', compact('user', 'myPosts', 'friendId'));
    }

    public function getFormUsersFriends(int $userId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $friends = User::find($userId)->friends;

        foreach ($friends as $key => $elem) {
            $arrFriendId[] = $elem['friend_id'];

        }
        $user = User::find($userId);

        if (!isset($arrFriendId)) {
            return view('friends', compact('user', 'friends', 'userId'));
        }

        $friends = User::all()->find($arrFriendId);

        return view('usersFriends', compact('user', 'friends', 'userId'));

    }

    public function getFormMessages(Request $request, int $userId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if (isset($request->textMessage)) {
            Message::create([
                'content' => $request->textMessage,
                'sender_id' => Auth::id(),
                'receiver_id' => $userId,
            ]);

            return redirect()->route('messages', compact('userId'));
        }

        $sender = Auth::user();

        $receiver = User::find($userId);

        $myMessages = Message::where('sender_id', Auth::id())->where('receiver_id', $userId)->get();

        foreach ($myMessages as $myMessage) {
            $arrMessages[] = $myMessage;
        }

        $iNeedMessages = Message::where('sender_id', $userId)->where('receiver_id', Auth::id())->get();

        foreach ($iNeedMessages as $iNeedMessage) {
            $arrMessages[] = $iNeedMessage;
        }

        if (empty($arrMessages)) {
            return view('messages', compact('sender', 'receiver', 'iNeedMessages', 'userId'));
        }

        $collect = collect($arrMessages);

        $messages = $collect->sortBy('created_at');

        return view('messages', compact('sender', 'receiver', 'messages', 'userId'));
    }
}
