<?php

use App\Post;
use App\User;
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
        $admin = factory(User::class)->create([
            'email' => 'admin@figured.com',
            'password' => bcrypt('secret')
        ]);

        factory(Post::class, 15)->create([
            'user_id' => $admin->id
        ]);
    }
}
