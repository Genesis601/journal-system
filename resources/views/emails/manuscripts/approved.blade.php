@extends('emails.layout')

@section('content')
    <p class="greeting">Congratulations! Your Article is Published 🎉</p>
    <p class="message">
        Dear <strong>{{ $article->author->name }}</strong>,<br><br>
        We are delighted to inform you that your manuscript has been reviewed and <strong>approved for publication</strong> on JournalSpace. Your article is now live and freely accessible to researchers worldwide!
    </p>

    <div class="success-box">
        <p>✅ Your article has been successfully published on JournalSpace.</p>
    </div>

    <div class="info-box">
        <p><strong>Title:</strong> {{ $article->title }}</p>
        <p><strong>Journal:</strong> {{ $article->journal->title }}</p>
        <p><strong>Published On:</strong> {{ $article->published_at?->format('F d, Y') }}</p>
        <p><strong>Status:</strong> <span class="status-badge badge-green">Published</span></p>
    </div>

    @if($comments)
        <p class="message"><strong>Editor's Note:</strong><br>{{ $comments }}</p>
    @endif

    <p class="message">
        Your research is now available to thousands of readers across 180+ countries. Share your article with your network to maximize its impact.
    </p>

    <a href="{{ url('/articles/' . $article->slug) }}" class="btn">View Your Published Article</a>
    <a href="{{ url('/author/dashboard') }}" class="btn-navy" style="margin-left:8px">Go to Dashboard</a>

    <div class="divider"></div>

    <p style="font-size:13px; color:#6b7280;">
        Thank you for contributing to open access research. We look forward to receiving more of your work!
    </p>
@endsection 
