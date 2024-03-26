<?php

namespace App\Services;

use App\Mail\EmailConfirmation;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitService
{

    public function connection(): AMQPStreamConnection
    {
      return new AMQPStreamConnection(
            Config::get('rabbitmq.host'),
            Config::get('rabbitmq.port'),
            Config::get('rabbitmq.user'),
            Config::get('rabbitmq.password'),
        );
    }

    public function publich($data, $queue): void
    {
        $connection = $this->connection();
        $channel = $connection->channel();

        $channel->queue_declare($queue, false, true, false, false);

        $data1 = json_encode($data);

        $msg = new AMQPMessage($data1);
        $channel->basic_publish($msg, '', $queue);

        echo " [x] the password has been sent'\n";

        $channel->close();
        $connection->close();
    }

    public function consume($callback, $queue): void
    {
        $connection = $this->connection();
        $channel = $connection->channel();

        $channel->queue_declare("$queue", false, true, false, false);

        echo " [*] Waiting for messages. To exit press CTRL+C\n";

        $channel->basic_consume("$queue", '', false, true, false, false, $callback);

        try {
            $channel->consume();
        } catch (\Throwable $exception) {
            echo $exception->getMessage();
        }

    }

}
