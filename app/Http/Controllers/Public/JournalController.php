<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Journal;

class JournalController extends Controller
{
    public function index()
    {
        $journals = Journal::where('is_active', true)
                           ->withCount('publishedArticles')
                           ->latest()
                           ->paginate(12);

        return view('public.journals.index', compact('journals'));
    }

    public function show($slug)
    {
        $journal = Journal::where('slug', $slug)
                          ->where('is_active', true)
                          ->firstOrFail();

        $articles = $journal->publishedArticles()
                            ->with('author')
                            ->latest('published_at')
                            ->paginate(10);

        return view('public.journals.show', compact('journal', 'articles'));
    }
}