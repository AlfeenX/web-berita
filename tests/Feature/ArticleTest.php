<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->category = Category::create(['name' => 'Tech', 'slug' => 'tech']);
    }

    public function test_guests_cannot_access_articles_page(): void
    {
        $response = $this->get(route('articles.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_see_articles_list(): void
    {
        $this->actingAs($this->user);
        
        $article = Article::create([
            'title' => 'Sample Technology Article',
            'slug' => 'sample-technology-article',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'content' => 'This is the sample technology content.',
        ]);

        $response = $this->get(route('articles.index'));
        $response->assertOk();
        $response->assertSee('Sample Technology Article');
        $response->assertSee('tech');
    }

    public function test_user_can_search_articles(): void
    {
        $this->actingAs($this->user);
        
        Article::create([
            'title' => 'Laravel News',
            'slug' => 'laravel-news',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'content' => 'Laravel news content.',
        ]);

        Article::create([
            'title' => 'Svelte Guide',
            'slug' => 'svelte-guide',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'content' => 'Svelte guide content.',
        ]);

        // Search for Laravel
        $response = $this->get(route('articles.index', ['search' => 'Laravel']));
        $response->assertSee('Laravel News');
        $response->assertDontSee('Svelte Guide');
    }

    public function test_user_can_filter_articles_by_category(): void
    {
        $this->actingAs($this->user);
        $otherCategory = Category::create(['name' => 'Health', 'slug' => 'health']);
        
        Article::create([
            'title' => 'Tech News',
            'slug' => 'tech-news',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'content' => 'Tech content.',
        ]);

        Article::create([
            'title' => 'Health News',
            'slug' => 'health-news',
            'category_id' => $otherCategory->id,
            'user_id' => $this->user->id,
            'content' => 'Health content.',
        ]);

        // Filter by Tech Category
        $response = $this->get(route('articles.index', ['category' => $this->category->id]));
        $response->assertSee('Tech News');
        $response->assertDontSee('Health News');
    }

    public function test_user_can_create_article_with_thumbnail_and_rich_text(): void
    {
        Storage::fake('public');
        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('thumbnail.jpg');

        $response = $this->post(route('articles.store'), [
            'title' => 'Dynamic Content Article',
            'category_id' => $this->category->id,
            'content' => '<h1>Hello World</h1><p>This is a rich text paragraph.</p>',
            'image' => $file,
        ]);

        $response->assertRedirect(route('articles.index'));
        $response->assertSessionHas('success', 'Berita berhasil ditambahkan!');

        // Assert DB
        $article = Article::latest()->first();
        $this->assertEquals('Dynamic Content Article', $article->title);
        $this->assertEquals('<h1>Hello World</h1><p>This is a rich text paragraph.</p>', $article->content);
        $this->assertNotNull($article->image);

        // Assert Storage
        $this->assertTrue(Storage::disk('public')->exists($article->image));
    }

    public function test_user_can_update_article_and_replace_thumbnail(): void
    {
        Storage::fake('public');
        $this->actingAs($this->user);

        $oldFile = UploadedFile::fake()->image('old.jpg');
        $oldPath = $oldFile->store('articles', 'public');

        $article = Article::create([
            'title' => 'Initial Title',
            'slug' => 'initial-title',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'content' => 'Initial content',
            'image' => $oldPath,
        ]);

        $newFile = UploadedFile::fake()->image('new.jpg');

        $response = $this->put(route('articles.update', $article), [
            'title' => 'Updated Title',
            'category_id' => $this->category->id,
            'content' => 'Updated content',
            'image' => $newFile,
        ]);

        $response->assertRedirect(route('articles.index'));
        $response->assertSessionHas('success', 'Berita berhasil diperbarui!');

        $article->refresh();
        $this->assertEquals('Updated Title', $article->title);
        $this->assertEquals('Updated content', $article->content);
        
        // Old image should be deleted
        $this->assertFalse(Storage::disk('public')->exists($oldPath));
        // New image should exist
        $this->assertTrue(Storage::disk('public')->exists($article->image));
    }

    public function test_user_can_delete_article_with_its_thumbnail(): void
    {
        Storage::fake('public');
        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('article.jpg');
        $path = $file->store('articles', 'public');

        $article = Article::create([
            'title' => 'Title to Delete',
            'slug' => 'title-to-delete',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'content' => 'Content to delete',
            'image' => $path,
        ]);

        $response = $this->delete(route('articles.destroy', $article));

        $response->assertRedirect(route('articles.index'));
        $response->assertSessionHas('success', 'Berita berhasil dihapus!');

        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
        
        // Thumbnail should be deleted from storage
        $this->assertFalse(Storage::disk('public')->exists($path));
    }
}
