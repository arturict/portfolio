# Deployment Guide

This guide covers various deployment options for the Portfolio application.

## 🚀 Deployment Options

### 1. Docker Deployment (Recommended)

#### Quick Start with Docker Compose

```bash
# Clone and navigate to project
git clone https://github.com/arturict/portfolio.git
cd portfolio

# Start the application
docker-compose up --build

# Access at http://localhost:8080
```

#### Production Docker Deployment

1. **Build production image**
   ```bash
   docker build -t portfolio-app:latest .
   ```

2. **Run with environment variables**
   ```bash
   docker run -d \
     --name portfolio-app \
     -p 8080:80 \
     -e APP_ENV=production \
     -e APP_DEBUG=false \
     -e APP_KEY=base64:your-32-character-secret-key \
     -e DB_CONNECTION=sqlite \
     -e DB_DATABASE=/var/www/database/database.sqlite \
     -v ./data:/var/www/database \
     -v ./storage:/var/www/storage \
     --restart unless-stopped \
     portfolio-app:latest
   ```

3. **With external database**
   ```bash
   docker run -d \
     --name portfolio-app \
     -p 8080:80 \
     -e APP_ENV=production \
     -e APP_DEBUG=false \
     -e APP_KEY=base64:your-secret-key \
     -e DB_CONNECTION=mysql \
     -e DB_HOST=your-db-host \
     -e DB_PORT=3306 \
     -e DB_DATABASE=portfolio \
     -e DB_USERNAME=portfolio_user \
     -e DB_PASSWORD=your-password \
     portfolio-app:latest
   ```

### 2. Traditional Server Deployment

#### Prerequisites

- Linux server (Ubuntu 20.04+ recommended)
- PHP 8.2+ with extensions: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML
- Composer
- Node.js 18+
- Web server (Apache/Nginx)
- Database (MySQL/PostgreSQL/SQLite)

#### Step-by-Step Deployment

1. **Prepare the server**
   ```bash
   # Update system
   sudo apt update && sudo apt upgrade -y
   
   # Install PHP and extensions
   sudo apt install php8.2 php8.2-fpm php8.2-mysql php8.2-xml php8.2-curl php8.2-mbstring php8.2-zip php8.2-bcmath php8.2-gd php8.2-sqlite3
   
   # Install Composer
   curl -sS https://getcomposer.org/installer | php
   sudo mv composer.phar /usr/local/bin/composer
   
   # Install Node.js
   curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
   sudo apt install -y nodejs
   ```

2. **Deploy application**
   ```bash
   # Clone repository
   cd /var/www
   sudo git clone https://github.com/arturict/portfolio.git
   sudo chown -R www-data:www-data portfolio
   cd portfolio
   
   # Install backend dependencies
   cd backend
   composer install --no-dev --optimize-autoloader
   
   # Install frontend dependencies and build
   cd ../frontend
   npm ci --only=production
   npm run build
   
   # Copy built assets to Laravel public directory
   cp -r dist/* ../backend/public/frontend/
   ```

3. **Configure environment**
   ```bash
   cd /var/www/portfolio/backend
   
   # Copy environment file
   cp .env.example .env
   
   # Generate application key
   php artisan key:generate
   
   # Configure database
   nano .env  # Edit database settings
   
   # Run migrations
   php artisan migrate --force
   php artisan db:seed --force
   
   # Optimize Laravel
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   
   # Set permissions
   sudo chown -R www-data:www-data /var/www/portfolio
   sudo chmod -R 755 /var/www/portfolio/backend/storage
   sudo chmod -R 755 /var/www/portfolio/backend/bootstrap/cache
   ```

### 3. Cloud Platform Deployment

#### Heroku Deployment

1. **Prepare for Heroku**
   ```bash
   # Create Procfile in project root
   echo "web: cd backend && php artisan serve --host=0.0.0.0 --port=\$PORT" > Procfile
   
   # Create package.json in root for build process
   cat > package.json << EOF
   {
     "name": "portfolio-app",
     "scripts": {
       "heroku-postbuild": "cd frontend && npm install && npm run build && cp -r dist/* ../backend/public/frontend/"
     }
   }
   EOF
   ```

2. **Deploy to Heroku**
   ```bash
   # Install Heroku CLI and login
   heroku login
   
   # Create app
   heroku create your-portfolio-app
   
   # Add buildpacks
   heroku buildpacks:add heroku/nodejs
   heroku buildpacks:add heroku/php
   
   # Set environment variables
   heroku config:set APP_KEY=$(php artisan --no-ansi key:generate --show)
   heroku config:set APP_ENV=production
   heroku config:set APP_DEBUG=false
   
   # Deploy
   git push heroku main
   
   # Run migrations
   heroku run php artisan migrate --force
   ```

#### DigitalOcean App Platform

1. **Create app.yaml**
   ```yaml
   name: portfolio-app
   services:
   - name: web
     source_dir: /
     github:
       repo: your-username/portfolio
       branch: main
     run_command: |
       cd frontend && npm install && npm run build
       cd ../backend && composer install --no-dev
       php artisan config:cache && php artisan route:cache
       php artisan serve --host=0.0.0.0 --port=$PORT
     environment_slug: php
     instance_count: 1
     instance_size_slug: basic-xxs
     envs:
     - key: APP_ENV
       value: production
     - key: APP_DEBUG
       value: false
     - key: APP_KEY
       value: YOUR_APP_KEY
   ```

