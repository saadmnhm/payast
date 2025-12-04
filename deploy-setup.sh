#!/bin/bash

###############################################################################
# Laravel Post-Deployment Setup Script
# Run this script on the server after first deployment
###############################################################################

echo "🚀 Starting Laravel deployment setup..."

# Navigate to project directory
cd /home/u583576698/domains/pyasat || exit 1

# 1. Set correct permissions
echo "📁 Setting file permissions..."
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod -R 775 storage bootstrap/cache
chmod -R 777 storage/logs
chmod -R 777 public/uploads

# 2. Set correct ownership (adjust user/group if needed)
echo "👤 Setting file ownership..."
chown -R u583576698:u583576698 .

# 3. Create .env file if not exists
if [ ! -f .env ]; then
    echo "📝 Creating .env file..."
    cp .env.example .env
    echo "⚠️  Please update .env with production credentials!"
fi

# 4. Generate application key if not set
if ! grep -q "APP_KEY=base64:" .env; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force
fi

# 5. Create storage directories
echo "📦 Creating storage directories..."
mkdir -p storage/framework/{sessions,views,cache}
mkdir -p storage/logs
mkdir -p storage/app/public
mkdir -p bootstrap/cache
mkdir -p public/uploads/{avatars,pieces,brands,categories}

# 6. Create storage link
echo "🔗 Creating storage symlink..."
php artisan storage:link

# 7. Cache configuration files
echo "⚡ Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 8. Run database migrations
echo "🗄️  Running database migrations..."
php artisan migrate --force

# 9. Clear all caches
echo "🧹 Clearing caches..."
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear

# 10. Optimize for production
echo "🎯 Optimizing for production..."
php artisan optimize
composer dump-autoload --optimize

# 11. Set final permissions
echo "🔒 Setting final permissions..."
chmod -R 775 storage bootstrap/cache
chmod 644 .env

echo "✅ Deployment setup completed successfully!"
echo ""
echo "📋 Next steps:"
echo "1. Update .env with production database credentials"
echo "2. Update .env with production APP_URL"
echo "3. Set APP_ENV=production and APP_DEBUG=false"
echo "4. Configure email settings in .env"
echo "5. Test the application"
