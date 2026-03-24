# Modules

AssetIT includes 12 main modules for comprehensive IT asset management.

## Hardware Assets

**Route**: `/hardware-assets`

Manage all hardware inventory including:
- Desktop computers
- Laptops
- Servers
- Monitors
- Printers
- Peripherals

### Fields
- Asset Tag (unique identifier)
- Asset Name
- Category
- Manufacturer
- Model
- Serial Number
- Purchase Date
- Purchase Cost
- Warranty Expiration
- Vendor
- Status (Active, In Repair, Retired)
- Location
- Assigned Employee
- Notes

### Permissions
- `hardware_assets.view`
- `hardware_assets.create`
- `hardware_assets.edit`
- `hardware_assets.delete`

---

## Software Licenses

**Route**: `/software-licenses`

Manage software licenses with seat tracking:
- Operating Systems
- Productivity Software
- Development Tools
- Security Software
- etc.

### Fields
- License Name
- Vendor
- License Key
- License Type (Perpetual, Subscription)
- Total Seats
- Used Seats
- Purchase Date
- Expiration Date
- Cost
- Notes

### Permissions
- `software_licenses.view`
- `software_licenses.create`
- `software_licenses.edit`
- `software_licenses.delete`

---

## License Assignments

**Route**: `/license-assignments`

Assign software licenses to employees:
- Track who has which software
- Manage seat availability
- Revoke assignments when employees leave

### Fields
- License
- Employee
- Assignment Date
- Expiration (optional)
- Notes

### Permissions
- `license_assignments.view`
- `license_assignments.create`
- `license_assignments.edit`
- `license_assignments.delete`

---

## Employees

**Route**: `/employees`

Maintain employee directory:
- Contact information
- Department assignment
- Position/Title

### Fields
- Employee ID
- First Name
- Last Name
- Email
- Phone
- Department
- Position
- Start Date
- Notes

### Permissions
- `employees.view`
- `employees.create`
- `employees.edit`
- `employees.delete`

---

## Departments

**Route**: `/departments`

Organize employees by department:
- IT, HR, Finance, Marketing, etc.
- Hierarchical structure support

### Fields
- Department Name
- Department Code
- Manager
- Parent Department
- Notes

### Permissions
- `departments.view`
- `departments.create`
- `departments.edit`
- `departments.delete`

---

## Vendors

**Route**: `/vendors`

Manage vendor relationships:
- Hardware suppliers
- Software vendors
- Service providers

### Fields
- Company Name
- Contact Person
- Email
- Phone
- Website
- Address
- Notes

### Permissions
- `vendors.view`
- `vendors.create`
- `vendors.edit`
- `vendors.delete`

---

## Asset Categories

**Route**: `/asset-categories`

Categorize assets for better organization:
- Laptop, Desktop, Server
- Monitor, Printer, Scanner
- Network Equipment

### Fields
- Category Name
- Category Code
- Description

### Permissions
- `asset_categories.view`
- `asset_categories.create`
- `asset_categories.edit`
- `asset_categories.delete`

---

## Maintenance Records

**Route**: `/maintenance-records`

Track hardware maintenance and repairs:
- Scheduled maintenance
- Repairs
- Upgrades

### Fields
- Asset
- Maintenance Type (Preventive, Corrective, Upgrade)
- Description
- Performed By
- Maintenance Date
- Cost
- Next Maintenance Date
- Notes

### Permissions
- `maintenance_records.view`
- `maintenance_records.create`
- `maintenance_records.edit`
- `maintenance_records.delete`

---

## Reports

**Route**: `/reports`

Generate and export reports:

### Report Types
1. **Hardware Inventory** - Complete asset listing
2. **License Utilization** - Usage vs available seats
3. **Assets by Department** - Distribution analysis
4. **Maintenance Costs** - Expense tracking
5. **License Expiration** - Upcoming expirations

### Export Formats
- PDF
- Excel (XLSX)

### Permissions
- `reports.view`
- `reports.export`

---

## Users (Admin)

**Route**: `/users`

User account management:
- Create/edit/delete users
- Assign roles
- Reset passwords

### Permissions
- `users.view`
- `users.create`
- `users.edit`
- `users.delete`

---

## Roles (Admin)

**Route**: `/roles`

Role management:
- Create/edit/delete roles
- Assign permissions to roles

### Default Roles
- Admin
- IT Manager
- Technician
- Viewer

### Permissions
- `roles.view`
- `roles.create`
- `roles.edit`
- `roles.delete`
- `roles.assign`

---

## Permissions (Admin)

**Route**: `/permissions`

Granular permission management:
- View all permissions
- Manage role-permission assignments
- 35+ individual permissions

### Permissions
- `permissions.view`
- `permissions.manage`
