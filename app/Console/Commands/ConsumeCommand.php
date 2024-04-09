<?php

namespace App\Console\Commands;


use App\Mail\SendingNotificationsToFriends;
use App\Models\Friend;
use App\Models\User;
use App\Services\RabbitService;
use App\Services\UserService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConsumeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:consume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends a notification to friends about a new post';

    /**
     * Execute the console command.
     *
     * @return int
     * @throws \Exception
     */
    public function handle(UserService $userService, RabbitService $rabbitService): void
    {
        $queue = 'post';

        $callback = function ($msg) use ($userService) {

            $data = json_decode($msg->body, true);

            $myFriends = $userService->friends($data['id']);

            $user = User::find($data['id']);

            foreach ($myFriends as $friend) {
                Mail::to($friend['email'])->send(new SendingNotificationsToFriends($data, $user->name));

            }

            print_r($data['content']);
        };

        $rabbitService->consume($callback, $queue);
    }
}
