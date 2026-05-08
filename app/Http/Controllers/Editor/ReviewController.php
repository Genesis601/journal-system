<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleReview;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

        // Only update status — NO email here
        if ($manuscript->status === 'submitted') {
            $manuscript->update(['status' => 'under_review']);
        }

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

        // In-system message to author
        Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $manuscript->author_id,
            'article_id'  => $manuscript->id,
            'subject'     => 'Your manuscript has been approved: ' . $manuscript->title,
            'body'        => $request->comments
                ? 'Congratulations! Your manuscript has been approved and published. Editor note: ' . $request->comments
                : 'Congratulations! Your manuscript has been approved and published on JournalSpace.',
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

        // In-system message to author
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

    public function articles(Request $request)
    {
        $query = Article::where('status', 'published')
                        ->with(['journal', 'author']);

        if ($request->filled('journal_id')) {
            $query->where('journal_id', $request->journal_id);
        }

        if ($request->filled('search')) {
            $query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        $articles = $query->latest('published_at')->paginate(15)->withQueryString();
        $journals = \App\Models\Journal::where('is_active', true)->get();

        return view('editor.articles.index', compact('articles', 'journals'));
    }

    public function unpublish(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $request->validate([
            'reason' => 'required|string|min:20',
        ]);

        $article->update(['status' => 'under_review']);

        Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $article->author_id,
            'article_id'  => $article->id,
            'subject'     => 'Your article has been unpublished: ' . $article->title,
            'body'        => "Your article has been temporarily unpublished for revision.\n\nReason: " . $request->reason,
        ]);

        return redirect()->route('editor.articles.index')
                         ->with('success', 'Article unpublished and author notified.');
    }

    public function deleteArticle(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $request->validate([
            'reason' => 'required|string|min:20',
        ]);

        Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $article->author_id,
            'article_id'  => null,
            'subject'     => 'Your article has been removed: ' . $article->title,
            'body'        => "Your article titled \"{$article->title}\" has been permanently removed.\n\nReason: " . $request->reason,
        ]);

        $article->delete();

        return redirect()->route('editor.articles.index')
                         ->with('success', 'Article deleted and author notified.');
    }
}