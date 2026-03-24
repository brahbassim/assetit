# Usage Guide

This guide explains how to use the AssetIT application after installation.

## Starting the Application

### Development Server

```bash
php artisan serve
```

The application will be available at **http://localhost:8000**

### Using Laravel Valet (macOS)

```bash
valet start
```

### Using XAMPP/WAMP

Place the project in your web server's document root and access via browser.

## Login Credentials

After seeding, use these credentials:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@assetit.com | `password` |
| IT Manager | itmanager@assetit.com | `password` |
| Technician | tech@assetit.com | `password` |
| Viewer | viewer@assetit.com | `password` |

## Dashboard

The dashboard provides an overview of your IT assets:

- **Total Assets**: Count of all hardware assets
- **Total Licenses**: Count of all software licenses
- **Active Assignments**: Currently assigned licenses
- **Expiring Soon**: Licenses expiring in 30 days

### Charts

- **Assets by Status**: Pie chart showing active, in repair, retired
- **Assets by Category**: Bar chart of assets per category
- **License Utilization**: Usage vs available seats
- **Assets by Department**: Distribution across departments

## Navigation

Access modules via the sidebar menu:

```
├── Dashboard
├── Hardware Assets
├── Software Licenses
├── License Assignments
├── Employees
├── Departments
├── Vendors
├── Asset Categories
├── Maintenance Records
├── Reports
├── ─────────────
├── Users (Admin)
├── Roles (Admin)
├── Permissions (Admin)
└── Profile
```

## Available Commands

### Database Commands

```bash
# Reset database with seed data
php artisan migrate --seed

# Fresh install
php artisan migrate:fresh --seed
```

### License Management

```bash
# Check expiring licenses manually
php artisan licenses:check-expiration

# Run scheduler
php artisan schedule:run
```

### Cache Management

```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

### Production Commands

```bash
# Optimize for production
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Common Tasks

### Creating a Hardware Asset

1. Navigate to Hardware Assets
2. Click "Add New Asset"
3. Fill in the form:
   - Asset Tag (auto-generated or custom)
   - Asset Name
   - Category
   - Manufacturer
   - Model
   - Serial Number
   - Purchase Date
   - Purchase Cost
   - Vendor
   - Status
   - Location
   - Assigned To (employee)
4. Click Save

### Assigning a Software License

1. Navigate to License Assignments
2. Click "New Assignment"
3. Select License
4. Select Employee
5. Assign Date
6. Click Save

### Generating a Report

1. Navigate to Reports
2. Select report type:
   - Hardware Inventory
   - License Utilization
   - Assets by Department
   - Maintenance Costs
   - License Expiration
3. Set filters (date range, department, etc.)
4. Click Generate
5. Export as PDF or Excel

## Profile Management

Users can update their profile:
- Name
- Email
- Profile Picture
- Password

## Next Steps

- Explore [Modules](modules.md)
- Review [User Roles & Permissions](roles.md)
- Learn about [API](api.md)
