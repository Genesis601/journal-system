<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Journal;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query   = $request->input('q', '');
        $results = collect();

        if (strlen($query) >= 2) {
            $results = Article::where('status', 'published')
                ->where(function ($q) use ($query) {
                    $q->where('title', 'LIKE', "%{$query}%")
                      ->orWhere('abstract', 'LIKE', "%{$query}%")
                      ->orWhere('keywords', 'LIKE', "%{$query}%");
                })
                ->with(['journal', 'author'])
                ->latest('published_at')
                ->paginate(10)
                ->withQueryString();
        }

        return view('public.search', compact('query', 'results'));
    }
}