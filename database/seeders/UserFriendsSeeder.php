<?php

namespace Database\Seeders;

use App\Models\UserFriends;

use Illuminate\Database\Seeder;

class UserFriendsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserFriends::factory()->count(20)->create();
    }
}
