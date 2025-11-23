<!DOCTYPE html>
<html>
<head>
    <title>{{ trns("edarat_app_-_but_password") }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .header {
            color: #00193A;
            text-align: center;
            margin-bottom: 25px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #00193A;
            color: #00F3CA !important;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
        .content {
            background-color: white;
            padding: 20px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>إدارة 365 - تعيين كلمة المرور</h1>
        </div>
        
        <div class="content">
            <p>عزيزي {{ $name }},</p>
            
            <p>لقد تم تسجيلك في نظامنا، يرجى تعيين كلمة المرور الخاصة بك من خلال الرابط أدناه.</p>
            
            <div style="text-align: center;">
                <a href="{{ $resetLink }}" class="button">
                    تعيين كلمة المرور
                </a>
            </div>
            
            <p>إذا لم تطلب ذلك، يرجى تجاهل هذا البريد الإلكتروني.</p>
        </div>
        
        <div class="footer">
            <p>شكراً لك،<br>فريق إدارات365</p>
            
            <p>سينتهي صلاحية هذا الرابط خلال ساعة واحدة.</p>
        </div>
    </div>
</body>
</html>