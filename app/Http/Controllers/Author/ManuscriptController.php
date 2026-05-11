<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Mail\ManuscriptSubmitted;
use App\Models\Article;
use App\Models\Journal;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ManuscriptController extends Controller
{
    protected CloudinaryService $cloudinary;

    public function __construct(CloudinaryService $cloudinary)
    {
        $this->cloudinary = $cloudinary;
    }

    public function index()
    {
        $manuscripts = Article::where('author_id', Auth::id())
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

        try {
            $uploaded = $this->cloudinary->uploadFile(
                $request->file('file')->getRealPath(),
                'journal-system/manuscripts'
            );
            $filePath = $uploaded['secure_url'];
            $publicId = $uploaded['public_id'];
        } catch (\Exception $e) {
            Log::error('File upload failed: ' . $e->getMessage());
            return back()
                ->with('error', 'File upload failed. Please try again.')
                ->withInput();
        }

        $article = Article::create([
            'title'          => $request->title,
            'slug'           => Str::slug($request->title) . '-' . Str::random(6),
            'journal_id'     => $request->journal_id,
            'author_id'      => Auth::id(),
            'abstract'       => $request->abstract,
            'keywords'       => $request->keywords,
            'file_path'      => $filePath,
            'file_public_id' => $publicId,
            'status'         => 'submitted',
        ]);

        // Send confirmation email
        try {
            Mail::to(Auth::user()->email)
                ->send(new ManuscriptSubmitted($article));
        } catch (\Exception $e) {
            Log::error('Submission email failed: ' . $e->getMessage());
        }

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
        $publicId = $manuscript->file_public_id;

        if ($request->hasFile('file')) {
            if ($manuscript->file_public_id) {
                $this->cloudinary->deleteFile($manuscript->file_public_id);
            }

            try {
                $uploaded = $this->cloudinary->uploadFile(
                    $request->file('file')->getRealPath(),
                    'journal-system/manuscripts'
                );
                $filePath = $uploaded['secure_url'];
                $publicId = $uploaded['public_id'];
            } catch (\Exception $e) {
                Log::error('File upload failed: ' . $e->getMessage());
                return back()
                    ->with('error', 'File upload failed. Please try again.')
                    ->withInput();
            }
        }

        $manuscript->update([
            'title'          => $request->title,
            'journal_id'     => $request->journal_id,
            'abstract'       => $request->abstract,
            'keywords'       => $request->keywords,
            'file_path'      => $filePath,
            'file_public_id' => $publicId,
            'status'         => 'submitted',
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

        if ($manuscript->file_public_id) {
            $this->cloudinary->deleteFile($manuscript->file_public_id);
        }

        $manuscript->delete();

        return redirect()->route('author.manuscripts.index')
                         ->with('success', 'Manuscript deleted.');
    }
}