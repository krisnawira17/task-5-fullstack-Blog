<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleCrudTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_index()
    {
        $articles = Article::factory(10)->create();

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('main');
        $response->assertViewHas('articles', $articles);
    }

    public function test_create()
    {
        $user = Category::factory()->create();

        $response = $this->actingAs($user)->get('/articles/create');

        $response->assertStatus(200);
        $response->assertViewIs('articles_create');
    }

    public function test_store_valid_data()
    {
        $user = Category::factory()->create();
        $data = [
            'title' => 'My First Article',
            'content' => 'This is my first article.',
        ];

        $response = $this->actingAs($user)->post('/articles', $data);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('articles', [
            'title' => $data['title'],
            'content' => $data['content'],
        ]);
    }

    public function test_store_invalid_data()
    {
        $user = Category::factory()->create();
        $data = [
            'title' => 'My First Article',
        ];

        $response = $this->actingAs($user)->post('/articles', $data);

        $response->assertStatus(422);
        $response->assertViewIs('articles_create');
        $response->assertSessionHasErrors('content');
    }

    public function test_show()
    {
        $article = Article::factory()->create();

        $response = $this->get('/articles/' . $article->id);

        $response->assertStatus(200);
        $response->assertViewIs('article');
        $response->assertViewHas('article', $article);
    }

    public function test_show_personal()
    {
        $user = Category::factory()->create();
        $articles = Article::factory(5)->create();
        $articles->each(function ($article) use ($user) {
            $article->user_id = $user->id;
        });

        $response = $this->actingAs($user)->get('/my-articles');

        $response->assertStatus(200);
        $response->assertViewIs('my_article');
        $response->assertViewHas('articles', $articles);
    }

    public function test_edit()
    {
        $user = Category::factory()->create();
        $article = Article::factory()->create();

        $response = $this->actingAs($user)->get('/articles/' . $article->id . '/edit');

        $response->assertStatus(200);
        $response->assertViewIs('edit_article');
        $response->assertViewHas('article', $article);
    }

    public function test_update_valid_data()
    {
        $user = Category::factory()->create();
        $article = Article::factory()->create();
        $data = [
            'title' => 'My Updated Article',
            'content' => 'This is my updated article.',
        ];

        $response = $this->actingAs($user)->put('/articles/' . $article->id, $data);

        $response->assertRedirect('/articles/' . $article->id);

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => $data['title'],
            'content' => $data['content'],
        ]);
    }

    public function test_update_invalid_data()
    {
        $user = Category::factory()->create();
        $article = Article::factory()->create();
        $data = [
            'title' => '',
            'content' => 'This is my updated article.',
        ];

        $response = $this->actingAs($user)->put('/articles/' . $article->id, $data);

        $response->assertStatus(422);
        $response->assertViewIs('edit_article');
        $response->assertSessionHasErrors('title');
    }

    public function test_destroy()
    {
        $user = Category::factory()->create();
        $article = Article::factory()->create();

        $response = $this->actingAs($user)->delete('/articles/' . $article->id);

        $response->assertRedirect('/');

        $this->assertDatabaseMissing('articles', [
            'id' => $article->id,
        ]);
    }
}