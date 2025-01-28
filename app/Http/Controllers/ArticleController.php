<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ArticleController extends Controller
{
    public function index()
    {
        return Article::all();
    }
    
    public function articlesWithRedis(Article $article)
    {
        $redis = Redis::get('articles');

        if ($redis) {
            return json_decode($redis);
        }

        $articles = Article::all();
        Redis::set('articles', $articles);
        return $articles;

    }
}
