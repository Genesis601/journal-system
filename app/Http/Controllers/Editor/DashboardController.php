<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'submitted'    => Article::where('status', 'submitted')->count(),
            'under_review' => Article::where('status', 'under_review')->count(),
            'published'    => Article::where('status', 'published')->count(),
            'rejected'     => Article::where('status', 'rejected')->count(),
        ];

        $recentSubmissions = Article::whereIn('status', ['submitted', 'under_review'])
                                    ->with(['journal', 'author'])
                                    ->latest()
                                    ->take(8)
                                    ->get();

        $messages = Auth::user()->receivedMessages()
                        ->with('sender')
                        ->latest()
                        ->take(5)
                        ->get();

        return view('editor.dashboard', compact('stats', 'recentSubmissions', 'messages'));
    }
}