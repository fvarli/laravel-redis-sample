<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Article::factory(10000)->create()->each(function ($article) {
            $categoryIds = Category::inRandomOrder()->take(rand(1, 5))->pluck('id');
            $article->categories()->attach($categoryIds);
        });
    }
}
