<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMessageRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrateRequest;
use App\Models\Message;
use App\Models\User;
use App\Models\Friend;
use http\Env\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function getFormRegistrate(): View
    {
        return view('user.registrate');
    }

    public function postRegistrate(RegistrateRequest $request): RedirectResponse
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
        return view('user.login');
    }

    public function postLogin(LoginRequest $request): RedirectResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            throw Validationexception::withMessages([
                'email' => 'These credentials do not match our records.'
            ]);
        }

        return redirect()->route('main');

    }

    public function getUpdateUser(): View
    {
        $user = Auth::user();
        return view('user.updateUser', compact('user'));
    }

    public function updateUser(Request $request): RedirectResponse
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

        return redirect()->back();
    }


    public function getAllUsers(): RedirectResponse|View
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
//        $id = Auth::id();
//
//        $friends = User::find($id)->friends;
//
//        $myFriends = Friend::where('friend_id', $id)->get();
//
//        $friendsId = [];
//        foreach ($friends as $friend) {
//            $friendsId[$friend->id] = $friend->id;
//
//        }
//
//        foreach ($myFriends as $myFriend) {
//            $friendsId[$myFriend->user_id] = $myFriend->user_id;
//        }
//
//        $users = User::all();


        return view('user.user');
    }

    public function getJsonUsers()
    {
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

        $allUsers = [
            'users' => $users,
            'friendIds' => $friendsId
        ];

        $users = json_encode($allUsers);

        return $users;
    }

    public function addFriend(int $userId)
    {
        Friend::create([
            'user_id' => Auth::id(),
            'friend_id' => $userId,
        ]);

        return response([]);

    }

    public function getFriends(): RedirectResponse|View
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $user = Auth::user();

        return view('user.friends', compact('user'));
    }

    public function getJsonFriends()
    {
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
        $friends = User::all()->find($arrFriendId);

        $friends = json_encode($friends);

        return $friends;
    }

    public function deletingFromFriends(int $friendId)
    {
        $userId = Auth::id();

        $friends = Friend::where('user_id', $userId)->where('friend_id', $friendId)->first();

        $imAFriends = Friend::where('user_id', $friendId)->where('friend_id', $userId)->first();

        if (!empty($friends)) {
            $friends->delete();
        } else {
            $imAFriends->delete();
        }

        return response([]);
    }

    public function getTheUsersHomePage($friendId): RedirectResponse|View
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = User::find($friendId);

        $myPosts = $user->post;

        return view('user.mainPageUser', compact('user', 'myPosts', 'friendId'));
    }

    public function getFormUsersFriends(int $userId): RedirectResponse|View
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = User::find($userId);

        $friends = User::find($userId)->friends;

        return view('user.usersFriends', compact('user', 'friends', 'userId'));

    }

    public function getMessages( int $userId): RedirectResponse|View
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $sender = Auth::user();
        $myMessages = $sender->messages()->with('author')->where('receiver_id', $userId)->get();

        $receiver = User::find($userId);
        $iNeedMessages = $receiver->messages()->with('author')->where('receiver_id', Auth::id())->get();

        $messages = [];
        foreach ($myMessages as $myMessage) {
            $messages[] = $myMessage;
        }

        foreach ($iNeedMessages as $iNeedMessage) {
            $messages[] = $iNeedMessage;
        }

        $messages = json_encode($messages);

        return view('user.messages', compact('sender', 'receiver', 'messages'));
    }

    public function getJsonMessages()
    {

    }

    public function createMessages(CreateMessageRequest $request, int $id)
    {
        Message::create([
            'content' => $request->textMessage,
            'sender_id' => Auth::id(),
            'receiver_id' => $id,
        ]);

        return response([]);
    }
}
