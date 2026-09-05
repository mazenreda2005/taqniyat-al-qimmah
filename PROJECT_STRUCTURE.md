# Project Structure

## Directory Overview

```
taqniyat_al_qimmah/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/              # Authentication controllers
│   │   │   ├── Admin/             # Admin panel controllers
│   │   │   └── [Public Controllers] # Home, Product, Cart, Order, etc.
│   │   ├── Middleware/            # Custom middleware
│   │   └── Kernel.php            # HTTP Kernel
│   ├── Models/                    # Eloquent models
│   └── Providers/                # Service providers
├── bootstrap/
│   └── app.php                   # Application bootstrap
├── config/                        # Configuration files
├── database/
│   ├── migrations/               # Database migrations
│   └── seeders/                  # Database seeders
├── lang/
│   └── ar/                       # Arabic translations
│       └── messages.php
├── public/                       # Public assets
├── resources/
│   ├── css/                      # Stylesheets
│   ├── js/                       # JavaScript
│   └── views/                    # Blade templates
│       ├── layouts/              # Layout templates
│       ├── auth/                 # Authentication views
│       ├── admin/                # Admin panel views
│       ├── products/             # Product views
│       ├── cart/                 # Cart views
│       ├── orders/               # Order views
│       ├── maintenance/          # Maintenance views
│       └── profile/              # Profile views
├── routes/
│   ├── web.php                   # Web routes
│   └── api.php                   # API routes
└── storage/                       # Storage (created after setup)
```

## Key Files

### Models
- `User.php` - User model with admin role support
- `Category.php` - Product categories
- `Product.php` - Products with bilingual support
- `CartItem.php` - Shopping cart items
- `Order.php` - Orders
- `OrderItem.php` - Order line items
- `MaintenanceRequest.php` - Maintenance service requests

### Controllers
- `HomeController.php` - Landing page
- `ProductController.php` - Product browsing
- `CartController.php` - Shopping cart management
- `OrderController.php` - Order processing
- `MaintenanceController.php` - Maintenance requests
- `ProfileController.php` - User profile
- `Admin/*` - Admin panel controllers

### Routes
All routes are defined in `routes/web.php`:
- Public routes (home, products)
- Auth routes (login, register, logout)
- User routes (cart, orders, profile, maintenance)
- Admin routes (dashboard, products, categories, orders, maintenance)

### Views
- Responsive Bootstrap 5 design
- RTL support for Arabic
- Bilingual content (Arabic/English)
- Admin panel with full CRUD operations

## Database Schema

### Tables
1. `users` - User accounts (with role: user/admin)
2. `categories` - Product categories
3. `products` - Products with images and stock
4. `cart_items` - Shopping cart
5. `orders` - Customer orders
6. `order_items` - Order line items
7. `maintenance_requests` - Maintenance service requests
8. `sessions` - Session storage
9. `password_reset_tokens` - Password resets
10. `failed_jobs` - Failed queue jobs
11. `personal_access_tokens` - API tokens

## Features Implementation

### Authentication
- Custom authentication (not Breeze, but similar structure)
- Login/Register/Logout
- Password reset support
- Role-based access (user/admin)

### Product Management
- Categories with images
- Products with multiple images
- Stock management
- New/Used condition
- Bilingual names and descriptions

### Shopping Cart
- Add to cart
- Update quantities
- Remove items
- Cart persistence (database)

### Orders
- Checkout process
- Order tracking
- Status management
- Order history

### Maintenance Service
- Request submission
- Status tracking
- Admin management
- Cost estimation

### Admin Panel
- Dashboard with statistics
- Product CRUD
- Category CRUD
- Order management
- Maintenance request management

## Language Support

- Default: Arabic (ar)
- Fallback: English (en)
- RTL layout support
- Translations in `lang/ar/messages.php`
- Use `__('key')` in Blade templates

## Security Features

- CSRF protection
- Password hashing
- Role-based authorization
- Input validation
- SQL injection protection (Eloquent ORM)

## Responsive Design

- Bootstrap 5 framework
- Mobile-first approach
- RTL/LTR support
- Modern UI/UX
