@extends('emails.layout')

@section('content')
    <p class="greeting">Update on Your Manuscript Submission</p>
    <p class="message">
        Dear <strong>{{ $article->author->name }}</strong>,<br><br>
        Thank you for submitting your manuscript to JournalSpace. After careful review by our editorial team, we regret to inform you that your manuscript has not been accepted for publication at this time.
    </p>

    <div class="warning-box">
        <p>❌ Your manuscript was not accepted in its current form.</p>
    </div>

    <div class="info-box">
        <p><strong>Title:</strong> {{ $article->title }}</p>
        <p><strong>Journal:</strong> {{ $article->journal->title }}</p>
        <p><strong>Status:</strong> <span class="status-badge badge-red">Rejected</span></p>
    </div>

    <div class="info-box">
        <p><strong>Editor's Feedback:</strong><br><br>{{ $comments }}</p>
    </div>

    <p class="message">
        We encourage you to carefully review the feedback provided above and consider revising your manuscript accordingly. You are welcome to resubmit an improved version through your author dashboard.
    </p>

    <a href="{{ url('/author/manuscripts') }}" class="btn">Revise & Resubmit</a>

    <div class="divider"></div>

    <p style="font-size:13px; color:#6b7280;">
        We appreciate your contribution to JournalSpace and hope to receive a revised version of your manuscript soon.
    </p>
@endsection 
