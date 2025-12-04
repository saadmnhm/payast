# 🚀 Server Setup via cPanel (No SSH Required)

## Method 1: Using cPanel File Manager

### Step 1: Access cPanel
1. Go to: `https://prod.blinkagency.ma:2083` or your cPanel URL
2. Login with credentials: `u583576698.blinkprod`

### Step 2: Upload Files
Files are automatically uploaded by GitHub Actions to `/home/u583576698/domains/pyasat/`

### Step 3: Create .env File
1. Navigate to `/home/u583576698/domains/pyasat/` in File Manager
2. Click **+ File** button
3. Create file named `.env`
4. Right-click `.env` → **Edit**
5. Copy contents from `.env.production` and update:

```env
APP_NAME=Pyassat
APP_ENV=production
APP_KEY=base64:YOUR_KEY_HERE
APP_DEBUG=false
APP_URL=https://pyasat.blinkagency.ma

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u583576698_pyasat
DB_USERNAME=u583576698_pyasat
DB_PASSWORD=YOUR_DATABASE_PASSWORD

# Get APP_KEY by running this in Terminal (Step 4)
```

6. Click **Save Changes**

### Step 4: Run Commands via cPanel Terminal

1. In cPanel, find **Terminal** icon
2. Click to open web-based terminal
3. Run these commands:

```bash
# Navigate to project
cd domains/pyasat

# Generate application key
php artisan key:generate --force

# Create directories
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache
mkdir -p storage/logs
mkdir -p storage/app/public
mkdir -p bootstrap/cache
mkdir -p public/uploads/avatars
mkdir -p public/uploads/pieces
mkdir -p public/uploads/brands
mkdir -p public/uploads/categories

# Create storage link
php artisan storage:link

# Run migrations
php artisan migrate --force

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Fix permissions
chmod -R 755 storage bootstrap/cache
```

### Step 5: Set File Permissions via cPanel

1. In File Manager, select `storage` folder
2. Click **Permissions** at top
3. Set to `755` (rwxr-xr-x)
4. Check "Recurse into subdirectories"
5. Click **Change Permissions**

Repeat for:
- `bootstrap/cache` → 755
- `public/uploads` → 777

### Step 6: Verify Installation

Visit: `https://pyasat.blinkagency.ma`

---

## Method 2: Using phpMyAdmin for Database

### Create Database:
1. In cPanel → **MySQL Databases**
2. Create database: `u583576698_pyasat`
3. Create user: `u583576698_pyasat`
4. Set password and save
5. Add user to database with ALL PRIVILEGES

### Import Database (if you have SQL file):
1. cPanel → **phpMyAdmin**
2. Select database `u583576698_pyasat`
3. Click **Import** tab
4. Choose your `.sql` file
5. Click **Go**

---

## Method 3: Using FileZilla/WinSCP (Manual FTP)

If GitHub Actions fails, manually upload:

### Using WinSCP:
```
Host: prod.blinkagency.ma
Port: 21
Protocol: FTP
Username: u583576698.blinkprod
Password: V*3iGnwlw~G7H^2w
Remote directory: /pyasat/
```

### Files to Upload:
- ✅ All files except: `.git`, `node_modules`, `tests`, `.env`
- ✅ Include: `vendor/` (composer dependencies)
- ✅ Include: `public/` (all assets)

### After Upload:
Use cPanel Terminal (Step 4 above) to run Laravel commands

---

## Common cPanel Locations

| Item | Path |
|------|------|
| Project Root | `/home/u583576698/domains/pyasat/` |
| Public HTML | `/home/u583576698/domains/pyasat/public/` |
| Error Logs | `/home/u583576698/domains/pyasat/storage/logs/` |
| Apache Logs | cPanel → **Error Log** |

---

## Troubleshooting in cPanel

### Issue: White screen / 500 Error

**Solution via Terminal:**
```bash
cd domains/pyasat
php artisan cache:clear
php artisan config:clear
php artisan view:clear
chmod -R 755 storage bootstrap/cache
```

### Issue: Can't find Terminal in cPanel

**Alternative:** Use **Cron Jobs** to run commands:
1. cPanel → **Cron Jobs**
2. Add command:
```bash
cd /home/u583576698/domains/pyasat && php artisan key:generate --force
```
3. Set to run once, then delete

### Issue: Permission Denied

**Solution via File Manager:**
1. Select folder
2. Click **Permissions**
3. Set to 755 or 777 as needed
4. Check "Recurse into subdirectories"

### Issue: Routes not working

**Check .htaccess in public folder:**
```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

---

## Domain Setup

### Point Domain to Public Directory:

1. cPanel → **Domains**
2. Find `pyasat.blinkagency.ma`
3. Click **Manage**
4. Set **Document Root** to: `/home/u583576698/domains/pyasat/public`
5. Click **Save**

---

## Automatic Deployment Workflow

With GitHub Actions configured:

1. **Local:** Make changes and push
```bash
git add .
git commit -m "your changes"
git push origin main
```

2. **GitHub Actions:** Automatically uploads to FTP

3. **cPanel Terminal:** Run these after each deployment
```bash
cd domains/pyasat
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Maintenance via cPanel

### View Error Logs:
```bash
cd domains/pyasat
tail -n 50 storage/logs/laravel.log
```

### Clear All Caches:
```bash
cd domains/pyasat
php artisan optimize:clear
```

### Backup Database:
1. cPanel → **phpMyAdmin**
2. Select database
3. Click **Export**
4. Choose format: SQL
5. Click **Go**

---

## Quick Command Reference

Copy/paste these into cPanel Terminal:

```bash
# Full setup
cd domains/pyasat && php artisan key:generate --force && php artisan storage:link && php artisan migrate --force && php artisan optimize && chmod -R 755 storage bootstrap/cache

# After each deployment
cd domains/pyasat && php artisan migrate --force && php artisan optimize

# Clear everything
cd domains/pyasat && php artisan optimize:clear

# View logs
cd domains/pyasat && tail -n 50 storage/logs/laravel.log
```

---

## Support

- **cPanel URL**: https://prod.blinkagency.ma:2083
- **FTP Host**: prod.blinkagency.ma:21
- **Username**: u583576698.blinkprod
- **Database**: u583576698_pyasat

**No SSH access needed - everything can be done via cPanel!** ✅