#### AWS Deployment (EC2 + RDS)

1. **Launch EC2 instance**
   - Choose Ubuntu 20.04 LTS
   - Configure security groups (HTTP/HTTPS)
   - Launch with key pair

2. **Setup RDS database**
   - Create MySQL/PostgreSQL instance
   - Configure security groups
   - Note connection details

3. **Deploy application**
   ```bash
   # SSH to EC2 instance
   ssh -i your-key.pem ubuntu@your-ec2-ip
   
   # Follow traditional server deployment steps
   # Configure .env with RDS database details
   ```

### 4. Web Server Configuration

#### Nginx Configuration

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/portfolio/backend/public;
    index index.php index.html;

    # Handle React Router
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # API routes
    location /api {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Frontend assets
    location /frontend {
        try_files $uri $uri/ =404;
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    # PHP processing
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Security headers
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
}
```

#### Apache Configuration

```apache
<VirtualHost *:80>
    ServerName your-domain.com
    DocumentRoot /var/www/portfolio/backend/public

    <Directory /var/www/portfolio/backend/public>
        AllowOverride All
        Require all granted
    </Directory>

    # Handle React Router
    FallbackResource /index.php

    # Security headers
    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set X-Content-Type-Options "nosniff"
</VirtualHost>
```

## 🔧 Environment Configuration

### Production Environment Variables

**Backend (.env)**
```env
APP_NAME="Portfolio"
APP_ENV=production
APP_KEY=base64:your-32-character-secret-key
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database
DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=portfolio
DB_USERNAME=portfolio_user
DB_PASSWORD=secure-password

# Mail
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@your-domain.com

# Cache & Session
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

# Security
SANCTUM_STATEFUL_DOMAINS=your-domain.com
```

**Frontend (.env)**
```env
VITE_API_URL=https://your-domain.com/api
VITE_APP_NAME=Portfolio
```

## 🔐 Security Considerations

### SSL/TLS Certificate

1. **Let's Encrypt (Free)**
   ```bash
   sudo apt install certbot python3-certbot-nginx
   sudo certbot --nginx -d your-domain.com
   ```

2. **Force HTTPS redirect**
   ```nginx
   server {
       listen 80;
       server_name your-domain.com;
       return 301 https://$server_name$request_uri;
   }
   ```

### Security Headers

Add to your web server configuration:
```
X-Frame-Options: SAMEORIGIN
X-Content-Type-Options: nosniff
X-XSS-Protection: 1; mode=block
Referrer-Policy: strict-origin-when-cross-origin
Permissions-Policy: camera=(), microphone=(), geolocation=()
```

### Database Security

- Use strong passwords
- Limit database user permissions
- Enable firewall rules
- Regular security updates

## 📊 Monitoring & Logging

### Log Files

- **Laravel logs**: `backend/storage/logs/laravel.log`
- **Web server logs**: `/var/log/nginx/` or `/var/log/apache2/`
- **System logs**: `/var/log/syslog`

### Health Checks

Create a health check endpoint:
```php
// routes/web.php
Route::get('/health', function () {
    return response()->json([
        'status' => 'healthy',
        'timestamp' => now(),
        'version' => config('app.version')
    ]);
});
```

### Performance Monitoring

- Use Laravel Telescope for development
- Implement APM tools (New Relic, Sentry)
- Monitor server resources
- Set up uptime monitoring

## 🚀 Performance Optimization

### Laravel Optimizations

```bash
# Production optimizations
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Enable OPcache in php.ini
opcache.enable=1
opcache.memory_consumption=128
opcache.max_accelerated_files=4000
```

### Frontend Optimizations

- Use CDN for static assets
- Enable compression (gzip/brotli)
- Implement caching headers
- Optimize images

## 🔄 Backup Strategy

### Database Backup

```bash
# MySQL backup script
#!/bin/bash
mysqldump -h $DB_HOST -u $DB_USER -p$DB_PASS $DB_NAME > backup_$(date +%Y%m%d_%H%M%S).sql

# Automated daily backup
echo "0 2 * * * /path/to/backup-script.sh" | crontab -
```

### File Backup

```bash
# Backup uploads and storage
tar -czf storage_backup_$(date +%Y%m%d).tar.gz backend/storage/app/public
```

## 🆘 Troubleshooting

### Common Issues

1. **Permission errors**
   ```bash
   sudo chown -R www-data:www-data /var/www/portfolio
   sudo chmod -R 755 storage bootstrap/cache
   ```

2. **Database connection issues**
   - Check credentials in .env
   - Verify database server is running
   - Test connection manually

3. **Frontend not loading**
   - Check if build files exist in public/frontend
   - Verify web server configuration
   - Check browser console for errors

### Logs to Check

```bash
# Laravel logs
tail -f backend/storage/logs/laravel.log

# Nginx logs
tail -f /var/log/nginx/error.log

# PHP-FPM logs
tail -f /var/log/php8.2-fpm.log
```