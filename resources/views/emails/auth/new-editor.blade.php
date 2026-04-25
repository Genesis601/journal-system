 
@extends('emails.layout')

@section('content')
    <p class="greeting">Welcome to JournalSpace Editorial Team! ✏️</p>
    <p class="message">
        Dear <strong>{{ $name }}</strong>,<br><br>
        You have been added as an <strong>Editor</strong> on JournalSpace. Your account has been created and you can now log in to access your editorial dashboard.
    </p>

    <div class="success-box">
        <p>✅ Your editor account is ready and active.</p>
    </div>

    <div class="info-box">
        <p><strong>Login URL:</strong> {{ url('/login') }}</p>
        <p><strong>Email:</strong> {{ $email }}</p>
        <p><strong>Password:</strong> {{ $password }}</p>
        <p><strong>Role:</strong> <span class="status-badge badge-blue">Editor</span></p>
    </div>

    <div class="warning-box">
        <p>⚠️ Please change your password immediately after your first login for security.</p>
    </div>

    <p class="message">
        As an editor you will be responsible for reviewing manuscript submissions, approving articles for publication and providing feedback to authors. Your dashboard gives you full access to all submitted manuscripts.
    </p>

    <a href="{{ url('/login') }}" class="btn">Login to Your Dashboard</a>

    <div class="divider"></div>

    <p style="font-size:13px; color:#6b7280;">
        If you did not expect this email or have any questions please contact the system administrator.
    </p>
@endsection