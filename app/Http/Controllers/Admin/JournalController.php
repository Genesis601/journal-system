<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JournalController extends Controller
{
    public function index()
    {
        $journals = Journal::withCount('articles')->latest()->paginate(15);
        return view('admin.journals.index', compact('journals'));
    }

    public function create()
    {
        return view('admin.journals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'issn'        => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'frequency'   => 'required|in:monthly,quarterly,bi-monthly,annual',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('journals', 'public');
        }

        Journal::create([
            'title'       => $request->title,
            'slug'        => Str::slug($request->title),
            'issn'        => $request->issn,
            'description' => $request->description,
            'frequency'   => $request->frequency,
            'cover_image' => $coverPath,
            'is_active'   => true,
        ]);

        return redirect()->route('admin.journals.index')
                         ->with('success', 'Journal created successfully!');
    }

    public function edit($id)
    {
        $journal = Journal::findOrFail($id);
        return view('admin.journals.edit', compact('journal'));
    }

    public function update(Request $request, $id)
    {
        $journal = Journal::findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'issn'        => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'frequency'   => 'required|in:monthly,quarterly,bi-monthly,annual',
            'cover_image' => 'nullable|image|max:2048',
            'is_active'   => 'boolean',
        ]);

        $coverPath = $journal->cover_image;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('journals', 'public');
        }

        $journal->update([
            'title'       => $request->title,
            'slug'        => Str::slug($request->title),
            'issn'        => $request->issn,
            'description' => $request->description,
            'frequency'   => $request->frequency,
            'cover_image' => $coverPath,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.journals.index')
                         ->with('success', 'Journal updated successfully!');
    }

    public function destroy($id)
    {
        Journal::findOrFail($id)->delete();

        return redirect()->route('admin.journals.index')
                         ->with('success', 'Journal deleted.');
    }
}