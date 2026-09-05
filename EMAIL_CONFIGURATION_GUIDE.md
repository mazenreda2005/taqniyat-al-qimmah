# دليل إعداد البريد الإلكتروني - تقنيات القمّة

## ✅ تم الإعداد

تم إعداد نظام البريد الإلكتروني بالكامل لاستخدام Gmail SMTP.

---

## 📧 إعدادات .env

تم إضافة الإعدادات التالية في `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tqnyatalqmh@gmail.com
MAIL_PASSWORD=PLACE_APP_PASSWORD_HERE
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tqnyatalqmh@gmail.com
MAIL_FROM_NAME="تقنيات القمّة"
```

---

## 🔑 خطوات الحصول على Gmail App Password

### 1. تفعيل التحقق بخطوتين (2-Step Verification)

1. اذهب إلى: https://myaccount.google.com/security
2. ابحث عن **"2-Step Verification"**
3. فعّله إذا لم يكن مفعلاً

### 2. إنشاء App Password

1. بعد تفعيل التحقق بخطوتين، اذهب إلى: https://myaccount.google.com/apppasswords
2. أو ابحث في Google Account عن **"App passwords"**
3. اختر **"Mail"** و **"Other (Custom name)"**
4. اكتب اسم: "تقنيات القمة Laravel"
5. اضغط **"Generate"**
6. **انسخ الـ Password** (16 حرف بدون مسافات)
7. ضعه في `.env` في `MAIL_PASSWORD`

**مثال:**
```env
MAIL_PASSWORD=abcd efgh ijkl mnop
```
يجب أن يكون بدون مسافات:
```env
MAIL_PASSWORD=abcdefghijklmnop
```

---

## 🧪 اختبار النظام

### 1. افتح الرابط التالي في المتصفح:

```
http://127.0.0.1:8000/test-email
```

### 2. النتيجة المتوقعة:

**نجاح:**
```json
{
  "success": true,
  "message": "تم إرسال رسالة الاختبار بنجاح",
  "sent_to": "tqnyatalqmh@gmail.com"
}
```

**فشل:**
```json
{
  "success": false,
  "message": "فشل إرسال البريد الإلكتروني، تحقق من إعدادات SMTP وكلمة مرور التطبيق."
}
```

### 3. تحقق من صندوق الوارد:

- افتح بريد `tqnyatalqmh@gmail.com`
- ابحث عن رسالة "اختبار الإرسال - تقنيات القمّة"
- إذا لم تجدها، تحقق من **Spam/Junk**

---

## 📋 الملفات المضافة/المحدثة

### ✅ تم إنشاء:

1. **config/mail.php** - إعدادات البريد
2. **app/Mail/TestMail.php** - Mailable للاختبار
3. **resources/views/emails/test.blade.php** - Template بريد الاختبار
4. **app/Http/Controllers/TestEmailController.php** - Controller للاختبار
5. **routes/web.php** - Route `/test-email` (مؤقت)

### ✅ تم تحديث:

1. **.env** - إضافة إعدادات البريد
2. **lang/ar/messages.php** - إضافة ترجمة "Test Email"

---

## ✅ التأكد من استخدام نفس الإعدادات

جميع أنواع البريد تستخدم نفس الإعدادات من `.env`:

- ✅ **Email Verification** - يستخدم `Mail::send()` مع إعدادات SMTP
- ✅ **Order Confirmation** - يستخدم `OrderConfirmationMail` مع إعدادات SMTP
- ✅ **Test Email** - يستخدم `TestMail` مع إعدادات SMTP

جميعها تقرأ من:
- `MAIL_HOST` → `smtp.gmail.com`
- `MAIL_PORT` → `587`
- `MAIL_USERNAME` → `tqnyatalqmh@gmail.com`
- `MAIL_PASSWORD` → من App Password
- `MAIL_ENCRYPTION` → `tls`
- `MAIL_FROM_ADDRESS` → `tqnyatalqmh@gmail.com`
- `MAIL_FROM_NAME` → `"تقنيات القمّة"`

---

## 🚨 استكشاف الأخطاء

### الخطأ: "Connection refused" أو "Connection timeout"

**الحل:**
1. تأكد من `MAIL_HOST=smtp.gmail.com`
2. تأكد من `MAIL_PORT=587`
3. تأكد من `MAIL_ENCRYPTION=tls` (ليس ssl)
4. تأكد من تفعيل **2-Step Verification**
5. استخدم **App Password** وليس كلمة مرور Gmail العادية

### الخطأ: "Authentication failed"

**الحل:**
1. تأكد من استخدام **App Password** وليس كلمة المرور العادية
2. تأكد من نسخ App Password بشكل صحيح (16 حرف بدون مسافات)
3. تأكد من تفعيل **2-Step Verification**

### البريد يذهب إلى Spam

**الحل:**
1. تأكد من `MAIL_FROM_ADDRESS` و `MAIL_FROM_NAME` موجودة
2. في الإنتاج، استخدم خدمة بريد احترافية (SendGrid, Mailgun)

### "Failed to send order confirmation email"

**الحل:**
- الخطأ يُسجل في `storage/logs/laravel.log`
- راجع الـ logs لمعرفة السبب الدقيق
- تأكد من إعدادات SMTP صحيحة

---

## 🗑️ إزالة Route الاختبار (بعد التأكد)

بعد التأكد من أن البريد يعمل:

1. احذف Route من `routes/web.php`:
   ```php
   // احذف هذا السطر:
   Route::get('/test-email', [TestEmailController::class, 'sendTestEmail'])->name('test.email');
   ```

2. احذف Controller (اختياري):
   ```bash
   rm app/Http/Controllers/TestEmailController.php
   ```

3. احذف TestMail (اختياري):
   ```bash
   rm app/Mail/TestMail.php
   rm resources/views/emails/test.blade.php
   ```

---

## 📝 ملاحظات مهمة

- ✅ **لا تضع كلمات المرور في الكود** - استخدم `.env` فقط
- ✅ **App Password** مختلف عن كلمة مرور Gmail العادية
- ✅ بعد تغيير `.env`، شغّل: `php artisan config:clear`
- ✅ في الإنتاج، استخدم خدمة بريد احترافية (Mailgun, SendGrid)
- ✅ جميع البريد يستخدم نفس الإعدادات من `.env`

---

## ✅ الخطوات التالية

1. **احصل على App Password من Gmail**
2. **ضعه في `.env` في `MAIL_PASSWORD`**
3. **شغّل:** `php artisan config:clear`
4. **اختبر:** افتح `http://127.0.0.1:8000/test-email`
5. **تحقق من البريد:** افتح `tqnyatalqmh@gmail.com`
6. **بعد التأكد:** احذف route الاختبار

---

## 🎯 جاهز للاستخدام!

النظام جاهز. فقط ضع App Password في `.env` واختبر!
