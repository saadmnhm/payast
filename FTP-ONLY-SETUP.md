# 🚀 FTP-Only Deployment Guide

## ⚠️ Important: FTP-Only Access

Your server only has FTP access (no SSH, no cPanel terminal). This means:
- ✅ GitHub Actions automatically uploads files via FTP
- ❌ Cannot run Laravel commands on server
- ✅ Must prepare everything locally before upload

---

## Initial Setup Strategy

Since you can't run commands on the server, you need to:

1. **Prepare everything locally**
2. **Upload pre-configured files via FTP**
3. **Use web-based tools** for database setup

---

## Step 1: Prepare Locally

### Generate Application Key
```powershell
# On local machine
php artisan key:generate
```

Copy the generated key from your local `.env` file.

### Create Production .env File

Create `.env` file locally with production settings:

```env
APP_NAME=Pyassat
APP_ENV=production
APP_KEY=base64:YOUR_KEY_FROM_LOCAL_ENV
APP_DEBUG=false
APP_URL=https://pyasat.blinkagency.ma

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u583576698_pyasat
DB_USERNAME=u583576698_pyasat
DB_PASSWORD=YOUR_DATABASE_PASSWORD

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=public
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```

### Create Required Directories Locally

```powershell
# Create all necessary directories
New-Item -ItemType Directory -Force -Path "storage\framework\sessions"
New-Item -ItemType Directory -Force -Path "storage\framework\views"
New-Item -ItemType Directory -Force -Path "storage\framework\cache"
New-Item -ItemType Directory -Force -Path "storage\logs"
New-Item -ItemType Directory -Force -Path "storage\app\public"
New-Item -ItemType Directory -Force -Path "bootstrap\cache"
New-Item -ItemType Directory -Force -Path "public\uploads\avatars"
New-Item -ItemType Directory -Force -Path "public\uploads\pieces"
New-Item -ItemType Directory -Force -Path "public\uploads\brands"
New-Item -ItemType Directory -Force -Path "public\uploads\categories"
```

### Create Empty Files in Directories

```powershell
# Git ignores empty directories, so create .gitkeep files
New-Item -ItemType File -Force -Path "storage\framework\sessions\.gitkeep"
New-Item -ItemType File -Force -Path "storage\framework\views\.gitkeep"
New-Item -ItemType File -Force -Path "storage\framework\cache\.gitkeep"
New-Item -ItemType File -Force -Path "storage\logs\.gitkeep"
New-Item -ItemType File -Force -Path "storage\app\public\.gitkeep"
New-Item -ItemType File -Force -Path "bootstrap\cache\.gitkeep"
```

### Cache Configuration Locally

```powershell
# Cache everything before upload
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**Important:** Cached files are environment-specific, so you may need to clear them after upload.

---

## Step 2: Manual FTP Upload

### Using FileZilla or WinSCP

**Connection Details:**
```
Protocol: FTP
Host: prod.blinkagency.ma
Port: 21
Username: u583576698.blinkprod
Password: V*3iGnwlw~G7H^2w
Remote directory: /pyasat/
```

### Upload These Files/Folders:

✅ **Upload:**
- `app/`
- `bootstrap/`
- `config/`
- `database/`
- `public/`
- `resources/`
- `routes/`
- `storage/` (with all subdirectories)
- `vendor/` (composer dependencies)
- `.env` (production version)
- `artisan`
- `composer.json`
- `composer.lock`

❌ **DON'T Upload:**
- `.git/`
- `node_modules/`
- `tests/`
- `.env.example`
- `abdo (4).sql`

### File Permissions (Set via FTP Client)

Right-click folders in FTP client → Properties/Permissions:

| Path | Permissions | Numeric |
|------|-------------|---------|
| `storage/` | rwxrwxr-x | 775 |
| `storage/logs/` | rwxrwxrwx | 777 |
| `public/uploads/` | rwxrwxrwx | 777 |
| `bootstrap/cache/` | rwxrwxr-x | 775 |
| `.env` | rw-r--r-- | 644 |

---

## Step 3: Database Setup

### Option A: phpMyAdmin (if available)

1. Try to access: `https://prod.blinkagency.ma/phpmyadmin`
2. Login with database credentials
3. Create database: `u583576698_pyasat`
4. Import your SQL file from local: `abdo (4).sql`

### Option B: MySQL Workbench (Remote Connection)

If remote MySQL is enabled:
```
Host: prod.blinkagency.ma
Port: 3306
Username: u583576698_pyasat
Password: [your password]
Database: u583576698_pyasat
```

### Option C: Contact Hosting Support

Ask them to:
1. Create database: `u583576698_pyasat`
2. Create user: `u583576698_pyasat`
3. Grant all privileges
4. Import your SQL file

---

## Step 4: Workarounds for Missing Commands

Since you can't run `php artisan` commands on the server:

### Storage Link Alternative

Instead of `php artisan storage:link`, manually create symlink:

**Via FTP:**
1. Upload a PHP file `create-symlink.php` to `/public/`:

