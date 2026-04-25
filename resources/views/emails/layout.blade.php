<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JournalSpace</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', sans-serif; background-color: #f3f4f6; color: #374151; }
        .wrapper { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: #0f2744; padding: 32px 40px; text-align: center; }
        .header-logo { display: inline-flex; align-items: center; gap: 12px; text-decoration: none; }
        .logo-box { width: 44px; height: 44px; background: #e8a020; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; }
        .logo-text { color: #ffffff; font-size: 18px; font-weight: 700; }
        .brand-name { color: #ffffff; font-size: 20px; font-weight: 600; }
        .brand-sub { color: #a0b4cc; font-size: 12px; }
        .body { padding: 40px; }
        .greeting { font-size: 22px; font-weight: 600; color: #0f2744; margin-bottom: 12px; }
        .message { font-size: 15px; line-height: 1.7; color: #4b5563; margin-bottom: 24px; }
        .info-box { background: #f8fafc; border-left: 4px solid #e8a020; border-radius: 0 8px 8px 0; padding: 16px 20px; margin: 24px 0; }
        .info-box p { font-size: 14px; color: #374151; line-height: 1.6; }
        .info-box strong { color: #0f2744; }
        .success-box { background: #f0fdf4; border-left: 4px solid #22c55e; border-radius: 0 8px 8px 0; padding: 16px 20px; margin: 24px 0; }
        .success-box p { font-size: 14px; color: #166534; line-height: 1.6; }
        .warning-box { background: #fef2f2; border-left: 4px solid #ef4444; border-radius: 0 8px 8px 0; padding: 16px 20px; margin: 24px 0; }
        .warning-box p { font-size: 14px; color: #991b1b; line-height: 1.6; }
        .btn { display: inline-block; background: #e8a020; color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-size: 14px; font-weight: 600; margin: 8px 0; }
        .btn-navy { display: inline-block; background: #0f2744; color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-size: 14px; font-weight: 600; margin: 8px 0; }
        .divider { height: 1px; background: #e5e7eb; margin: 28px 0; }
        .footer { background: #0a1e35; padding: 24px 40px; text-align: center; }
        .footer p { color: #3d5a75; font-size: 12px; line-height: 1.8; }
        .footer a { color: #6b8aaa; text-decoration: none; }
        .footer a:hover { color: #a0b4cc; }
        .footer .brand { color: #e8a020; font-weight: 600; }
        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-blue { background: #eff6ff; color: #1d4ed8; }
        .badge-green { background: #f0fdf4; color: #166534; }
        .badge-red { background: #fef2f2; color: #991b1b; }
        .badge-amber { background: #fffbeb; color: #92400e; }
    </style>
</head>
<body>
    <div class="wrapper">

        {{-- HEADER --}}
        <div class="header">
            <div class="header-logo">
                <div class="logo-box">
                    <span class="logo-text">JS</span>
                </div>
                <div style="text-align:left">
                    <div class="brand-name">JournalSpace</div>
                    <div class="brand-sub">Open Access Publishing</div>
                </div>
            </div>
        </div>

        {{-- BODY --}}
        <div class="body">
            @yield('content')
        </div>

        {{-- FOOTER --}}
        <div class="footer">
            <p>
                This email was sent by <span class="brand">JournalSpace</span><br>
                Open Access Publishing Platform<br><br>
                <a href="{{ url('/') }}">Visit Website</a> ·
                <a href="{{ url('/journals') }}">Browse Journals</a> ·
                <a href="{{ url('/contact') }}">Contact Us</a><br><br>
                Designed & Developed by
                <a href="https://genesis601.github.io/VixTech-Portfolio/" style="color:#e8a020">VixTech Developers</a>
            </p>
        </div>

    </div>
</body>
</html>