<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class JournalController extends Controller
{
    protected CloudinaryService $cloudinary;

    public function __construct(CloudinaryService $cloudinary)
    {
        $this->cloudinary = $cloudinary;
    }

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

        $coverPath     = null;
        $coverPublicId = null;

        if ($request->hasFile('cover_image')) {
            try {
                $uploaded      = $this->cloudinary->uploadImage(
                    $request->file('cover_image')->getRealPath(),
                    'journal-system/covers'
                );
                $coverPath     = $uploaded['secure_url'];
                $coverPublicId = $uploaded['public_id'];
            } catch (\Exception $e) {
                Log::error('Cover image upload failed: ' . $e->getMessage());
            }
        }

        Journal::create([
            'title'          => $request->title,
            'slug'           => Str::slug($request->title),
            'issn'           => $request->issn,
            'description'    => $request->description,
            'frequency'      => $request->frequency,
            'cover_image'    => $coverPath,
            'cover_public_id'=> $coverPublicId,
            'is_active'      => true,
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

        $coverPath     = $journal->cover_image;
        $coverPublicId = $journal->cover_public_id;

        if ($request->hasFile('cover_image')) {
            if ($coverPublicId) {
                $this->cloudinary->deleteFile($coverPublicId, 'image');
            }

            try {
                $uploaded      = $this->cloudinary->uploadImage(
                    $request->file('cover_image')->getRealPath(),
                    'journal-system/covers'
                );
                $coverPath     = $uploaded['secure_url'];
                $coverPublicId = $uploaded['public_id'];
            } catch (\Exception $e) {
                Log::error('Cover image upload failed: ' . $e->getMessage());
            }
        }

        $journal->update([
            'title'           => $request->title,
            'slug'            => Str::slug($request->title),
            'issn'            => $request->issn,
            'description'     => $request->description,
            'frequency'       => $request->frequency,
            'cover_image'     => $coverPath,
            'cover_public_id' => $coverPublicId,
            'is_active'       => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.journals.index')
                         ->with('success', 'Journal updated successfully!');
    }

    public function destroy($id)
    {
        $journal = Journal::findOrFail($id);

        if ($journal->cover_public_id) {
            $this->cloudinary->deleteFile($journal->cover_public_id, 'image');
        }

        $journal->delete();

        return redirect()->route('admin.journals.index')
                         ->with('success', 'Journal deleted.');
    }
}