```php
<?php
// create-symlink.php
$target = '../storage/app/public';
$link = __DIR__ . '/storage';

if (!file_exists($link)) {
    symlink($target, $link);
    echo "Storage link created successfully!";
} else {
    echo "Storage link already exists!";
}
?>
```

2. Visit: `https://pyasat.blinkagency.ma/create-symlink.php`
3. Delete the file after running

### Clear Cache Alternative

Create `clear-cache.php` in `/public/`:

```php
<?php
// clear-cache.php - DELETE THIS FILE AFTER USE!

// Clear config cache
$configCache = __DIR__ . '/../bootstrap/cache/config.php';
if (file_exists($configCache)) {
    unlink($configCache);
    echo "Config cache cleared<br>";
}

// Clear route cache
$routeCache = __DIR__ . '/../bootstrap/cache/routes-v7.php';
if (file_exists($routeCache)) {
    unlink($routeCache);
    echo "Route cache cleared<br>";
}

// Clear view cache
$viewPath = __DIR__ . '/../storage/framework/views';
$files = glob($viewPath . '/*');
foreach ($files as $file) {
    if (is_file($file)) {
        unlink($file);
    }
}
echo "View cache cleared<br>";

echo "<br>✅ All caches cleared! DELETE THIS FILE NOW!";
?>
```

Visit: `https://pyasat.blinkagency.ma/clear-cache.php`

### Run Migrations Alternative

Create `run-migrations.php` in `/public/`:

```php
<?php
// run-migrations.php - DELETE THIS FILE AFTER USE!

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$status = $kernel->call('migrate', ['--force' => true]);

echo "Migrations executed with status: " . $status;
echo "<br>✅ DELETE THIS FILE NOW!";
?>
```

Visit: `https://pyasat.blinkagency.ma/run-migrations.php`

---

## Step 5: GitHub Actions Auto-Deployment

Your GitHub Actions is already configured for FTP deployment.

**Workflow:**
```powershell
# 1. Work locally
# 2. Test locally
php artisan serve

# 3. Prepare for production
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 4. Commit and push
git add .
git commit -m "your changes"
git push origin main

# 5. GitHub Actions automatically uploads via FTP
```

**After each deployment, use helper scripts above if needed.**

---

## Important Limitations

❌ **Cannot run on server:**
- `php artisan migrate`
- `php artisan cache:clear`
- `php artisan storage:link`
- `php artisan key:generate`
- `composer install`

✅ **Must do locally:**
- Install dependencies: `composer install`
- Generate key: `php artisan key:generate`
- Test everything: `php artisan serve`
- Then upload via FTP

✅ **Workaround with PHP files:**
- Use helper scripts (see Step 4)
- Access via browser
- Delete immediately after use

---

## Recommended Workflow

### Initial Setup:
1. ✅ Prepare everything locally
2. ✅ Upload via GitHub Actions or manual FTP
3. ✅ Use helper PHP scripts for one-time setup
4. ✅ Import database via phpMyAdmin
5. ✅ Test the site

### Regular Updates:
1. ✅ Make changes locally
2. ✅ Test locally: `php artisan serve`
3. ✅ Push to GitHub: `git push origin main`
4. ✅ GitHub Actions uploads automatically
5. ✅ Test production site

---

## Troubleshooting

### Issue: White screen / 500 Error

**Cause:** Permission issues or missing `.env`

**Fix:**
1. Check `.env` file exists and has correct permissions (644)
2. Check `storage/` has 775 permissions
3. Upload `clear-cache.php` and run it

### Issue: Database connection error

**Fix:**
1. Verify database credentials in `.env`
2. Test database connection from another tool
3. Contact hosting support

### Issue: Routes not working

**Fix:**
1. Check `.htaccess` exists in `/public/`
2. Verify document root points to `/pyasat/public/`
3. Use `clear-cache.php` to clear route cache

### Issue: Images/uploads not showing

**Fix:**
1. Run `create-symlink.php`
2. Check `public/uploads/` has 777 permissions
3. Upload test image via FTP to verify

---

## Database Migration Strategy

Since you can't run `php artisan migrate`:

### Option 1: Export from Local
```powershell
# Export local database
php artisan db:export
# Or use phpMyAdmin/MySQL Workbench
```

Upload SQL file via phpMyAdmin on production.

### Option 2: Use Migration Script
Use `run-migrations.php` (Step 4)

### Option 3: Manual SQL
Export each migration as SQL and run manually.

---

## Security Reminders

⚠️ **Delete helper PHP files after use!**
- `create-symlink.php`
- `clear-cache.php`
- `run-migrations.php`

These files expose sensitive operations!

✅ **Verify production settings:**
- `APP_ENV=production`
- `APP_DEBUG=false`
- Strong `APP_KEY`
- Secure database password

---

## Support

Since you have FTP-only access:
- All changes must be prepared locally
- Use GitHub Actions for automatic FTP deployment
- Use helper PHP scripts for server-side tasks
- Contact hosting support for advanced needs

**GitHub Actions handles deployment automatically - just push to main!** 🚀
