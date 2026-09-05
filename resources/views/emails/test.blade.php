<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Test Email') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Cairo', 'Arial', sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            direction: rtl;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }
        .email-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 700;
        }
        .email-body {
            padding: 40px 20px;
            text-align: center;
        }
        .test-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 40px;
        }
        .test-message {
            font-size: 18px;
            color: #333;
            line-height: 1.8;
            margin-bottom: 20px;
        }
        .success-badge {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4caf50;
            color: #ffffff;
            border-radius: 25px;
            font-weight: 600;
            margin-top: 20px;
        }
        .email-footer {
            background-color: #2c3e50;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>تقنيات القمّة</h1>
            <p>اختبار الإرسال</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <div class="test-icon">
                ✓
            </div>
            <h2 style="color: #333; margin-bottom: 20px;">اختبار الإرسال - تقنيات القمّة</h2>
            <p class="test-message">
                هذه رسالة تجريبية للتأكد من أن نظام إرسال الإيميلات يعمل بنجاح.
            </p>
            <div class="success-badge">
                ✓ تم الإرسال بنجاح
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} تقنيات القمّة. جميع الحقوق محفوظة.</p>
        </div>
    </div>
</body>
</html>
