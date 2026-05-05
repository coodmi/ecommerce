<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
    <style>
        body { margin: 0; padding: 0; background: #f4f6f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }
        .wrapper { max-width: 560px; margin: 40px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #e11d48, #be123c); padding: 40px 40px 32px; text-align: center; }
        .header h1 { color: #fff; margin: 0; font-size: 24px; font-weight: 700; }
        .header p { color: rgba(255,255,255,0.85); margin: 8px 0 0; font-size: 14px; }
        .body { padding: 40px; }
        .body p { color: #4b5563; font-size: 15px; line-height: 1.7; margin: 0 0 20px; }
        .btn { display: block; width: fit-content; margin: 28px auto; background: linear-gradient(135deg, #e11d48, #be123c); color: #fff !important; text-decoration: none; padding: 14px 36px; border-radius: 10px; font-weight: 700; font-size: 15px; }
        .note { background: #fef9f0; border: 1px solid #fde68a; border-radius: 10px; padding: 16px 20px; margin: 24px 0 0; }
        .note p { color: #92400e; font-size: 13px; margin: 0; }
        .footer { background: #f9fafb; padding: 24px 40px; text-align: center; border-top: 1px solid #e5e7eb; }
        .footer p { color: #9ca3af; font-size: 12px; margin: 0; }
        .url-box { background: #f3f4f6; border-radius: 8px; padding: 12px 16px; word-break: break-all; font-size: 12px; color: #6b7280; margin-top: 16px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>🔐 Reset Your Password</h1>
            <p>You requested a password reset</p>
        </div>
        <div class="body">
            <p>Hi there,</p>
            <p>We received a request to reset the password for your account associated with <strong>{{ $email }}</strong>. Click the button below to set a new password.</p>

            <a href="{{ $resetUrl }}" class="btn">Reset My Password</a>

            <div class="note">
                <p>⏱ This link will expire in <strong>60 minutes</strong>. If you didn't request a password reset, you can safely ignore this email — your password won't change.</p>
            </div>

            <p style="margin-top:24px; font-size:13px; color:#9ca3af;">If the button above doesn't work, copy and paste this URL into your browser:</p>
            <div class="url-box">{{ $resetUrl }}</div>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
