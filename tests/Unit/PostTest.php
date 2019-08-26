<?php

namespace Tests\Unit;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function post_belongs_to_a_user()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'user_id' => $user->id,
        ]);

        $this->assertEquals($user->id, $post->user->id);
    }
}
