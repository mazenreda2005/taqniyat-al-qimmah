# How to Run on Localhost

## Quick Start

### Step 1: Open Terminal/Command Prompt
Navigate to your project directory:
```powershell
cd "C:\Users\t\Desktop\tecqniat el qema"
```

### Step 2: Start the Server
Run this command:
```bash
php artisan serve
```

### Step 3: Open in Browser
Open your web browser and go to:
```
http://localhost:8000
```

## Alternative: Run on Different Port

If port 8000 is busy, use a different port:
```bash
php artisan serve --port=8001
```

Then access: `http://localhost:8001`

## Alternative: Run on Specific Host and Port

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

## Stop the Server

Press `Ctrl + C` in the terminal where the server is running.

## Access Points

- **Homepage**: http://localhost:8000
- **Admin Panel**: http://localhost:8000/admin/dashboard
- **Login**: http://localhost:8000/login
- **Register**: http://localhost:8000/register

## Default Login Credentials

**Admin:**
- Email: `admin@taqniyat.com`
- Password: `password`

**User:**
- Email: `user@test.com`
- Password: `password`

## Troubleshooting

### Port Already in Use
If you see "Address already in use", use a different port:
```bash
php artisan serve --port=8080
```

### Database Connection Error
Make sure MySQL is running and check your `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=taqniyat_al_qimmah
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Application Key Error
If you see encryption errors, generate a new key:
```bash
php artisan key:generate
```
