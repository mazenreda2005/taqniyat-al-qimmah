# Setup Instructions

## Quick Start Guide

Follow these steps to get the application running:

### 1. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 2. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Database Setup

Edit `.env` file and configure your database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=taqniyat_al_qimmah
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Run Migrations and Seeders

```bash
# Create database tables
php artisan migrate

# Seed sample data
php artisan db:seed
```

### 5. Storage Link

```bash
# Create symbolic link for storage
php artisan storage:link
```

### 6. Build Assets

```bash
# Build frontend assets
npm run build

# Or for development with hot reload
npm run dev
```

### 7. Start Server

```bash
# Start Laravel development server
php artisan serve
```

Visit: `http://localhost:8000`

## Default Login Credentials

After running seeders:

**Admin Account:**
- Email: `admin@taqniyat.com`
- Password: `password`

**Test User Account:**
- Email: `user@test.com`
- Password: `password`

## Features Overview

### Public Features
- Browse products without login
- Search and filter products
- View product details
- Categories navigation

### User Features (Requires Login)
- Add products to cart
- Checkout and place orders
- View order history
- Request maintenance services
- Manage profile

### Admin Features
- Manage products (CRUD)
- Manage categories (CRUD)
- View and update orders
- Manage maintenance requests
- View dashboard statistics

## Troubleshooting

### Storage Link Issues
If images don't display, make sure you've run:
```bash
php artisan storage:link
```

### Permission Issues
On Linux/Mac, you may need to set permissions:
```bash
chmod -R 775 storage bootstrap/cache
```

### Database Connection Issues
- Verify database credentials in `.env`
- Make sure MySQL is running
- Check database exists

### Translation Issues
- Default locale is Arabic (`ar`)
- Translations are in `lang/ar/messages.php`
- To change locale, edit `config/app.php` or `.env`

## Production Deployment

1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false` in `.env`
3. Run `php artisan config:cache`
4. Run `php artisan route:cache`
5. Run `php artisan view:cache`
6. Build assets: `npm run build`
7. Set proper file permissions
8. Configure web server (Apache/Nginx)

## Support

For issues or questions, please refer to the main README.md file.
