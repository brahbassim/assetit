# Installation

This guide will walk you through the complete installation process for AssetIT.

## Prerequisites

Before installing AssetIT, ensure your system meets the following requirements:

- **PHP**: 8.4 or higher
- **Composer**: Latest version
- **MySQL**: 5.7+ or MariaDB 10.3+
- **Node.js**: 18.x or higher
- **npm**: Latest version
- **Web Server**: Nginx (LEMP) or Apache (LAMP)

> **Note:** This project was developed on LEMP stack (Linux, Nginx, MySQL, PHP) but is fully compatible with LAMP stack (Linux, Apache, MySQL, PHP).

## Installation Steps

### Step 1: Clone the Repository

```bash
git clone https://github.com/brahbassim/assetit.git
cd assetit
```

### Step 2: Install PHP Dependencies

```bash
composer install
```

### Step 3: Install Node.js Dependencies

```bash
npm install
```

### Step 4: Install Debugbar (Optional - Development Only)

```bash
composer require fruitcake/laravel-debugbar --dev
```

### Step 5: Configure Environment

Copy the example environment file and configure your settings:

```bash
cp .env.example .env
```

Edit the `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=assetit
DB_USERNAME=root
DB_PASSWORD=your_password
```

Create the database:

```sql
CREATE DATABASE assetit;
```

### Step 6: Generate Application Key

```bash
php artisan key:generate
```

### Step 7: Run Migrations

```bash
php artisan migrate
```

### Step 8: Seed Database (Optional)

For demo data:

```bash
php artisan migrate --seed
```

This will create:
- 5 Departments
- 30 Employees
- 10 Vendors
- 8 Asset Categories
- 120 Hardware Assets
- 50 Software Licenses
- 80 Maintenance Records
- 4 User accounts

### Step 9: Build Assets

```bash
npm run build
```

### Step 10: Start the Server

```bash
php artisan serve
```

Access the application at **http://localhost:8000**

## Troubleshooting

### Permission Issues

If you encounter permission errors:

```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

### Database Connection Errors

- Verify MySQL is running
- Check credentials in `.env` file
- Ensure database exists

### Missing Extensions

Install required PHP extensions:
- `php-mysql`
- `php-mbstring`
- `php-xml`
- `php-curl`
- `php-zip`

## Next Steps

- Review the [Configuration Guide](configuration.md)
- Read the [Usage Guide](usage.md)
- Explore [User Roles & Permissions](roles.md)
