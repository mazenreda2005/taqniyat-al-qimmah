# نظام الدفع المتكامل - تقنيات القمة

## نظرة عامة

تم إنشاء نظام دفع متكامل يدعم 5 طرق دفع مختلفة:
1. **Visa / MasterCard / Mada** - دفع أونلاين
2. **STC Pay** - دفع عبر تطبيق STC Pay
3. **Tamara** - Buy Now Pay Later
4. **تحويل بنكي مباشر** - مع رفع إيصال
5. **الدفع عند الاستلام** - Cash on Delivery

---

## هيكل قاعدة البيانات

### جدول `orders`
- `payment_method`: طريقة الدفع المختارة
- `payment_status`: حالة الدفع (pending, paid, failed, under_review, refunded)

### جدول `payments`
- `order_id`: معرف الطلب
- `payment_method`: طريقة الدفع
- `status`: حالة الدفع
- `amount`: المبلغ
- `transaction_id`: معرف المعاملة من بوابة الدفع
- `receipt_path`: مسار إيصال التحويل البنكي
- `gateway_response`: استجابة بوابة الدفع (JSON)
- `webhook_data`: بيانات Webhook (JSON)

---

## آلية العمل لكل طريقة دفع

### 1. Visa / MasterCard / Mada

**التدفق:**
1. المستخدم يختار طريقة الدفع في صفحة Checkout
2. يتم إنشاء الطلب بحالة `pending`
3. يتم إنشاء سجل Payment بحالة `pending`
4. يتم توجيه المستخدم إلى صفحة محاكاة بوابة الدفع (في الإنتاج: بوابة الدفع الفعلية)
5. بعد الموافقة/الرفض، يتم استدعاء `callback`
6. يتم تحديث حالة الدفع والطلب
7. يتم توجيه المستخدم إلى صفحة النجاح/الفشل

**Webhook:**
- Route: `/webhooks/visa-mada`
- يتم استدعاؤه من بوابة الدفع لتأكيد حالة الدفع

---

### 2. STC Pay

**التدفق:**
- مشابه لـ Visa/Mada
- في الإنتاج: يتم توجيه المستخدم إلى تطبيق STC Pay أو الموقع

**Webhook:**
- Route: `/webhooks/stc-pay`

---

### 3. Tamara (Buy Now Pay Later)

**التدفق:**
- مشابه لـ Visa/Mada
- في الإنتاج: يتم توجيه المستخدم إلى Tamara Checkout

**Webhook:**
- Route: `/webhooks/tamara`

---

### 4. التحويل البنكي

**التدفق:**
1. المستخدم يختار التحويل البنكي
2. يتم إنشاء الطلب بحالة `under_review`
3. يتم عرض بيانات الحساب البنكي (من `config/payment.php`)
4. المستخدم يقوم بالتحويل
5. المستخدم يرفع إيصال التحويل
6. يتم حفظ الإيصال في `storage/app/public/receipts`
7. الأدمن يستطيع الموافقة/الرفض من لوحة التحكم

**الموافقة/الرفض:**
- Route: `/admin/payments/{payment}/approve`
- Route: `/admin/payments/{payment}/reject`

---

### 5. الدفع عند الاستلام

**التدفق:**
1. المستخدم يختار الدفع عند الاستلام
2. يتم إنشاء الطلب بحالة `processing`
3. يتم إنشاء سجل Payment بحالة `pending`
4. يتم تأكيد الطلب مباشرة
5. الدفع يتم عند التسليم

---

## Routes

### Payment Routes (محمية بـ auth)
```
GET  /payment/process/{order}              - توجيه إلى طريقة الدفع المختارة
GET  /payment/success/{order}               - صفحة نجاح الدفع
GET  /payment/failure/{order}               - صفحة فشل الدفع

GET  /payment/visa-mada/process/{order}     - معالجة Visa/Mada
GET  /payment/visa-mada/simulate/{order}    - محاكاة بوابة الدفع
GET  /payment/visa-mada/callback/{order}   - callback من بوابة الدفع

GET  /payment/stc-pay/process/{order}       - معالجة STC Pay
GET  /payment/stc-pay/simulate/{order}      - محاكاة STC Pay
GET  /payment/stc-pay/callback/{order}      - callback من STC Pay

GET  /payment/tamara/process/{order}       - معالجة Tamara
GET  /payment/tamara/simulate/{order}       - محاكاة Tamara
GET  /payment/tamara/callback/{order}       - callback من Tamara

GET  /payment/bank-transfer/{order}         - عرض بيانات التحويل البنكي
POST /payment/bank-transfer/upload/{order} - رفع إيصال التحويل

GET  /payment/cash-on-delivery/confirm/{order} - تأكيد الدفع عند الاستلام
```

