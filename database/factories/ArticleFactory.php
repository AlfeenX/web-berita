<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake('id_ID')->sentence(rand(6, 14));
        $paragraphs = fake('id_ID')->paragraphs(rand(8, 15));
        $content = implode("\n\n", $paragraphs);
        $excerpt = Str::limit(strip_tags($paragraphs[0]), 200);

        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? 1,
            'category_id' => Category::inRandomOrder()->first()?->id ?? 1,
            'title' => rtrim($title, '.'),
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1000, 99999),
            'content' => $content,
            'excerpt' => $excerpt,
            'image' => null,
            'published_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }

    /**
     * Indicate article is unpublished/draft
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'published_at' => null,
        ]);
    }
}
