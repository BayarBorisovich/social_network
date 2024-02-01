<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            $table->text('content'); //содержание

            $table->integer('sender_id'); //отправляет сообщение
            $table->integer('receiver_id'); //принимает сообщение

            $table->index('sender_id', 'message_sender_idx');
            $table->index('receiver_id', 'message_receiver_idx');

            $table->foreign('sender_id', 'message_sender_fk')->on('users')->references('id');
            $table->foreign('receiver_id', 'message_receiver_fk')->on('users')->references('id');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
