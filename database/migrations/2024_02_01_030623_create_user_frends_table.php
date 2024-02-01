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
        Schema::create('user_frends', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('friend_id');


            $table->index('user_id', 'uf_user_idx');
            $table->index('friend_id', 'uf_friend_idx');

            $table->foreign('user_id', 'uf_user_fk')->on('users')->references('id');
            $table->foreign('friend_id', 'uf_friend_fk')->on('users')->references('id');

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
        Schema::dropIfExists('user_frends');
    }
};
