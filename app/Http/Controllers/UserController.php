<?php

namespace App\Http\Controllers;

use App\Console\Commands\ConsumeCommand;
use App\Mail\EmailConfirmation;
use App\Services\RabbitService;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Http\Requests\CreateMessageRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrateRequest;
use App\Models\Message;
use App\Models\User;
use App\Models\Friend;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getFormRegistrate(): View
    {
        return view('user.registrate');
    }

    /**
     * @throws \Exception
     */
    public function postRegistrate(RegistrateRequest $request): RedirectResponse
    {
        $data = $request->all();

        $user = User::create([
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

        $mailData = [
            'password' => $data['password'],
            'email' => $data['email'],
            'url' => 'http://localhost/login'
        ];

//        $rabbitmq = new RabbitService('rabbitmq', 5672, 'rmuser', 'rmpassword');
//
//        $queue = 'test';
//
//        $rabbitmq->publich($mailData, $queue);
//
//        $callback = function ($msg) {
//
//            $data = json_decode($msg->body, true);
//
//            Mail::to($data['email'])->send(new EmailConfirmation($data));
//
//            print_r($data);
//        };
//
//        $rabbitmq->consume($callback, $queue);


        if (isset($user)) {
            event(new Registered($user));

            return redirect()->route('verification.notice') ;
        }

        return redirect()->route('login');

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

        $friends = $this->userService->friends($id);

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

    public function getMessages(int $userId): RedirectResponse|View
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
