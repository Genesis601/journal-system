@extends('emails.layout')

@section('content')
    <p class="greeting">Password Reset Request 🔑</p>
    <p class="message">
        Dear <strong>{{ $userName }}</strong>,<br><br>
        We received a request to reset the password for your JournalSpace account.
        Click the button below to set a new password.
    </p>

    <div style="text-align:center; margin: 32px 0;">
        <a href="{{ $resetUrl }}" class="btn">Reset My Password</a>
    </div>

    <div class="info-box">
        <p>⏰ This link expires in <strong>60 minutes</strong> for your security.</p>
    </div>

    <div class="warning-box">
        <p>🔒 If you did not request this reset please ignore this email.
        Your password will remain unchanged.</p>
    </div>

    <div class="divider"></div>

    <p style="font-size:13px; color:#6b7280;">
        If the button above doesn't work copy and paste this link into your browser:<br>
        <a href="{{ $resetUrl }}" style="color:#e8a020; word-break:break-all;">
            {{ $resetUrl }}
        </a>
    </p>
@endsection