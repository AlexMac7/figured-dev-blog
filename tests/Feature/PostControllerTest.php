<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Tests\RefreshMongoDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrate:fresh', [ // TODO: Override RefreshDatabase trait and combine
            '--path' => 'database/migrations/mongodb',
            '--database' => 'mongodb',
        ]);

        $this->user = factory(User::class)->create();

        factory(Post::class, 15)->create([
            'user_id' => $this->user->id
        ]);

        $this->post = Post::first();
    }

    /** @test */
    public function anyone_can_get_all_posts()
    {
        $response = $this->json('GET', '/posts');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'posts' => [
                    'current_page',
                    'first_page_url',
                    'from',
                    'last_page',
                    'last_page_url',
                    'next_page_url',
                    'path',
                    'per_page',
                    'prev_page_url',
                    'to',
                    'total',
                    'data' => [
                        [
                            '_id',
                            'user_id',
                            'description',
                            'updated_at',
                            'created_at'
                        ]
                    ]
                ]
            ])
            ->assertJsonFragment([
                '_id' => $this->post->_id,
                'user_id' => $this->post->user_id,
                'description' => $this->post->description,
            ]);
    }

    /** @test */
    public function authenticated_user_can_get_specific_post()
    {
        $response = $this->actingAs($this->user)->json('GET', sprintf('/posts/%s', $this->post->id));

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                '_id' => $this->post->_id,
                'user_id' => $this->post->user_id,
                'description' => $this->post->description,
            ]);
    }

    /** @test */
    public function unauthenticated_user_can_not_get_specific_post()
    {
        $response = $this->json('GET', sprintf('/posts/%s', $this->post->id));

        $response->assertStatus(401);
    }

    /** @test */
    public function authenticated_user_can_not_get_another_users_specific_post()
    {
        $post = factory(Post::class)->create();

        $response = $this->actingAs($this->user)->json('GET', sprintf('/posts/%s', $post->id));

        $response->assertStatus(403);
    }

    /** @test */
    public function authenticated_user_can_create_post()
    {
        $data = [
            'title' => 'New Post',
            'description' => 'Create a new post.'
        ];

        $response = $this->actingAs($this->user)->json('POST', '/posts', $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('posts', [
            'user_id' => $this->user->id,
            'title' => $data['title'],
            'description' => $data['description'],
        ], 'mongodb');
    }

    /** @test */
    public function unauthenticated_user_can_not_create_post()
    {
        $data = [
            'title' => 'New Title',
            'description' => 'Create a new post.'
        ];

        $response = $this->json('POST', '/posts', $data);

        $response->assertStatus(401);
    }

    /** @test */
    public function authenticated_user_can_update_post()
    {
        $data = [
            'title' => 'Update Title',
            'description' => 'Update an existing post.'
        ];

        $response = $this->actingAs($this->user)->json('PATCH', sprintf('/posts/%s', $this->post->id), $data);

        $response->assertStatus(204);

        $this->assertDatabaseHas('posts', [
            'user_id' => $this->user->id,
            'title' => $data['title'],
            'description' => $data['description'],
        ], 'mongodb');
    }

    /** @test */
    public function unauthenticated_user_can_not_update_post()
    {
        $data = [
            'title' => 'Update Title',
            'description' => 'Update an existing post.'
        ];

        $response = $this->json('PATCH', sprintf('/posts/%s', $this->post->id), $data);

        $response->assertStatus(401);
    }

    /** @test */
    public function authenticated_can_not_update_another_users_post()
    {
        $post = factory(Post::class)->create();

        $data = [
            'title' => 'Update Title',
            'description' => 'Update an existing post.'
        ];

        $response = $this->actingAs($this->user)->json('PATCH', sprintf('/posts/%s', $post->id), $data);

        $response->assertStatus(403);
    }

    /** @test */
    public function authenticated_user_can_delete_post()
    {
        $response = $this->actingAs($this->user)->json('DELETE', sprintf('/posts/%s', $this->post->id));

        $response->assertStatus(200);

        $this->assertDatabaseMissing('posts', [
            'user_id' => $this->user->id,
            'title' => $this->post->title,
            'description' => $this->post->description
        ], 'mongodb');
    }

    /** @test */
    public function unauthenticated_user_can_not_delete_post()
    {
        $response = $this->json('DELETE', sprintf('/posts/%s', $this->post->id));

        $response->assertStatus(401);
    }

    /** @test */
    public function authenticated_user_can_not_delete_another_users_post()
    {
        $post = factory(Post::class)->create();

        $response = $this->actingAs($this->user)->json('DELETE', sprintf('/posts/%s', $post->id));

        $response->assertStatus(403);
    }
}
