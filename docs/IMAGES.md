# Images Guide — دليل الصور

How photos enter this repository, and where each kind belongs.

## 1. README screenshots — صور الواجهة

Drop screenshots of the running site here, using exactly these names:

| File | Page to capture | الصفحة |
|------|-----------------|--------|
| `docs/screenshots/01-home.jpg` | Landing page | الصفحة الرئيسية |
| `docs/screenshots/02-products.jpg` | Product listing with categories | قائمة المنتجات |
| `docs/screenshots/03-product-details.jpg` | Single product page | تفاصيل المنتج |
| `docs/screenshots/04-cart.jpg` | Shopping cart | سلة الشراء |
| `docs/screenshots/05-checkout.jpg` | Checkout / payment methods | الدفع |
| `docs/screenshots/06-maintenance.jpg` | Maintenance request form | طلب الصيانة |
| `docs/screenshots/07-admin-dashboard.jpg` | Admin dashboard with stats | لوحة التحكم |
| `docs/screenshots/08-admin-products.jpg` | Admin product management | إدارة المنتجات |

Capture tips:
- Browser at ~1440px wide, browser chrome excluded if possible.
- Log out of any personal accounts first — screenshots land in a public repo.
- JPG or PNG, and keep each under ~500 KB so the repo stays light.

Once the files are in place, the Screenshots section of the main `README.md`
displays them automatically.

## 2. Product and category photos — صور المنتجات والتصنيفات

**Important:** photos uploaded through the admin panel are stored in
`storage/app/public` and served via the `public/storage` symlink, which is
git-ignored. Those photos never reach GitHub. Anything that should ship with
the repository belongs in `public/images/`.

- Product photos → `public/images/products/<slug>.jpg`
- Category photos → `public/images/<category>.jpg`

Reference them with a **leading slash** so `Product::getFirstImage()` returns
the path as-is instead of prefixing `storage/`:

```php
'images' => ['/images/products/laptop-hp.jpg'],
```

Categories accept either form, since `Category::getImageUrl()` handles
`images/...` and `../images/...` as well:

```php
'image' => 'images/new-devices.jpg',
```

Guidelines:
- Square-ish, at least 800×800, JPG (or WebP) for photos, SVG for icons.
- Only use photos you own or that are licensed for commercial use — this
  repository is public.
- Keep each file under ~300 KB.
