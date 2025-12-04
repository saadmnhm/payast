# 🚀 Deployment Guide

## ⚠️ Important: No SSH Access

Your server does not allow SSH (port 22 blocked). Use **cPanel** instead!

👉 **See [CPANEL-SETUP.md](CPANEL-SETUP.md) for step-by-step instructions**

---

## Quick Start via cPanel

1. **Access cPanel**: https://prod.blinkagency.ma:2083
2. **Open Terminal** (if available) or use **File Manager**
3. **Navigate to project**: `cd domains/pyasat`
4. **Run setup commands** (see CPANEL-SETUP.md)

---

## First-Time Server Setup

```bash
nano .env
```

Update these critical values:
- `APP_KEY` - Generate with `php artisan key:generate`
- `DB_DATABASE` - Your database name
- `DB_USERNAME` - Your database username
- `DB_PASSWORD` - Your database password
- `APP_URL` - Your domain URL
- `APP_ENV=production`
- `APP_DEBUG=false`

### 5. Test the application

Visit: https://pyasat.blinkagency.ma

---

## File Structure Requirements

```
/home/u583576698/domains/pyasat/
├── app/
├── bootstrap/
│   └── cache/          (775 writable)
├── config/
├── database/
├── public/             (Document root)
│   ├── index.php
│   ├── .htaccess
│   ├── assets/
│   └── uploads/        (777 writable)
├── resources/
├── routes/
├── storage/            (775 writable)
│   ├── app/
│   │   └── public/
│   ├── framework/
│   │   ├── cache/
│   │   ├── sessions/
│   │   └── views/
│   └── logs/           (777 writable)
├── vendor/
├── .env                (644 secure)
└── artisan
```

---

## Required Permissions

### Directories (755)
```bash
find . -type d -exec chmod 755 {} \;
```

### Files (644)
```bash
find . -type f -exec chmod 644 {} \;
```

### Writable directories (775)
```bash
chmod -R 775 storage bootstrap/cache
```

### Logs directory (777)
```bash
chmod -R 777 storage/logs
```

### Uploads directory (777)
```bash
chmod -R 777 public/uploads
```

### Secure .env (644)
```bash
chmod 644 .env
```

---

## Server Requirements

### PHP Extensions
- ✅ PHP 8.2 or higher
- ✅ BCMath
- ✅ Ctype
- ✅ Fileinfo
- ✅ JSON
- ✅ Mbstring
- ✅ OpenSSL
- ✅ PDO
- ✅ PDO_MySQL
- ✅ Tokenizer
- ✅ XML
- ✅ GD or Imagick

### Check PHP version
```bash
php -v
```

### Check installed extensions
```bash
php -m
```

---

## Database Setup

### 1. Create database via cPanel
- Database name: `u583576698_pyasat`
- Database user: `u583576698_pyasat`
- Grant all privileges

### 2. Import initial database (if needed)
```bash
mysql -u u583576698_pyasat -p u583576698_pyasat < database.sql
```

### 3. Run migrations
```bash
php artisan migrate --force
```

### 4. Seed database (optional)
```bash
php artisan db:seed --force
```

---

## Apache/Nginx Configuration

### Apache (.htaccess in public/)

Already included in Laravel's public/.htaccess:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

### Document Root
Point to: `/home/u583576698/domains/pyasat/public`

---

## Troubleshooting

### Issue: 500 Internal Server Error

**Solution:**
```bash
chmod -R 775 storage bootstrap/cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Issue: Storage link not working

**Solution:**
```bash
php artisan storage:link
```

### Issue: Permission denied errors

**Solution:**
```bash
chown -R u583576698:u583576698 .
chmod -R 775 storage bootstrap/cache
```

### Issue: Class not found errors

**Solution:**
```bash
composer dump-autoload --optimize
php artisan optimize
```

### Issue: Routes not working

**Solution:**
```bash
php artisan route:clear
php artisan route:cache
```

### Issue: Views not rendering

**Solution:**
```bash
php artisan view:clear
chmod -R 775 storage/framework/views
```

---

## Maintenance Commands

### Clear all caches
```bash
php artisan optimize:clear
```

### Cache everything for production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### Check application status
```bash
php artisan about
```

### View logs
```bash
tail -f storage/logs/laravel.log
```

---

## Continuous Deployment Workflow

### Automatic deployment (GitHub Actions)

Every push to `main` branch automatically:
1. Installs dependencies
2. Creates required directories
3. Uploads to FTP server

### Manual deployment steps

```bash
# On local machine
git add .
git commit -m "your changes"
git push origin main

# On server (after GitHub Actions completes)
cd /home/u583576698/domains/pyasat
php artisan migrate --force
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Security Checklist

- ✅ Set `APP_ENV=production`
- ✅ Set `APP_DEBUG=false`
- ✅ Generate unique `APP_KEY`
- ✅ Secure `.env` with chmod 644
- ✅ Never commit `.env` to Git
- ✅ Use HTTPS (SSL certificate)
- ✅ Keep dependencies updated
- ✅ Regular database backups
- ✅ Monitor error logs
- ✅ Use strong database passwords

---

## Backup Strategy

### Database backup
```bash
mysqldump -u u583576698_pyasat -p u583576698_pyasat > backup_$(date +%Y%m%d).sql
```

### Files backup
```bash
tar -czf backup_files_$(date +%Y%m%d).tar.gz /home/u583576698/domains/pyasat
```

### Automate backups (crontab)
```bash
0 2 * * * /path/to/backup-script.sh
```

---

## Performance Optimization

### Enable OPcache (php.ini)
```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=10000
opcache.revalidate_freq=2
```

### Cache configuration
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Optimize Composer autoloader
```bash
composer dump-autoload --optimize --classmap-authoritative
```

---

## Support & Monitoring

### Enable error logging
```env
LOG_LEVEL=error
LOG_CHANNEL=daily
```

### Monitor disk space
```bash
df -h
```

### Monitor processes
```bash
top
htop
```

### Check server logs
```bash
tail -f /var/log/apache2/error.log  # Apache
tail -f /var/log/nginx/error.log    # Nginx
```

---

## Contact & Resources

- **Production URL**: https://pyasat.blinkagency.ma
- **GitHub Repository**: https://github.com/saadmnhm/payast
- **Laravel Docs**: https://laravel.com/docs/11.x
- **Server Provider**: Blinkagency

---

**Last Updated**: December 4, 2025
