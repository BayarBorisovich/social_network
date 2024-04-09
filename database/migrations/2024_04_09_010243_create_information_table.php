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
        Schema::create('information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('surname')->nullable();
            $table->string('patronymic')->nullable();
            $table->string('telephone')->nullable();
            $table->string('city')->nullable();
            $table->text('about_me')->nullable();
            $table->timestamps();

            $table->index('user_id', 'information_user_idx');

            $table->foreign('user_id', 'information_user_idx')->on('users')->references('id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('information');
    }
};
