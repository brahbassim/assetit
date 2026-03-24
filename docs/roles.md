# User Roles & Permissions

AssetIT implements role-based access control (RBAC) with 4 predefined roles and 35+ granular permissions.

## User Roles

### Admin
- **Access**: Full system access
- **Capabilities**:
  - All CRUD operations
  - User management
  - Role management
  - Permission management
  - All reports
  - View audit logs
  - Export data

### IT Manager
- **Access**: Management level
- **Capabilities**:
  - All CRUD operations (except users/roles)
  - All reports
  - Employee management
  - Export data
- **Restrictions**:
  - Cannot manage users
  - Cannot manage roles/permissions

### Technician
- **Access**: Technical staff
- **Capabilities**:
  - Hardware assets CRUD
  - Maintenance records CRUD
  - View employees
  - View departments
  - Basic reports
- **Restrictions**:
  - Cannot manage licenses
  - Cannot manage users/roles

### Viewer
- **Access**: Read-only
- **Capabilities**:
  - View all data
  - View reports
  - Update own profile
- **Restrictions**:
  - No modification rights
  - Cannot export

## Default Permissions

### Hardware Assets
| Permission | Description |
|------------|-------------|
| hardware_assets.view | View asset list and details |
| hardware_assets.create | Create new assets |
| hardware_assets.edit | Edit existing assets |
| hardware_assets.delete | Delete assets |

### Software Licenses
| Permission | Description |
|------------|-------------|
| software_licenses.view | View license list and details |
| software_licenses.create | Create new licenses |
| software_licenses.edit | Edit existing licenses |
| software_licenses.delete | Delete licenses |

### License Assignments
| Permission | Description |
|------------|-------------|
| license_assignments.view | View assignments |
| license_assignments.create | Create assignments |
| license_assignments.edit | Edit assignments |
| license_assignments.delete | Delete assignments |

### Employees
| Permission | Description |
|------------|-------------|
| employees.view | View employee list |
| employees.create | Add new employees |
| employees.edit | Edit employees |
| employees.delete | Remove employees |

### Departments
| Permission | Description |
|------------|-------------|
| departments.view | View departments |
| departments.create | Create departments |
| departments.edit | Edit departments |
| departments.delete | Delete departments |

### Vendors
| Permission | Description |
|------------|-------------|
| vendors.view | View vendor list |
| vendors.create | Add new vendors |
| vendors.edit | Edit vendors |
| vendors.delete | Delete vendors |

### Asset Categories
| Permission | Description |
|------------|-------------|
| asset_categories.view | View categories |
| asset_categories.create | Create categories |
| asset_categories.edit | Edit categories |
| asset_categories.delete | Delete categories |

### Maintenance Records
| Permission | Description |
|------------|-------------|
| maintenance_records.view | View records |
| maintenance_records.create | Create records |
| maintenance_records.edit | Edit records |
| maintenance_records.delete | Delete records |

### Reports
| Permission | Description |
|------------|-------------|
| reports.view | View reports |
| reports.export | Export reports |

### Users
| Permission | Description |
|------------|-------------|
| users.view | View user list |
| users.create | Create users |
| users.edit | Edit users |
| users.delete | Delete users |

### Roles
| Permission | Description |
|------------|-------------|
| roles.view | View roles |
| roles.create | Create roles |
| roles.edit | Edit roles |
| roles.delete | Delete roles |
| roles.assign | Assign roles to users |

### Permissions
| Permission | Description |
|------------|-------------|
| permissions.view | View permissions |
| permissions.manage | Manage permissions |

## Role-Permission Matrix

| Feature | Admin | IT Manager | Technician | Viewer |
|---------|-------|------------|------------|--------|
| Hardware Assets | ✓ | ✓ | ✓ | View |
| Software Licenses | ✓ | ✓ | ✗ | View |
| License Assignments | ✓ | ✓ | ✗ | View |
| Employees | ✓ | ✓ | View | View |
| Departments | ✓ | ✓ | View | View |
| Vendors | ✓ | ✓ | View | View |
| Asset Categories | ✓ | ✓ | View | View |
| Maintenance | ✓ | ✓ | ✓ | View |
| Reports | ✓ | ✓ | View | View |
| Users | ✓ | ✗ | ✗ | ✗ |
| Roles | ✓ | ✗ | ✗ | ✗ |
| Permissions | ✓ | ✗ | ✗ | ✗ |

## Customizing Roles

To create custom roles:

1. Navigate to Roles (Admin only)
2. Click "Create New Role"
3. Enter role name
4. Select permissions
5. Save

To assign roles to users:

1. Navigate to Users
2. Edit user
3. Select role from dropdown
4. Save
