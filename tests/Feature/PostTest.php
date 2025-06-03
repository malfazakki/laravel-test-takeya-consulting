<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_create_post()
    {
        $response = $this->postJson('/posts', [
            'title' => 'Test Post',
            'content' => 'Test content',
        ]);
        $response->assertStatus(401); // Unauthorized
    }

    public function test_authenticated_user_can_create_draft_post()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson('/posts', [
            'title' => 'Draft Post',
            'content' => 'Draft content',
            'is_draft' => true,
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('posts', [
            'title' => 'Draft Post',
            'is_draft' => true,
        ]);
    }

    public function test_authenticated_user_can_create_scheduled_post()
    {
        $user = User::factory()->create();
        $publishAt = now()->addDay();
        $response = $this->actingAs($user)->postJson('/posts', [
            'title' => 'Scheduled Post',
            'content' => 'Scheduled content',
            'is_draft' => false,
            'published_at' => $publishAt,
        ]);
        $response->assertStatus(201);
        $post = Post::where('title', 'Scheduled Post')->first();
        $this->assertNotNull($post);
        $this->assertEquals(
            $publishAt->format('Y-m-d H:i:s'),
            $post->published_at->format('Y-m-d H:i:s')
        );
    }

    public function test_validation_error_when_creating_post_with_missing_fields()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson('/posts', [
            'title' => '',
            'content' => '',
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['title', 'content']);
    }

    public function test_index_only_shows_active_posts()
    {
        $user = User::factory()->create();
        // Active post
        $active = Post::factory()->create([
            'user_id' => $user->id,
            'is_draft' => false,
            'published_at' => now()->subMinute(),
        ]);
        // Draft
        Post::factory()->create([
            'user_id' => $user->id,
            'is_draft' => true,
        ]);
        // Scheduled
        Post::factory()->create([
            'user_id' => $user->id,
            'is_draft' => false,
            'published_at' => now()->addDay(),
        ]);
        $response = $this->getJson('/posts');
        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => $active->title]);
        $response->assertJsonMissing(['is_draft' => true]);
    }

    public function test_show_returns_404_for_draft_or_scheduled_post()
    {
        $user = User::factory()->create();
        $draft = Post::factory()->create(['user_id' => $user->id, 'is_draft' => true]);
        $scheduled = Post::factory()->create([
            'user_id' => $user->id,
            'is_draft' => false,
            'published_at' => now()->addDay(),
        ]);
        $this->getJson('/posts/'.$draft->id)->assertStatus(404);
        $this->getJson('/posts/'.$scheduled->id)->assertStatus(404);
    }

    public function test_show_returns_post_for_active_post()
    {
        $user = User::factory()->create();
        $active = Post::factory()->create([
            'user_id' => $user->id,
            'is_draft' => false,
            'published_at' => now()->subMinute(),
        ]);
        $response = $this->getJson('/posts/'.$active->id);
        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => $active->title]);
    }

    public function test_only_author_can_update_post()
    {
        $author = User::factory()->create();
        $other = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $author->id]);
        // Author can update
        $response = $this->actingAs($author)->putJson('/posts/'.$post->id, [
            'title' => 'Updated',
            'content' => 'Updated content',
            'is_draft' => false,
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('posts', ['id' => $post->id, 'title' => 'Updated']);
        // Other user cannot update
        $response = $this->actingAs($other)->putJson('/posts/'.$post->id, [
            'title' => 'Hacked',
            'content' => 'Hacked',
            'is_draft' => false,
        ]);
        $response->assertStatus(403);
    }

    public function test_only_author_can_delete_post()
    {
        $author = User::factory()->create();
        $other = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $author->id]);
        // Author can delete
        $response = $this->actingAs($author)->deleteJson('/posts/'.$post->id);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
        // Other user cannot delete
        $post2 = Post::factory()->create(['user_id' => $author->id]);
        $response = $this->actingAs($other)->deleteJson('/posts/'.$post2->id);
        $response->assertStatus(403);
    }
}
