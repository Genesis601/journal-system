<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $manuscripts = $user->articles()
                            ->with('journal')
                            ->latest()
                            ->get();

        $stats = [
            'total'       => $manuscripts->count(),
            'submitted'   => $manuscripts->whereIn('status', ['submitted', 'under_review'])->count(),
            'published'   => $manuscripts->where('status', 'published')->count(),
            'rejected'    => $manuscripts->where('status', 'rejected')->count(),
        ];

        $messages = $user->receivedMessages()
                         ->with('sender')
                         ->latest()
                         ->take(5)
                         ->get();

        return view('author.dashboard', compact('manuscripts', 'stats', 'messages'));
    }
}