### Admin Routes (محمية بـ auth + admin)
```
POST /admin/payments/{payment}/approve      - الموافقة على التحويل البنكي
POST /admin/payments/{payment}/reject       - رفض التحويل البنكي
```

### Webhook Routes (عامة - يجب التحقق من التوقيع)
```
POST /webhooks/visa-mada                   - Webhook من Visa/Mada
POST /webhooks/stc-pay                     - Webhook من STC Pay
POST /webhooks/tamara                      - Webhook من Tamara
```

---

## الإعدادات (Configuration)

### ملف `config/payment.php`

```php
'bank' => [
    'name' => env('BANK_NAME', 'البنك الأهلي السعودي'),
    'account_name' => env('BANK_ACCOUNT_NAME', 'تقنيات القمة للتجارة'),
    'iban' => env('BANK_IBAN', 'SA1234567890123456789012'),
    'account_number' => env('BANK_ACCOUNT_NUMBER', '1234567890'),
],
```

### متغيرات البيئة (.env)

```env
# Bank Details
BANK_NAME=البنك الأهلي السعودي
BANK_ACCOUNT_NAME=تقنيات القمة للتجارة
BANK_IBAN=SA1234567890123456789012
BANK_ACCOUNT_NUMBER=1234567890

# Payment Gateways (للإنتاج)
VISA_MADA_API_KEY=your_api_key
VISA_MADA_MERCHANT_ID=your_merchant_id
STC_PAY_API_KEY=your_api_key
TAMARA_API_KEY=your_api_key
```

---

## لوحة تحكم الأدمن

### عرض الطلبات
- Route: `/admin/orders`
- الفلترة حسب:
  - طريقة الدفع
  - حالة الدفع
  - حالة الطلب

### تفاصيل الطلب
- Route: `/admin/orders/{order}`
- عرض معلومات الدفع
- الموافقة/الرفض على التحويل البنكي
- تحديث حالة الطلب

---

## ملاحظات مهمة

### 1. Test Mode
- جميع بوابات الدفع تعمل في وضع Test Mode حالياً
- في الإنتاج، يجب:
  - إضافة API Keys الحقيقية
  - تفعيل التحقق من Webhook Signatures
  - إزالة صفحات المحاكاة

### 2. الأمان
- جميع Routes محمية بـ CSRF
- Webhooks يجب التحقق من التوقيع
- التحقق من ملكية الطلب قبل الوصول

### 3. التوسعة المستقبلية
- يمكن إضافة Apple Pay / Google Pay بسهولة
- يمكن إضافة طرق دفع أخرى بنفس الهيكل

---

## الملفات الرئيسية

### Controllers
- `app/Http/Controllers/PaymentController.php` - Controller رئيسي
- `app/Http/Controllers/Payment/VisaMadaController.php`
- `app/Http/Controllers/Payment/STCPayController.php`
- `app/Http/Controllers/Payment/TamaraController.php`
- `app/Http/Controllers/Payment/BankTransferController.php`
- `app/Http/Controllers/Payment/CashOnDeliveryController.php`
- `app/Http/Controllers/Admin/OrderController.php` - إدارة الطلبات

### Models
- `app/Models/Order.php`
- `app/Models/Payment.php`

### Views
- `resources/views/orders/checkout.blade.php` - صفحة الدفع
- `resources/views/payments/bank-transfer.blade.php` - التحويل البنكي
- `resources/views/payments/visa-mada-simulate.blade.php` - محاكاة Visa/Mada
- `resources/views/payments/stc-pay-simulate.blade.php` - محاكاة STC Pay
- `resources/views/payments/tamara-simulate.blade.php` - محاكاة Tamara
- `resources/views/payments/success.blade.php` - صفحة النجاح
- `resources/views/payments/failure.blade.php` - صفحة الفشل
- `resources/views/admin/orders/index.blade.php` - قائمة الطلبات
- `resources/views/admin/orders/show.blade.php` - تفاصيل الطلب

---

## الاختبار

### اختبار كل طريقة دفع:
1. **Visa/Mada**: اختر Visa/Mada في Checkout → Approve/Decline
2. **STC Pay**: اختر STC Pay → Approve/Decline
3. **Tamara**: اختر Tamara → Approve/Decline
4. **Bank Transfer**: اختر Bank Transfer → ارفع إيصال → موافقة/رفض من الأدمن
5. **Cash on Delivery**: اختر Cash → تأكيد مباشر

---

## الدعم

لأي استفسارات أو مشاكل، يرجى مراجعة:
- Laravel Documentation
- Payment Gateway Documentation (Visa/Mada, STC Pay, Tamara)
