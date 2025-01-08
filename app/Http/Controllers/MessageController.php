<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMessageRequest;
use App\Models\Message;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class MessageController
{
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
