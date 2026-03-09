# Hosting and Deployment

## Scope

This document describes how to deploy `internetMyShop` safely on a host or VPS.

It covers:

- recommended production topology;
- detailed deployment on Ubuntu VPS;
- current Docker limitations;
- shared hosting constraints;
- what to update after each release.

## Recommended production topology

The recommended production stack is:

- `Ubuntu 24.04 LTS`
- `Nginx`
- `PHP-FPM 8.4`
- `MySQL 8`
- `Node 24`
- `Composer 2`
- `systemd`

Why this is the recommended path:

- Laravel backend is best served through `Nginx + PHP-FPM`, not `artisan serve`;
- Nuxt production build should run as a Node server, not `nuxt dev`;
- MySQL matches the containerized runtime and admin upload behavior better than sqlite for production.

## Important note about Docker

The repository already contains `docker-compose.yml`, but that stack is for development only.

Current dev Docker limitations:

- Laravel runs through `php artisan serve`;
- Nuxt runs through `nuxt dev`;
- the compose file is optimized for local iteration, not hardened production.

Use the Docker stack for:

- local development;
- staging-like local QA;
- quick onboarding.

Do not use the current dev compose file as-is for public internet production.

## Queue and scheduler notes

At the current stage:

- `QUEUE_CONNECTION=sync` by default;
- no dedicated queue worker is required for the documented baseline deployment;
- no project-specific scheduler bootstrap is required beyond standard Laravel support.

If future changes introduce queued jobs or scheduled tasks, update this document in the same change.

## Minimum server requirements

### PHP

Use `PHP 8.4` with at least these extensions available:

- `bcmath`
- `ctype`
- `exif`
- `fileinfo`
- `gd`
- `intl`
- `mbstring`
- `openssl`
- `pdo_mysql`
- `tokenizer`
- `xml`
- `zip`

### Node

- `Node 24`
- `npm` matching the installed Node line

### Database

- `MySQL 8.x`

## Deployment model A: Ubuntu VPS without Docker

This is the primary recommended hosting model.

### 1. Install system packages

```bash
sudo apt update
sudo apt install -y nginx mysql-server git unzip curl software-properties-common
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install -y php8.4 php8.4-cli php8.4-fpm php8.4-mysql php8.4-sqlite3 php8.4-mbstring php8.4-xml php8.4-bcmath php8.4-intl php8.4-zip php8.4-gd php8.4-curl php8.4-exif
curl -fsSL https://deb.nodesource.com/setup_24.x | sudo -E bash -
sudo apt install -y nodejs
```

### 2. Install Composer

```bash
cd /tmp
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
sudo mv composer.phar /usr/local/bin/composer
composer --version
```

### 3. Create database

```bash
sudo mysql
```

Inside MySQL:

```sql
CREATE DATABASE internetmyshop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'internetmyshop'@'localhost' IDENTIFIED BY 'strong_password_here';
GRANT ALL PRIVILEGES ON internetmyshop.* TO 'internetmyshop'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 4. Upload or clone the project

```bash
cd /var/www
sudo git clone <your-repository-url> internetMyShop
sudo chown -R $USER:$USER /var/www/internetMyShop
cd /var/www/internetMyShop
```

### 5. Install dependencies

```bash
composer install --no-dev --optimize-autoloader
npm run web:install
```

### 6. Configure backend environment

```bash
cp .env.example .env
php artisan key:generate --force
```

Edit `.env` at minimum:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://app.example.com
FRONTEND_URL=https://shop.example.com
TRUSTED_HOSTS=app.example.com,shop.example.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=internetmyshop
DB_USERNAME=internetmyshop
DB_PASSWORD=strong_password_here

CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_DOMAIN=.example.com
SANCTUM_STATEFUL_DOMAINS=shop.example.com,app.example.com

PAYMENT_PROVIDER=paypal
STORE_CURRENCY=KZT
PAYMENT_STATUS_BASE_URL=https://shop.example.com/payments
```

Then add provider-specific variables for the selected gateway.

### 6.1 PayPal live example

```dotenv
PAYPAL_SANDBOX=false
PAYPAL_BASE_URL=https://api-m.paypal.com
PAYPAL_CURRENCY=USD
PAYPAL_EXCHANGE_RATE=510
PAYPAL_CLIENT_ID=live_client_id
PAYPAL_CLIENT_SECRET=live_client_secret
PAYPAL_MERCHANT_ID=
PAYPAL_WEBHOOK_ID=live_webhook_id
```

### 6.2 Real provider checklist

If you switch from the default development PayPal sandbox to a real payment provider, update the provider credentials, callback settings and currency strategy in the same release.

Minimum checklist:

- `PAYMENT_PROVIDER` must point to a registered backend driver code;
- `PAYMENT_STATUS_BASE_URL` must point to the public storefront payment status page;
- webhook URL must point to the public backend host:
  - `https://app.example.com/api/v1/payments/webhook/{provider}`
- return/cancel URLs must point back to the storefront host;
- provider secrets must live only in backend env or server secret storage;
- if the provider supports `KZT`, prefer provider currency `KZT` and exchange rate `1`;
- if the provider charges in another currency, document and verify the conversion strategy before go-live.

Examples for a non-PayPal provider usually look like:

