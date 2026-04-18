<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleReview;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        $manuscripts = Article::whereIn('status', ['submitted', 'under_review'])
                              ->with(['journal', 'author'])
                              ->latest()
                              ->paginate(15);

        return view('editor.manuscripts.index', compact('manuscripts'));
    }

    public function show($id)
    {
        $manuscript = Article::with(['journal', 'author', 'reviews.editor'])
                             ->findOrFail($id);

        $manuscript->update(['status' => 'under_review']);

        return view('editor.manuscripts.show', compact('manuscript'));
    }

    public function approve(Request $request, $id)
    {
        $manuscript = Article::findOrFail($id);

        $request->validate([
            'comments' => 'nullable|string',
        ]);

        ArticleReview::create([
            'article_id'  => $manuscript->id,
            'editor_id'   => Auth::id(),
            'decision'    => 'approved',
            'comments'    => $request->comments,
            'reviewed_at' => now(),
        ]);

        $manuscript->update([
            'status'       => 'published',
            'published_at' => now(),
            'slug'         => \Illuminate\Support\Str::slug($manuscript->title) . '-' . $manuscript->id,
        ]);

        return redirect()->route('editor.manuscripts.index')
                         ->with('success', 'Manuscript approved and published!');
    }

    public function reject(Request $request, $id)
    {
        $manuscript = Article::findOrFail($id);

        $request->validate([
            'comments' => 'required|string|min:20',
        ]);

        ArticleReview::create([
            'article_id'  => $manuscript->id,
            'editor_id'   => Auth::id(),
            'decision'    => 'rejected',
            'comments'    => $request->comments,
            'reviewed_at' => now(),
        ]);

        $manuscript->update(['status' => 'rejected']);

        // Send message to author
        Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $manuscript->author_id,
            'article_id'  => $manuscript->id,
            'subject'     => 'Your manuscript has been rejected: ' . $manuscript->title,
            'body'        => $request->comments,
        ]);

        return redirect()->route('editor.manuscripts.index')
                         ->with('success', 'Manuscript rejected and author notified.');
    }
}