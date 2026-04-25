<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleReview;
use App\Models\Message;
use App\Mail\ManuscriptApproved;
use App\Mail\ManuscriptRejected;
use App\Mail\ManuscriptUnderReview;
use App\Mail\ArticleUnpublished;
use App\Mail\ArticleDeleted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

        // Only update status if it's submitted
        if ($manuscript->status === 'submitted') {
            $manuscript->update(['status' => 'under_review']);

            // Send email safely
            try {
                Mail::to($manuscript->author->email)
                    ->send(new ManuscriptUnderReview($manuscript));
            } catch (\Exception $e) {
                Log::error('Under review email failed: ' . $e->getMessage());
            }
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

        // Send email safely
        try {
            Mail::to($manuscript->author->email)
                ->send(new ManuscriptApproved($manuscript, $request->comments ?? ''));
        } catch (\Exception $e) {
            Log::error('Approval email failed: ' . $e->getMessage());
        }

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

        // Send in-system message
        Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $manuscript->author_id,
            'article_id'  => $manuscript->id,
            'subject'     => 'Your manuscript has been rejected: ' . $manuscript->title,
            'body'        => $request->comments,
        ]);

        // Send email safely
        try {
            Mail::to($manuscript->author->email)
                ->send(new ManuscriptRejected($manuscript, $request->comments));
        } catch (\Exception $e) {
            Log::error('Rejection email failed: ' . $e->getMessage());
        }

        return redirect()->route('editor.manuscripts.index')
                         ->with('success', 'Manuscript rejected and author notified.');
    }

    // ── Published articles management ──
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

        // Send email safely
        try {
            Mail::to($article->author->email)
                ->send(new ArticleUnpublished($article, $request->reason));
        } catch (\Exception $e) {
            Log::error('Unpublish email failed: ' . $e->getMessage());
        }

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

        // Send email safely
        try {
            Mail::to($article->author->email)
                ->send(new ArticleDeleted(
                    $article->author->name,
                    $article->title,
                    $request->reason
                ));
        } catch (\Exception $e) {
            Log::error('Delete article email failed: ' . $e->getMessage());
        }

        $article->delete();

        return redirect()->route('editor.articles.index')
                         ->with('success', 'Article deleted and author notified.');
    }
}