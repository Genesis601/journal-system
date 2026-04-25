@extends('emails.layout')

@section('content')
    <p class="greeting">Your Article Has Been Unpublished</p>
    <p class="message">
        Dear <strong>{{ $article->author->name }}</strong>,<br><br>
        We are writing to inform you that your article has been temporarily removed from public view on JournalSpace pending revision.
    </p>

    <div class="warning-box">
        <p>⚠️ Your article has been unpublished and requires revision.</p>
    </div>

    <div class="info-box">
        <p><strong>Title:</strong> {{ $article->title }}</p>
        <p><strong>Journal:</strong> {{ $article->journal->title }}</p>
        <p><strong>Reason:</strong><br><br>{{ $reason }}</p>
    </div>

    <p class="message">
        Please log in to your author dashboard, revise your manuscript based on the feedback above and resubmit it for review. Once approved it will be republished on the platform.
    </p>

    <a href="{{ url('/author/manuscripts') }}" class="btn">Go to My Manuscripts</a>

    <div class="divider"></div>

    <p style="font-size:13px; color:#6b7280;">
        If you have any questions about this decision, please contact our editorial team.
    </p>
@endsection 
