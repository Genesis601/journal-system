@extends('emails.layout')

@section('content')
    <p class="greeting">New Contact Message 📬</p>
    <p class="message">
        You have received a new message through the JournalSpace contact form.
    </p>

    <div class="info-box">
        <p><strong>From:</strong> {{ $senderName }}</p>
        <p><strong>Email:</strong> {{ $senderEmail }}</p>
        <p><strong>Subject:</strong> {{ $messageSubject }}</p>
    </div>

    <div class="info-box">
        <p><strong>Message:</strong></p>
        <br>
        <p>{{ $messageBody }}</p>
    </div>

    <div class="divider"></div>

    <p style="font-size:13px; color:#6b7280;">
        Reply directly to this email to respond to
        <strong>{{ $senderName }}</strong> at
        <a href="mailto:{{ $senderEmail }}">{{ $senderEmail }}</a>
    </p>
@endsection