# إعداد البريد الإلكتروني - تقنيات القمة

## نظرة عامة

تم إضافة نظام كامل للتحقق من البريد الإلكتروني وإرسال رسائل تأكيد الطلبات.

---

## 1. إعداد البريد الإلكتروني في .env

افتح ملف `.env` وأضف/حدث الإعدادات التالية:

### للـ Gmail (موصى به للاختبار):

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### خطوات إعداد Gmail:

1. **تفعيل App Password:**
   - اذهب إلى: https://myaccount.google.com/security
   - فعّل **2-Step Verification** (إذا لم يكن مفعلاً)
   - اذهب إلى **App passwords**
   - أنشئ App Password جديد
   - استخدم هذا الـ Password في `MAIL_PASSWORD` (ليس كلمة مرور Gmail العادية)

2. **أو استخدام SMTP آخر:**
   - **Outlook/Hotmail:** `smtp-mail.outlook.com` - Port: 587
   - **Yahoo:** `smtp.mail.yahoo.com` - Port: 587
   - **Custom SMTP:** استخدم إعدادات مزود البريد الخاص بك

### مثال كامل لـ .env:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=taqniyat.alqimmah@gmail.com
MAIL_PASSWORD=xxxx xxxx xxxx xxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=taqniyat.alqimmah@gmail.com
MAIL_FROM_NAME="تقنيات القمّة"
```

---

## 2. الميزات المضافة

### ✅ التحقق من البريد الإلكتروني

- عند التسجيل: يتم إرسال بريد التحقق تلقائياً
- المستخدم **لا يمكنه** تسجيل الدخول بدون التحقق
- المستخدم **لا يمكنه** إضافة منتجات للسلة أو الطلب بدون التحقق

### ✅ حماية Routes

الـ Routes التالية محمية بـ `verified` middleware:
- `/cart/*` - السلة
- `/checkout` - صفحة الدفع
- `/orders/*` - الطلبات
- `/maintenance/*` - طلبات الصيانة
- `/payment/*` - طرق الدفع

### ✅ رسالة عند تسجيل الدخول بدون تحقق

إذا حاول المستخدم تسجيل الدخول بدون التحقق:
- رسالة: "يجب تأكيد البريد الإلكتروني أولاً قبل تسجيل الدخول."
- زر لإعادة إرسال بريد التحقق

### ✅ بريد تأكيد الطلب

بعد إنشاء الطلب بنجاح:
- يتم إرسال بريد تأكيد احترافي تلقائياً
- يحتوي على:
  - اسم المستخدم
  - رقم الطلب
  - قائمة المنتجات
  - السعر الإجمالي
  - معلومات الشحن
  - اسم المتجر "تقنيات القمّة"

---

## 3. Routes المضافة

```
GET  /email/verify                    - صفحة التحقق من البريد
POST /email/verification-notification - إعادة إرسال بريد التحقق
```

---

## 4. الملفات المضافة/المحدثة

### Controllers:
- `app/Http/Controllers/Auth/RegisteredUserController.php` - تحديث
- `app/Http/Controllers/Auth/AuthenticatedSessionController.php` - تحديث
- `app/Http/Controllers/OrderController.php` - تحديث (إرسال البريد)

### Models:
- `app/Models/User.php` - إضافة `MustVerifyEmail`

### Mail:
- `app/Mail/OrderConfirmationMail.php` - جديد

### Views:
- `resources/views/auth/login.blade.php` - تحديث (رسالة التحقق)
- `resources/views/auth/verify-email.blade.php` - جديد
- `resources/views/emails/order-confirmation.blade.php` - جديد

### Routes:
- `routes/web.php` - تحديث (حماية routes + verification routes)

### Translations:
- `lang/ar/messages.php` - إضافة ترجمات جديدة

---

## 5. اختبار النظام

### اختبار التحقق من البريد:

1. **سجل حساب جديد:**
   - اذهب إلى `/register`
   - سجل حساب جديد
   - يجب أن تتلقى بريد التحقق

2. **حاول تسجيل الدخول بدون التحقق:**
   - اذهب إلى `/login`
   - سجل دخول بالحساب الجديد
   - يجب أن تظهر رسالة: "يجب تأكيد البريد الإلكتروني أولاً"
   - اضغط "إعادة إرسال بريد التحقق"

3. **تحقق من البريد:**
   - افتح البريد الإلكتروني
   - اضغط على رابط التحقق
   - الآن يمكنك تسجيل الدخول

### اختبار بريد تأكيد الطلب:

1. **سجل دخول بحساب محقق**
2. **أضف منتجات للسلة**
3. **اكمل الطلب**
4. **بعد تأكيد الطلب، يجب أن تتلقى بريد تأكيد**

---

## 6. استكشاف الأخطاء

### البريد لا يُرسل:

1. **تحقق من إعدادات .env:**
   ```bash
   php artisan config:clear
   ```

2. **اختبر الإعدادات:**
   ```bash
   php artisan tinker
   ```
   ثم:
   ```php
   Mail::raw('Test', function($msg) {
       $msg->to('your-email@example.com')->subject('Test');
   });
   ```

3. **تحقق من Logs:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

### رسالة "Connection refused":

- تأكد من `MAIL_HOST` و `MAIL_PORT` صحيحة
- تأكد من `MAIL_ENCRYPTION` (tls أو ssl)
- تأكد من App Password (لـ Gmail)

### البريد يذهب إلى Spam:

- أضف `MAIL_FROM_ADDRESS` و `MAIL_FROM_NAME`
- استخدم عنوان بريد موثوق
- في الإنتاج، استخدم خدمة بريد احترافية (SendGrid, Mailgun, etc.)

---

## 7. للإنتاج (Production)

### استخدام خدمة بريد احترافية:

**Mailgun:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=your-mailgun-username
MAIL_PASSWORD=your-mailgun-password
MAIL_ENCRYPTION=tls
```

**SendGrid:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
```

---

## 8. ملاحظات مهمة

- ✅ النظام يعمل مع **SQLite** و **MySQL**
- ✅ جميع الرسائل بالعربية
- ✅ التصميم متجاوب (Responsive)
- ✅ البريد يُرسل تلقائياً بعد إنشاء الطلب
- ✅ التحقق من البريد إجباري قبل الطلب

---

## الدعم

لأي مشاكل أو استفسارات، راجع:
- Laravel Mail Documentation
- Gmail App Passwords Guide
- Laravel Email Verification Documentation
