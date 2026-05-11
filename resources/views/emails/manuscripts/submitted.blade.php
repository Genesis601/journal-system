@extends('emails.layout')

@section('content')
    <p class="greeting">Manuscript Received! 📄</p>
    <p class="message">
        Dear <strong>{{ $article->author->name }}</strong>,<br><br>
        Thank you for submitting your manuscript to JournalSpace. We have successfully
        received your submission and it is now in our editorial review queue.
    </p>

    <div class="info-box">
        <p><strong>Title:</strong> {{ $article->title }}</p>
        <p><strong>Journal:</strong> {{ $article->journal->title }}</p>
        <p><strong>Status:</strong> <span class="status-badge badge-blue">Submitted</span></p>
        <p><strong>Submitted On:</strong> {{ $article->created_at->format('F d, Y \a\t h:i A') }}</p>
    </div>

    <p class="message">
        Our editorial team will review your manuscript and get back to you with a decision.
        You can track the status of your submission from your author dashboard at any time.
    </p>

    <div style="text-align:center; margin: 28px 0;">
        <a href="{{ url('/author/dashboard') }}" class="btn">Track Your Submission</a>
    </div>

    <div class="divider"></div>

    <p style="font-size:13px; color:#6b7280;">
        If you have any questions about your submission please contact our editorial team
        through the <a href="{{ url('/contact') }}" style="color:#e8a020;">contact page</a>.
    </p>
@endsection