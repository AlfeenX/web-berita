<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $otherUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
        $this->otherUser = User::factory()->create();
    }

    public function test_guests_cannot_access_users_page(): void
    {
        $response = $this->get(route('users.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_see_users_list_with_articles_count(): void
    {
        $this->actingAs($this->admin);

        // Create an article for otherUser
        $category = Category::create(['name' => 'Technology', 'slug' => 'technology']);
        Article::create([
            'title' => 'User Guide to Laravel',
            'slug' => 'user-guide-to-laravel',
            'category_id' => $category->id,
            'user_id' => $this->otherUser->id,
            'content' => 'Some content here.',
        ]);

        $response = $this->get(route('users.index'));
        $response->assertOk();
        $response->assertSee($this->admin->name);
        $response->assertSee($this->otherUser->name);
        
        // Assert the articles count is visible in the view
        $response->assertSee('1'); // otherUser articles_count
    }

    public function test_user_can_create_new_user_via_form(): void
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('users.store'), [
            'name' => 'New Writer Account',
            'email' => 'writer@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'Akun Pengguna berhasil ditambahkan!');

        $this->assertDatabaseHas('users', [
            'name' => 'New Writer Account',
            'email' => 'writer@example.com',
        ]);
    }

    public function test_user_creation_validates_input(): void
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('users.store'), [
            'name' => '',
            'email' => 'not-an-email',
            'password' => 'short',
            'password_confirmation' => 'mismatch',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    public function test_user_can_update_user_details_inline(): void
    {
        $this->actingAs($this->admin);

        $response = $this->put(route('users.update', $this->otherUser), [
            'name' => 'Updated Writer Name',
            'email' => 'updatedwriter@example.com',
        ]);

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'Data Pengguna berhasil diperbarui!');

        $this->otherUser->refresh();
        $this->assertEquals('Updated Writer Name', $this->otherUser->name);
        $this->assertEquals('updatedwriter@example.com', $this->otherUser->email);
    }

    public function test_user_can_delete_another_user(): void
    {
        $this->actingAs($this->admin);

        $response = $this->delete(route('users.destroy', $this->otherUser));

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'Akun Pengguna berhasil dihapus!');

        $this->assertDatabaseMissing('users', ['id' => $this->otherUser->id]);
    }

    public function test_user_cannot_delete_themselves(): void
    {
        $this->actingAs($this->admin);

        $response = $this->delete(route('users.destroy', $this->admin));

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif login!');

        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    }
}
