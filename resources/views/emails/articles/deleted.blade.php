@extends('emails.layout')

@section('content')
    <p class="greeting">Notice: Your Article Has Been Removed</p>
    <p class="message">
        Dear <strong>{{ $authorName }}</strong>,<br><br>
        We are writing to inform you that your article has been permanently removed from JournalSpace by our editorial team.
    </p>

    <div class="warning-box">
        <p>🗑️ Your article has been permanently deleted from the platform.</p>
    </div>

    <div class="info-box">
        <p><strong>Article Title:</strong> {{ $articleTitle }}</p>
        <p><strong>Reason for Removal:</strong><br><br>{{ $reason }}</p>
    </div>

    <p class="message">
        If you believe this decision was made in error or would like to discuss further, please contact our editorial team through the contact page on our website.
    </p>

    <a href="{{ url('/contact') }}" class="btn">Contact Editorial Team</a>

    <div class="divider"></div>

    <p style="font-size:13px; color:#6b7280;">
        We appreciate your contributions to JournalSpace and hope to continue working with you in the future.
    </p>
@endsection 