```dotenv
PAYMENT_PROVIDER=freedompay
FREEDOMPAY_BASE_URL=https://provider.example
FREEDOMPAY_MERCHANT_ID=merchant_id
FREEDOMPAY_SECRET_KEY=secret_key
FREEDOMPAY_CURRENCY=KZT
FREEDOMPAY_EXCHANGE_RATE=1
```

Every such provider change must also update:

- `docs/payments.md`
- `docs/openapi.yaml`
- `README.md`
- this deployment guide

### 7. Prepare storage and database

```bash
php artisan migrate --force --no-interaction
php artisan db:seed --class="Database\\Seeders\\StorefrontSiteContentSeeder" --force --no-interaction
php artisan storage:link
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Important:

- do not run full demo seed on production unless you intentionally want demo accounts and demo catalog data;
- `StorefrontSiteContentSeeder` is safe for filling default storefront text records;
- demo full seed is suitable for local and staging, not for public production.
- payment webhooks must point to the public backend host, not to the Nuxt host.

After changing payment env values in production, always refresh caches:

```bash
php artisan optimize:clear
php artisan config:cache
```

### 8. Build Nuxt frontend for production

```bash
npm run web:build
```

This produces the production Nuxt server in:

- `apps/web/.output/server/index.mjs`

### 8.1 Create the first production admin user

Do not use the demo admin seed on public production.

Create a real admin through `tinker`:

```bash
php artisan tinker
```

Then run:

```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

User::updateOrCreate(
    ['email' => 'owner@example.com'],
    [
        'name' => 'Owner',
        'password' => Hash::make('strong_password_here'),
        'email_verified_at' => now(),
        'admin' => true,
    ],
);
```

After that, log in at `/admin`.

### 9. Configure systemd for Nuxt

Create `/etc/systemd/system/internetmyshop-nuxt.service`:

```ini
[Unit]
Description=internetMyShop Nuxt Frontend
After=network.target

[Service]
Type=simple
User=www-data
WorkingDirectory=/var/www/internetMyShop/apps/web
Environment=NODE_ENV=production
Environment=HOST=127.0.0.1
Environment=PORT=3000
Environment=NUXT_BACKEND_API_BASE=https://app.example.com/api/v1
ExecStart=/usr/bin/node /var/www/internetMyShop/apps/web/.output/server/index.mjs
Restart=always
RestartSec=5

[Install]
WantedBy=multi-user.target
```

Enable and start it:

```bash
sudo systemctl daemon-reload
sudo systemctl enable internetmyshop-nuxt
sudo systemctl start internetmyshop-nuxt
sudo systemctl status internetmyshop-nuxt
```

### 10. Configure Nginx for Laravel backend

Example `app.example.com`:

```nginx
server {
    listen 80;
    server_name app.example.com;
    root /var/www/internetMyShop/public;
    index index.php index.html;

    client_max_body_size 20m;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 11. Configure Nginx for Nuxt frontend

Example `shop.example.com`:

```nginx
server {
    listen 80;
    server_name shop.example.com;

    location / {
        proxy_pass http://127.0.0.1:3000;
        proxy_http_version 1.1;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "upgrade";
    }
}
```

### 12. Enable the sites

```bash
sudo ln -s /etc/nginx/sites-available/internetmyshop-app.conf /etc/nginx/sites-enabled/
sudo ln -s /etc/nginx/sites-available/internetmyshop-web.conf /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### 13. Add HTTPS

Recommended:

```bash
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d app.example.com -d shop.example.com
```

## Deployment model B: shared hosting

Shared hosting is possible only with limitations.

### Works well

- Laravel backend;
- Blade storefront;
- MoonShine admin;
- MySQL;
- uploaded images and public storage.

### Usually does not work well

- Nuxt production server as a long-running Node process;
- custom process supervisor management;
- full BFF deployment on hosts without persistent Node support.

Conclusion:

- if the host does not allow a long-running Node service, deploy only Laravel/Blade/MoonShine there;
- deploy the Nuxt frontend on a VPS or separate Node-capable host.

## Deployment model C: Docker on VPS

The current repository Docker files are useful for development, but if you want production Docker you should create a dedicated production stack with:

- `php-fpm` instead of `artisan serve`;
- `nginx` container or reverse proxy;
- `nuxt build` + `node .output/server/index.mjs` instead of `nuxt dev`;
- production env values;
- external volumes and backups.

That production Docker stack is not yet part of this repository.

## Safe release checklist

Before each production release:

```bash
php scripts/app.php verify:all
php scripts/app.php verify:e2e
```

Then:

```bash
git pull
composer install --no-dev --optimize-autoloader
npm run web:install
npm run web:build
php artisan migrate --force --no-interaction
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
sudo systemctl restart php8.4-fpm
sudo systemctl restart internetmyshop-nuxt
sudo systemctl reload nginx
```

If the release changes payment provider credentials, callback URLs, signature secrets or currency strategy, add these release-only checks before enabling traffic:

1. create a real or staging payment manually;
2. confirm the webhook reaches `/api/v1/payments/webhook/{provider}`;
3. confirm the payment status page shows the final state;
4. confirm the related order is marked `Paid` only after backend confirmation.

## Backups

At minimum back up:

- MySQL database;
- `.env`;
- `storage/app/public`;
- deployment-specific systemd and Nginx configs.

## Documentation maintenance

If deployment assumptions change, update these files in the same change:

- `README.md`
- `docs/architecture.md`
- `docs/hosting-deployment.md`
- `docs/documentation-maintenance.md`
