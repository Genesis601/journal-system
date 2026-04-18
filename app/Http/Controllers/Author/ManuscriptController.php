<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ManuscriptController extends Controller
{
    public function index()
    {
        $manuscripts = Auth::user()->articles()
                           ->with('journal')
                           ->latest()
                           ->paginate(10);

        return view('author.manuscripts.index', compact('manuscripts'));
    }

    public function create()
    {
        $journals = Journal::where('is_active', true)->get();
        return view('author.manuscripts.create', compact('journals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'journal_id' => 'required|exists:journals,id',
            'abstract'   => 'required|string|min:100',
            'keywords'   => 'required|string',
            'file'       => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $filePath = $request->file('file')->store('manuscripts', 'public');

        Article::create([
            'title'      => $request->title,
            'slug'       => Str::slug($request->title) . '-' . Str::random(6),
            'journal_id' => $request->journal_id,
            'author_id'  => Auth::id(),
            'abstract'   => $request->abstract,
            'keywords'   => $request->keywords,
            'file_path'  => $filePath,
            'status'     => 'submitted',
        ]);

        return redirect()->route('author.manuscripts.index')
                         ->with('success', 'Manuscript submitted successfully!');
    }

    public function edit($id)
    {
        $manuscript = Article::where('id', $id)
                             ->where('author_id', Auth::id())
                             ->whereIn('status', ['draft', 'rejected'])
                             ->firstOrFail();

        $journals = Journal::where('is_active', true)->get();

        return view('author.manuscripts.edit', compact('manuscript', 'journals'));
    }

    public function update(Request $request, $id)
    {
        $manuscript = Article::where('id', $id)
                             ->where('author_id', Auth::id())
                             ->whereIn('status', ['draft', 'rejected'])
                             ->firstOrFail();

        $request->validate([
            'title'      => 'required|string|max:255',
            'journal_id' => 'required|exists:journals,id',
            'abstract'   => 'required|string|min:100',
            'keywords'   => 'required|string',
            'file'       => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $filePath = $manuscript->file_path;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('manuscripts', 'public');
        }

        $manuscript->update([
            'title'      => $request->title,
            'journal_id' => $request->journal_id,
            'abstract'   => $request->abstract,
            'keywords'   => $request->keywords,
            'file_path'  => $filePath,
            'status'     => 'submitted',
        ]);

        return redirect()->route('author.manuscripts.index')
                         ->with('success', 'Manuscript updated and resubmitted!');
    }

    public function destroy($id)
    {
        $manuscript = Article::where('id', $id)
                             ->where('author_id', Auth::id())
                             ->whereIn('status', ['draft', 'rejected'])
                             ->firstOrFail();

        $manuscript->delete();

        return redirect()->route('author.manuscripts.index')
                         ->with('success', 'Manuscript deleted.');
    }
}