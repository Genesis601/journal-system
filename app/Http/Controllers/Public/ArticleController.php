<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('status', 'published')
                           ->with(['journal', 'author'])
                           ->latest('published_at')
                           ->paginate(12);

        return view('public.articles.index', compact('articles'));
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)
                          ->where('status', 'published')
                          ->with(['journal', 'author'])
                          ->firstOrFail();

        // Increment view count
        $article->increment('views');

        $related = Article::where('journal_id', $article->journal_id)
                          ->where('status', 'published')
                          ->where('id', '!=', $article->id)
                          ->latest('published_at')
                          ->take(4)
                          ->get();

        return view('public.articles.show', compact('article', 'related'));
    }
}