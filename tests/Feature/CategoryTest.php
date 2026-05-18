<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_guests_cannot_access_categories_page(): void
    {
        $response = $this->get(route('categories.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_access_categories_page(): void
    {
        $this->actingAs($this->user);
        $category = Category::create(['name' => 'Laravel', 'slug' => 'laravel']);

        $response = $this->get(route('categories.index'));
        $response->assertOk();
        $response->assertSee('Laravel');
        $response->assertSee('laravel');
    }

    public function test_user_can_create_category(): void
    {
        $this->actingAs($this->user);

        $response = $this->post(route('categories.store'), [
            'name' => 'Web Development',
        ]);

        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('success', 'Kategori berhasil ditambahkan!');

        $this->assertDatabaseHas('categories', [
            'name' => 'Web Development',
            'slug' => 'web-development',
        ]);
    }

    public function test_user_cannot_create_duplicate_category(): void
    {
        $this->actingAs($this->user);
        Category::create(['name' => 'Unique Cat', 'slug' => 'unique-cat']);

        $response = $this->post(route('categories.store'), [
            'name' => 'Unique Cat',
        ]);

        $response->assertSessionHasErrors(['name']);
        $this->assertEquals(1, Category::where('name', 'Unique Cat')->count());
    }

    public function test_user_can_update_category(): void
    {
        $this->actingAs($this->user);
        $category = Category::create(['name' => 'Old Name', 'slug' => 'old-name']);

        $response = $this->put(route('categories.update', $category), [
            'name' => 'New Name',
        ]);

        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('success', 'Kategori berhasil diperbarui!');

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'New Name',
            'slug' => 'new-name',
        ]);
    }

    public function test_user_cannot_update_to_duplicate_name(): void
    {
        $this->actingAs($this->user);
        $category1 = Category::create(['name' => 'Category One', 'slug' => 'category-one']);
        $category2 = Category::create(['name' => 'Category Two', 'slug' => 'category-two']);

        $response = $this->put(route('categories.update', $category2), [
            'name' => 'Category One',
        ]);

        $response->assertSessionHasErrors(['name']);
        $this->assertEquals('Category Two', $category2->fresh()->name);
    }

    public function test_user_can_delete_empty_category(): void
    {
        $this->actingAs($this->user);
        $category = Category::create(['name' => 'Trash Cat', 'slug' => 'trash-cat']);

        $response = $this->delete(route('categories.destroy', $category));

        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('success', 'Kategori berhasil dihapus!');

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }

    public function test_user_cannot_delete_category_with_articles(): void
    {
        $this->actingAs($this->user);
        $category = Category::create(['name' => 'Tech', 'slug' => 'tech']);
        
        // Create an article belonging to the category
        Article::create([
            'title' => 'Article One',
            'slug' => 'article-one',
            'category_id' => $category->id,
            'user_id' => $this->user->id,
            'content' => 'Test content',
            'excerpt' => 'Test excerpt',
        ]);

        $response = $this->delete(route('categories.destroy', $category));

        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('error', 'Kategori tidak bisa dihapus karena memiliki artikel!');

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
        ]);
    }
}
