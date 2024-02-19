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

        return view('updateUser', compact('user'));
    }


    public function getFormUsers()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $friends = User::find(Auth::id())->friends;

        foreach ($friends as $friend) {
            $friendsId[$friend['friend_id']] = $friend['friend_id'];
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
        if (isset($_POST['user_id'])) {
            return $this->postMainPageUser($request);
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

    public function friends()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $friends = User::find(Auth::id())->friends;

        foreach ($friends as $key => $elem) {
            $arrFriendId[] = $elem['friend_id'];

        }
        $user = Auth::user();

        if (!isset($arrFriendId)) {
            return view('friends', compact('user', 'friends'));
        }

        $friends = User::all()->find($arrFriendId);

        return view('friends', compact('user', 'friends'));
    }

    public function deletingFromFriends(Request $request)
    {
        if (isset($_POST['user_id'])) {
            return $this->postTheUsersHomePage($request);
        }
        $friends = Friend::where('user_id', Auth::id())->where('friend_id', $request['friend_id'])->get();

        foreach ($friends as $key => $friend) {
            $del = Friend::find($friend['id']);
            $del->delete();
        }

        return $this->friends();

    }
    public function getTheUsersHomePage($user, $myPosts)
    {
//        return view('mainPageUser');
        return view('mainPageUser', compact('user', 'myPosts'));
    }
    public function postTheUsersHomePage(Request $request)
    {
        if(isset($_POST['id'])) {
            return $this->addFriend($request);
        }
        if(isset($_POST['friend_id'])) {
            return $this->deletingFromFriends($request);
        }

        $id = $request->user_id;
        $user = User::find($id);
        $myPosts = Post::all()->where('user_id', $id);

        return $this->getTheUsersHomePage($user, $myPosts);
//        return view('mainPageUser', compact('user', 'myPosts'));
    }
    public function getFormUsersFriends()
    {
        return view('usersFriends');
    }
    public function postUsersFriends(Request $request)
    {
        if (isset($_POST['messages'])) {
            return $this->postMessages($request);
        }
        $id = $request->friend;
        $friends = User::find($id)->friends;

        foreach ($friends as $key => $elem) {
            $arrFriendId[] = $elem['friend_id'];

        }
        $user = User::find($id);

        if (!isset($arrFriendId)) {
            return view('friends', compact('user', 'friends'));
        }

        $friends = User::all()->find($arrFriendId);

        return view('usersFriends', compact('user', 'friends'));

    }
    public function getFormMessages()
    {

//        $sender = Auth::user();
//
//        $receiver = User::find($receiverId);
//
//        $myMessages = Message::where('sender_id', Auth::id())->where('receiver_id', $receiverId)->get();
//
//        $iNeedMessages = Message::where('sender_id', $receiverId)->where('receiver_id', Auth::id())->get();



//        return view('messages', compact('sender', 'receiver', 'myMessages', 'iNeedMessages'));

        return view('messages');
    }

    public function postMessages(Request $request)
    {
        if (isset($_POST['friend'])) {
            return $this->postUsersFriends($request);
        }
        $sender = Auth::user();
        $receiverId = $request->messages;
        $receiver = User::find($receiverId);

        $myMessages = Message::where('sender_id', Auth::id())->where('receiver_id', $receiverId)->get();

        $iNeedMessages = Message::where('sender_id', $receiverId)->where('receiver_id', Auth::id())->get();



        return view('messages', compact('sender', 'receiver', 'myMessages', 'iNeedMessages'));
    }
    public function creatMessages(Request $request)
    {
        if (isset($_POST['textMessage']) && isset($_POST['receiver_id'])) {
            $sender = Auth::user();
            $receiverId = $request['receiver_id'];
            $receiver = User::find($receiverId);
            Message::create([
                'content' => $request['textMessage'],
                'sender_id' => Auth::id(),
                'receiver_id' => $receiverId,
            ]);
            $myMessages = Message::where('sender_id', Auth::id())->where('receiver_id', $receiverId)->get();
            $iNeedMessages = Message::where('sender_id', $receiverId)->where('receiver_id', Auth::id())->get();

            return view('messages', compact('sender', 'receiver', 'myMessages', 'iNeedMessages'));
        }
        dd('no');
    }

}
