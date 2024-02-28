<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrateRequest;
use App\Models\Message;
use App\Models\Post;
use App\Models\User;
use App\Models\Friend;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function getFormRegistrate(): View
    {
        return view('registrate');
    }

    public function postRegistrate(RegistrateRequest $request)
    {
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

    public function postLogin(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            throw Validationexception::withMessages([
                'email' => 'These credentials do not match our records.'
            ]);
        }

        return redirect()->route('main');

    }

    public function getUpdateUser()
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


    public function getAllUsers()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $id = Auth::id();

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

        return view('user', compact('users', 'friendsId', 'id'));
    }

    public function addFriend(Request $request)
    {
        Friend::create([
            'user_id' => Auth::id(),
            'friend_id' => $request['id'],
        ]);

        return redirect()->route('user');

    }

    public function getFriends()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $id = Auth::id();

        $friends = User::find($id)->friends;

        $imAFriends = Friend::find($id)->ImAFriend;

        $arrFriendId = [];
        foreach ($friends as $friend) {
            $arrFriendId[] = $friend->id;

        }

        foreach ($imAFriends as $imAFriend) {
            $arrFriendId[] = $imAFriend->id;
        }

        $user = Auth::user();

        $friends = User::all()->find($arrFriendId);

        return view('friends', compact('user', 'friends'));
    }

    public function deletingFromFriends(Request $request)
    {
        $userId = Auth::id();

        $friends = Friend::where('user_id', $userId)->where('friend_id', $request['friend_id'])->get();

        $imAFriends = Friend::where('user_id', $request['friend_id'])->where('friend_id', $userId)->get();

//        $friends = User::find($userId)->friends()->where('friend_id', $request->friend_id)->get();
//
//        $imAFriends = Friend::find($userId)->ImAFriend()->where('user_id', $request->friend_id)->get();

        if (count($friends) > 0) {

            foreach ($friends as $friend) {
                $friend->delete();
            }

        } else {
            foreach ($imAFriends as $imAFriend) {
                $imAFriend->delete();
            }
        }
        return redirect()->back();
    }

    public function getTheUsersHomePage($friendId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = User::find($friendId);

        $myPosts = $user->post;

        return view('mainPageUser', compact('user', 'myPosts', 'friendId'));
    }

    public function getFormUsersFriends(int $userId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = User::find($userId);

        $friends = User::find($userId)->friends;

        return view('usersFriends', compact('user', 'friends', 'userId'));

    }

    public function getMessages( int $userId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $sender = Auth::user();
        $myMessages = $sender->messages()->with('author')->get();

        $receiver = User::find($userId);
        $iNeedMessages = $receiver->messages()->with('author')->get();

        $arrMessages = [];
        foreach ($myMessages as $myMessage) {
            $arrMessages[] = $myMessage;
        }

        foreach ($iNeedMessages as $iNeedMessage) {
            $arrMessages[] = $iNeedMessage;
        }

        $collect = collect($arrMessages);

        $messages = $collect->sortBy('created_at');


        return view('messages', compact('sender', 'receiver', 'messages', 'userId'));
    }

    public function createMessages(Request $request)
    {
        dd($request);

        Message::create([
            'content' => $request->textMessage,
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
        ]);

        return redirect()->route('messages');
    }
}
