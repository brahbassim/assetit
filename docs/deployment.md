# Deployment

This guide covers deploying AssetIT to production environments.

## Production Checklist

Before deploying, ensure:

- [ ] `APP_ENV=production` in `.env`
- [ ] `APP_DEBUG=false` in `.env`
- [ ] Secure database credentials
- [ ] HTTPS/SSL configured
- [ ] Mail driver configured
- [ ] Queue driver configured

## Quick Deploy (Shared Hosting)

### Step 1: Upload Files

Upload all files to your web root (public_html or htdocs).

### Step 2: Configure .env

Update your `.env` file with production settings:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

### Step 3: Set Permissions

```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

### Step 4: Run Commands

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### Step 5: Point Domain

Point your domain to the `public` folder, or configure Apache:

```apache
RewriteEngine On
RewriteRule ^(.*)$ public/$1 [L]
```

## Deploying with Deployer

### Install Deployer

```bash
composer require deployer/deployer --dev
```

### Create deploy.php

```php
<?php
namespace Deployer;

require 'recipe/laravel.php';

set('repository', 'git@github.com:your-repo/assetit.git');

host('yourdomain.com')
    ->user('username')
    ->set('deploy_path', '/var/www/yourdomain.com')
    ->set('branch', 'main');

after('deploy:success', 'deploy:cleanup');
```

### Deploy

```bash
dep deploy
```

## Docker Deployment

### Dockerfile

Create `Dockerfile` in project root:

```dockerfile
FROM php:8.2-fpm

WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml8-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl acl bcmath

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Build assets
RUN npm install && npm run build

# Cache optimization
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

EXPOSE 9000

CMD ["php-fpm"]
```

### docker-compose.yml

```yaml
version: '3.8'

services:
  app:
    build: .
    ports:
      - "9000:9000"
    volumes:
      - ./storage:/var/www/storage
    depends_on:
      - db
    environment:
      - APP_ENV=production

  db:
    image: mysql:8.0
    environment:
      MYSQL_DATABASE: assetit
      MYSQL_ROOT_PASSWORD: rootpassword
      MYSQL_USER: assetit
      MYSQL_PASSWORD: assetitpassword
    volumes:
      - mysql_data:/var/lib/mysql

  nginx:
    image: nginx:alpine
    ports:
      - "80:80"
    volumes:
      - ./nginx.conf:/etc/nginx/conf.d/default.conf
      - ./storage:/var/www/storage
    depends_on:
      - app

volumes:
  mysql_data:
```

### Build & Run

```bash
docker-compose up -d
```

## Laravel Forge Deployment

### 1. Create Server

1. Sign up at [Laravel Forge](https://forge.laravel.com)
2. Create a new server (DigitalOcean, AWS, etc.)
3. Install PHP, MySQL, Nginx

### 2. Deploy Application

1. Connect GitHub repository
2. Configure environment variables
3. Set up deployment script
4. Deploy

### 3. SSL Configuration

1. Go to Sites → Your Site → SSL
2. Let's Encrypt → Create Certificate
3. Auto-renewal enabled

## AWS Elastic Beanstalk

### ebextensions

Create `.ebextensions/php-memory-limits.config`:

```yaml
option_settings:
  - namespace: aws:elasticbeanstalk:container:php
    option_name: memory
    value: 512
  - namespace: aws:elasticbeanstalk:container:php
    option_name: max_execution_time
    value: 60
```

### Commands

```bash
eb init -p php-8.2 assetit
eb create assetit-staging
eb deploy
```

## Post-Deployment Tasks

### 1. Schedule Cron Job

```bash
crontab -e
```

Add:

```
* * * * * php /path-to-artisan schedule:run >> /dev/null 2>&1
```

### 2. Configure Queue Worker

For processing background jobs:

```bash
# Supervisor configuration
sudo nano /etc/supervisor/conf.d/worker.conf
```

```ini
[program:worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/assetit/artisan queue:work --sleep=3 --tries=3 --max_time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/var/log/worker.log
stopwaitsecs=3600
```

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start worker:*
```

### 3. Monitor Logs

```bash
tail -f /var/log/nginx/error.log
tail -f /var/www/assetit/storage/logs/laravel.log
```

## Troubleshooting

### 500 Internal Server Error

- Check permissions on storage/ and bootstrap/cache/
- Verify `.env` configuration
- Review Laravel logs

### Database Connection Failed

- Verify database credentials
- Check database server is running
- Ensure database exists

### Assets Not Loading

- Run `npm run build`
- Check file ownership
- Verify storage link
