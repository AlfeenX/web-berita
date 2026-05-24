<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Nasional',
            'Internasional',
            'Ekonomi & Bisnis',
            'Politik',
            'Teknologi',
            'Olahraga',
            'Hiburan',
            'Gaya Hidup',
            'Kesehatan',
            'Sains & Edukasi',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
            ]);
        }
    }
}