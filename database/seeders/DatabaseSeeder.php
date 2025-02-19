<?php

namespace Database\Seeders;


use App\Models\Post;
use App\Models\User;
use App\Models\Friend;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//         \App\Models\User::factory(10)->create();
//
//         \App\Models\User::factory()->create([
//             'name' => 'Test User',
//             'email' => 'test@example.com',
//         ]);
        $this->call([
            UserSeeder::class,
            FriendSeeder::class,
            PostSeeder::class,
        ]);

    }
}
