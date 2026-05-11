<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ArticleDeleted;
use App\Mail\ArticleUnpublished;
use App\Models\Article;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with(['journal', 'author']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('journal_id')) {
            $query->where('journal_id', $request->journal_id);
        }

        if ($request->filled('search')) {
            $query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        $articles = $query->latest()->paginate(20)->withQueryString();
        $journals = \App\Models\Journal::where('is_active', true)->get();

        $stats = [
            'total'        => Article::count(),
            'published'    => Article::where('status', 'published')->count(),
            'under_review' => Article::where('status', 'under_review')->count(),
            'rejected'     => Article::where('status', 'rejected')->count(),
        ];

        return view('admin.articles.index', compact('articles', 'journals', 'stats'));
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
            'body'        => "Your article has been temporarily unpublished.\n\nReason: " . $request->reason,
        ]);

        try {
            Mail::to($article->author->email)
                ->send(new ArticleUnpublished($article, $request->reason));
        } catch (\Exception $e) {
            Log::error('Unpublish email failed: ' . $e->getMessage());
        }

        return redirect()->route('admin.articles.index')
                         ->with('success', 'Article unpublished and author notified.');
    }

    public function deleteArticle(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $request->validate([
            'reason' => 'required|string|min:20',
        ]);

        $authorEmail = $article->author->email;
        $authorName  = $article->author->name;
        $title       = $article->title;

        Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $article->author_id,
            'article_id'  => null,
            'subject'     => 'Your article has been removed: ' . $title,
            'body'        => "Your article \"{$title}\" has been permanently removed.\n\nReason: " . $request->reason,
        ]);

        $article->delete();

        try {
            Mail::to($authorEmail)
                ->send(new ArticleDeleted($authorName, $title, $request->reason));
        } catch (\Exception $e) {
            Log::error('Delete email failed: ' . $e->getMessage());
        }

        return redirect()->route('admin.articles.index')
                         ->with('success', 'Article deleted and author notified.');
    }

    public function sendMessage(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $request->validate([
            'subject' => 'required|string|max:255',
            'body'    => 'required|string|min:10',
        ]);

        Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $article->author_id,
            'article_id'  => $article->id,
            'subject'     => $request->subject,
            'body'        => $request->body,
        ]);

        return back()->with('success', 'Message sent to author successfully.');
    }
}