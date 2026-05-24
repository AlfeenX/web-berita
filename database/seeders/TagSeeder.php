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
            'Pemilu', 'Kebijakan', 'Investasi', 'Saham', 
            'Sepakbola', 'Badminton', 'Gadget', 'Internet',
            'Film', 'Musik', 'K-Pop', 'Selebriti',
            'Kuliner', 'Fashion', 'Traveling',
            'Pendidikan', 'Lingkungan', 'Cuaca',
            'Otomotif', 'Motor', 'Mobil',
            'Tips & Trik', 'Review', 'Opini',
            'Politik', 'Ekonomi', 'Startup'
        ];

        foreach ($tags as $tag) {
            DB::table('tags')->insert([
                'name' => $tag,
                'slug' => Str::slug($tag),
            ]);
        }
    }
}
