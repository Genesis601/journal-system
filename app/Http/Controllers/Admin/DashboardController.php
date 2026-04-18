<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Journal;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'    => User::count(),
            'total_journals' => Journal::count(),
            'total_articles' => Article::where('status', 'published')->count(),
            'pending'        => Article::whereIn('status', ['submitted', 'under_review'])->count(),
            'authors'        => User::role('author')->count(),
            'editors'        => User::role('editor')->count(),
        ];

        $recentUsers    = User::latest()->take(5)->get();
        $recentArticles = Article::with(['journal', 'author'])
                                 ->latest()
                                 ->take(5)
                                 ->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentArticles'));
    }
}