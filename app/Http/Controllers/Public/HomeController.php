<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\Article;

class HomeController extends Controller
{
    public function index()
    {
        $journals = Journal::where('is_active', true)
                           ->withCount('publishedArticles')
                           ->latest()
                           ->take(8)
                           ->get();

        $latestArticles = Article::where('status', 'published')
                                 ->with(['journal', 'author'])
                                 ->latest('published_at')
                                 ->take(6)
                                 ->get();

        $stats = [
            'journals'  => Journal::where('is_active', true)->count(),
            'articles'  => Article::where('status', 'published')->count(),
            'authors'   => \App\Models\User::role('author')->count(),
        ];

        return view('public.home', compact('journals', 'latestArticles', 'stats'));
    }
}