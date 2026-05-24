<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $tags = [
            'Politik',
            'Teknologi',
            'Olahraga',
            'Ekonomi',
            'Bisnis',
            'Internasional',
            'Nasional',
            'Kesehatan',
            'Pendidikan',
            'Hiburan',
            'Otomotif',
            'Lifestyle',
            'Travel',
            'Kuliner',
            'Sains',
            'Startup',
            'AI',
            'Gaming',
            'Film',
            'Musik',
        ];

        foreach ($tags as $tag) {
            DB::table('tags')->insert([
                'name' => $tag,
                'slug' => Str::slug($tag),
            ]);
        }
    }
}
