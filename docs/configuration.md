# Configuration

This guide covers all configuration options for AssetIT.

## Environment Variables

### Application

```env
APP_NAME=AssetIT
APP_ENV=local
APP_KEY=base64:your-generated-key
APP_DEBUG=true
APP_URL=http://localhost:8000
```

### Database

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=assetit
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Mail Configuration

For license expiration alerts, configure your mail settings:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@assetit.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Queue Configuration

```env
QUEUE_CONNECTION=database
```

### Cache Configuration

```env
CACHE_STORE=file
SESSION_DRIVER=file
```

## Scheduler Configuration

### Setting Up Cron Job

Add the Laravel scheduler to your system's crontab:

```bash
crontab -e
```

Add this line:

```
* * * * * php /path-to-project/artisan schedule:run >> /dev/null 2>&1
```

This runs the scheduler every minute to check for expiring licenses.

### Scheduled Tasks

| Task | Frequency | Description |
|------|-----------|-------------|
| License Expiration Check | Daily | Sends alerts for licenses expiring within 30 days |

## Permission Configuration

AssetIT uses Spatie Laravel Permission. The seed data creates these permissions:

### Hardware Assets
- hardware_assets.view
- hardware_assets.create
- hardware_assets.edit
- hardware_assets.delete

### Software Licenses
- software_licenses.view
- software_licenses.create
- software_licenses.edit
- software_licenses.delete

### License Assignments
- license_assignments.view
- license_assignments.create
- license_assignments.edit
- license_assignments.delete

### Employees
- employees.view
- employees.create
- employees.edit
- employees.delete

### Departments
- departments.view
- departments.create
- departments.edit
- departments.delete

### Vendors
- vendors.view
- vendors.create
- vendors.edit
- vendors.delete

### Asset Categories
- asset_categories.view
- asset_categories.create
- asset_categories.edit
- asset_categories.delete

### Maintenance Records
- maintenance_records.view
- maintenance_records.create
- maintenance_records.edit
- maintenance_records.delete

### Reports
- reports.view
- reports.export

### Users
- users.view
- users.create
- users.edit
- users.delete

### Roles
- roles.view
- roles.create
- roles.edit
- roles.delete
- roles.assign

### Permissions
- permissions.view
- permissions.manage

## Cache Commands

```bash
# Clear all caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Production optimization
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

## Storage Links

```bash
php artisan storage:link
```

## Next Steps

- Read the [Usage Guide](usage.md)
- Explore [Modules](modules.md)
- Review [User Roles](roles.md)
