@extends('emails.layout')

@section('content')
    <p class="greeting">Your Manuscript is Under Review 🔍</p>
    <p class="message">
        Dear <strong>{{ $article->author->name }}</strong>,<br><br>
        Great news! Your manuscript has been assigned to one of our editors and is currently under review. We will notify you once a decision has been made.
    </p>

    <div class="info-box">
        <p><strong>Title:</strong> {{ $article->title }}</p>
        <p><strong>Journal:</strong> {{ $article->journal->title }}</p>
        <p><strong>Status:</strong> <span class="status-badge badge-amber">Under Review</span></p>
    </div>

    <p class="message">
        The review process typically takes a few days. You will receive an email notification as soon as a decision is reached. In the meantime, you can monitor your submission status from your dashboard.
    </p>

    <a href="{{ url('/author/dashboard') }}" class="btn">View Dashboard</a>
@endsection 
