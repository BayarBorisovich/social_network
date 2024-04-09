<?php

namespace App\Http\Controllers;

use App\Console\Commands\ConsumeCommand;
use App\Http\Requests\InformationRequest;
use App\Mail\EmailConfirmation;
use App\Models\AdditionalInformation;
use App\Models\Information;
use App\Services\RabbitService;
use App\Services\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
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
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        event(new Registered($user));

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
        Auth::user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->back()->withSuccess('the changes were successful');
    }

    public function createInformation(InformationRequest $request): RedirectResponse
    {
        $user = Auth::user()->information;

        if (!empty($user)) {
            $user->update([
                'user_id' => Auth::id(),
                'surname' => $request->surname,
                'patronymic' => $request->patronymic,
                'telephone' => $request->telephone,
                'city' => $request->city,
                'about_me' => $request->about_me,
            ]);

            return redirect()->back()->withSuccess('the changes were successful');
        }

        Information::create([
            'user_id' => Auth::id(),
            'surname' => $request->surname,
            'patronymic' => $request->patronymic,
            'telephone' => $request->telephone,
            'city' => $request->city,
            'about_me' => $request->about_me,
        ]);

        return redirect()->back()->withSuccess('the changes were successful');
    }


    public function getAllUsers(): RedirectResponse|View
    {
        return view('user.user');
    }

    public function getJsonUsers(): JsonResponse
    {
        $id = Auth::id();

        $friends = $this->userService->friends($id);

        $friendsId = [];
        foreach ($friends as $friend) {
            $friendsId[] = $friend->id;
        }

        $users = User::all();

        $allUsers = [
            'users' => $users,
            'friendIds' => $friendsId
        ];

        return response()->json(['users' => $allUsers]);
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
        $user = Auth::user();

        return view('user.friends', compact('user'));
    }

    public function getJsonFriends(): JsonResponse
    {
        $id = Auth::id();

        $friends = $this->userService->friends($id);

        return response()->json(['friends' => $friends]);
    }

    public function deletingFromFriends(int $friendId)
    {
        $userId = Auth::id();

        $friend = Friend::where('user_id', $userId)->where('friend_id', $friendId)->first();

        $imAFriend = Friend::where('user_id', $friendId)->where('friend_id', $userId)->first();

        if (!empty($friend)) {
            $friend->delete();
        } else {
            $imAFriend->delete();
        }

        return response([]);
    }

    public function getTheUsersHomePage($friendId): RedirectResponse|View
    {
        $user = User::find($friendId);

        $myPosts = $user->post;

        return view('user.mainPageUser', compact('user', 'myPosts', 'friendId'));
    }

    public function getFormUsersFriends(int $userId): RedirectResponse|View
    {
        $user = User::find($userId);

        $friends = User::find($userId)->friends;

        return view('user.usersFriends', compact('user', 'friends', 'userId'));

    }

    public function getMessages(int $userId): RedirectResponse|View
    {
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
