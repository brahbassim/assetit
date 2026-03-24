# IT Asset & License Management System

[![Documentation](https://img.shields.io/badge/Documentation-Online-blue?style=for-the-badge)](https://brahbassim.github.io/assetit/)

A comprehensive Laravel 13 application for managing IT assets, software licenses, employees, vendors, and more.

## Features

### Core Functionality
- **Hardware Asset Management** - Track computers, servers, monitors, peripherals with full CRUD
- **Software License Management** - Manage software licenses with seat tracking and expiration dates
- **License Assignments** - Assign/revoke software licenses to employees
- **Employee Management** - Track employees across departments
- **Department Management** - Organize employees by department
- **Vendor Management** - Manage vendor relationships and contacts
- **Asset Categories** - Categorize assets (Laptop, Desktop, Server, etc.)
- **Maintenance Records** - Track hardware maintenance and repairs

### Administration
- **Role-Based Access Control** - Admin, IT Manager, Technician, Viewer roles
- **Permission Management** - 35+ granular permissions for all modules
- **User Management** - Create, edit, delete users with role assignment
- **Audit Logging** - Track all system changes

### Reporting & Analytics
- **Dashboard** - Overview with Chart.js visualizations
- **Hardware Inventory Report** - Complete hardware asset listing
- **License Utilization Report** - Track license usage vs available seats
- **Assets by Department Report** - Distribution analysis
- **Maintenance Cost Report** - Track maintenance expenses
- **License Expiration Report** - Upcoming expirations
- **Export** - PDF and Excel export capabilities

### Additional Features
- **License Expiration Alerts** - Automated scheduled checks
- **Profile Management** - Users can update their profile
- **Responsive Design** - SB Admin 2 Bootstrap 4 template

## Quick Start

```bash
# Install dependencies
composer install
npm install

# Configure environment
cp .env.example .env
# Update .env with database credentials

# Generate key and setup
php artisan key:generate
php artisan migrate --seed

# Start server
php artisan serve
```

Access at **http://localhost:8000**

## Documentation

Full documentation available at: **https://brahbassim.github.io/assetit/**

Includes: Installation, Configuration, Usage Guide, Modules, API, Deployment, and Contributing.

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@assetit.com | password |
| IT Manager | itmanager@assetit.com | password |
| Technician | tech@assetit.com | password |
| Viewer | viewer@assetit.com | password |

## User Roles

| Role | Permissions |
|------|-------------|
| **Admin** | Full access to all features including user/role management |
| **IT Manager** | Manage assets, licenses, employees, view reports |
| **Technician** | Manage hardware assets, maintenance records |
| **Viewer** | Read-only access to view data and reports |

## Modules

| Module | Description |
|--------|-------------|
| `/hardware-assets` | Track hardware inventory |
| `/software-licenses` | Manage software licenses |
| `/license-assignments` | Assign licenses to employees |
| `/employees` | Employee directory |
| `/departments` | Department management |
| `/vendors` | Vendor contacts |
| `/asset-categories` | Asset categorization |
| `/maintenance-records` | Maintenance tracking |
| `/reports` | Generate reports |
| `/roles` | Role management (Admin) |
| `/permissions` | Permission management (Admin) |
| `/users` | User management (Admin) |

## Scheduled Tasks

- **License Expiration Check** - Runs daily to alert on expiring licenses

```bash
# Run scheduler manually
php artisan schedule:run

# Or set cron job
* * * * * php /path-to-artisan schedule:run >> /dev/null 2>&1
```

## Tech Stack

- Laravel 13 + PHP 8.3+
- MySQL Database
- Bootstrap 4 (SB Admin 2)
- Chart.js Visualizations
- Spatie Laravel Permission
- Barryvdh Laravel DomPDF
- Maatwebsite Excel

## Demo Data

- 5 Departments
- 30 Employees
- 10 Vendors
- 8 Asset Categories
- 120 Hardware Assets
- 50 Software Licenses
- 80 Maintenance Records

## Commands

```bash
php artisan migrate --seed          # Reset database with seed data
php artisan licenses:check-expiration  # Check expiring licenses
php artisan config:clear            # Clear config cache
php artisan route:clear             # Clear route cache
```

## Requirements

- PHP 8.3+
- Laravel 13
- MySQL 5.7+
- Composer
- Node.js

## License

MIT License
