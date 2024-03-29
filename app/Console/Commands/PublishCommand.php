<?php
//
//namespace App\Console\Commands;
//
//use App\Mail\EmailConfirmation;
//use Illuminate\Console\Command;
//use Illuminate\Support\Facades\Mail;
//use PhpAmqpLib\Connection\AMQPStreamConnection;
//use PhpAmqpLib\Message\AMQPMessage;
//use Symfony\Component\Console\Command\Command as CommandAlias;
//
//class PublishCommand extends Command
//{
//    /**
//     * The name and signature of the console command.
//     *
//     * @var string
//     */
//    protected $signature = 'rabbitmq:publish';
//
//    /**
//     * The console command description.
//     *
//     * @var string
//     */
//    protected $description = 'Command description';
//
//    /**
//     * Execute the console command.
//     *
//     * @return int
//     * @throws \Exception
//     */
//    public function handle()
//    {
//        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'rmuser', 'rmpassword');
//        $channel = $connection->channel();
//
//        $channel->queue_declare('hello', false, true, false, false);
//
//        $mailData = [
//            'title' => 'aaaaaaa',
//            'url' => 'http://localhost/login'
//        ];
//
//        $data = json_encode($mailData);
//
//        $msg = new AMQPMessage($data);
//        $channel->basic_publish($msg, '', 'hello');
//
//        echo " [x] the password has been sent'\n";
//
//        $channel->close();
//        $connection->close();
//
////        return CommandAlias::SUCCESS;
//    }
//
//}
