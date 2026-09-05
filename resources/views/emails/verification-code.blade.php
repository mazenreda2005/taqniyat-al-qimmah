<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Verification Code') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Cairo', 'Arial', sans-serif; background-color: #f4f4f4; padding: 20px; direction: rtl; }
        .email-container { max-width: 500px; margin: 0 auto; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .email-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 24px; text-align: center; }
        .email-header h1 { font-size: 22px; margin-bottom: 8px; }
        .email-body { padding: 28px 24px; }
        .email-body p { color: #333; line-height: 1.6; margin-bottom: 16px; }
        .code-box { background: #f0f0f0; border: 2px dashed #667eea; border-radius: 8px; padding: 20px; text-align: center; margin: 20px 0; }
        .code-box .code { font-size: 32px; font-weight: bold; letter-spacing: 8px; color: #667eea; }
        .email-footer { padding: 16px 24px; background: #f8f8f8; color: #666; font-size: 13px; text-align: center; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>تقنيات القمّة</h1>
            <p>{{ __('Verification Code') }}</p>
        </div>
        <div class="email-body">
            <p>{{ __('Please use the following code to verify your email address on the website:') }}</p>
            <div class="code-box">
                <span class="code">{{ $code }}</span>
            </div>
            <p>{{ __('This code is valid for 10 minutes. Do not share it with anyone.') }}</p>
        </div>
        <div class="email-footer">
            {{ __('If you did not request this code, you can ignore this email.') }}
        </div>
    </div>
</body>
</html>
