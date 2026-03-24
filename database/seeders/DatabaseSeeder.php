<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Vendor;
use App\Models\AssetCategory;
use App\Models\HardwareAsset;
use App\Models\SoftwareLicense;
use App\Models\LicenseAssignment;
use App\Models\MaintenanceRecord;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating roles and permissions...');

        $roleAdmin = Role::create(['name' => 'Admin', 'guard_name' => 'web']);
        $roleItManager = Role::create(['name' => 'IT Manager', 'guard_name' => 'web']);
        $roleTech = Role::create(['name' => 'Technician', 'guard_name' => 'web']);
        $roleViewer = Role::create(['name' => 'Viewer', 'guard_name' => 'web']);

        $permissions = [
            'manage assets', 'view assets', 'create assets', 'edit assets', 'delete assets',
            'manage licenses', 'view licenses', 'create licenses', 'edit licenses', 'delete licenses',
            'manage employees', 'view employees', 'create employees', 'edit employees', 'delete employees',
            'manage departments', 'view departments', 'create departments', 'edit departments', 'delete departments',
            'manage vendors', 'view vendors', 'create vendors', 'edit vendors', 'delete vendors',
            'manage categories', 'view categories', 'create categories', 'edit categories', 'delete categories',
            'manage maintenance', 'view maintenance', 'create maintenance', 'edit maintenance', 'delete maintenance',
            'manage assignments', 'view assignments', 'create assignments', 'edit assignments', 'delete assignments',
            'view reports',
            'manage roles', 'view roles', 'create roles', 'edit roles', 'delete roles',
            'manage permissions', 'view permissions', 'create permissions', 'edit permissions', 'delete permissions',
            'manage users', 'view users', 'create users', 'edit users', 'delete users',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        $roleAdmin->givePermissionTo(Permission::all());
        $roleItManager->givePermissionTo([
            'manage assets', 'view assets', 'create assets', 'edit assets',
            'manage licenses', 'view licenses', 'create licenses', 'edit licenses',
            'manage employees', 'view employees', 'create employees', 'edit employees',
            'manage departments', 'view departments', 'create departments', 'edit departments',
            'manage vendors', 'view vendors', 'create vendors', 'edit vendors',
            'manage categories', 'view categories', 'create categories', 'edit categories',
            'manage maintenance', 'view maintenance', 'create maintenance', 'edit maintenance',
            'manage assignments', 'view assignments', 'create assignments', 'edit assignments',
            'view reports',
        ]);
        $roleTech->givePermissionTo([
            'manage assets', 'view assets', 'create assets', 'edit assets',
            'manage maintenance', 'view maintenance', 'create maintenance', 'edit maintenance',
        ]);
        $roleViewer->givePermissionTo([
            'view assets', 'view licenses', 'view employees', 'view departments',
            'view vendors', 'view categories', 'view maintenance', 'view assignments', 'view reports',
        ]);

        $this->command->info('Seeding data...');

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@assetit.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('Admin');

        $itManager = User::create([
            'name' => 'IT Manager',
            'email' => 'itmanager@assetit.com',
            'password' => bcrypt('password'),
        ]);
        $itManager->assignRole('IT Manager');

        $tech = User::create([
            'name' => 'Technician',
            'email' => 'tech@assetit.com',
            'password' => bcrypt('password'),
        ]);
        $tech->assignRole('Technician');

        $viewer = User::create([
            'name' => 'Viewer',
            'email' => 'viewer@assetit.com',
            'password' => bcrypt('password'),
        ]);
        $viewer->assignRole('Viewer');

        $departments = [
            ['name' => 'Information Technology', 'description' => 'IT department handling all technology needs'],
            ['name' => 'Human Resources', 'description' => 'HR department for employee management'],
            ['name' => 'Finance', 'description' => 'Finance and accounting department'],
            ['name' => 'Marketing', 'description' => 'Marketing and communications department'],
            ['name' => 'Operations', 'description' => 'Operations and logistics department'],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }

        $departments = Department::all();
        $firstNames = ['John', 'Jane', 'Michael', 'Sarah', 'David', 'Emily', 'Robert', 'Lisa', 'James', 'Mary',
            'William', 'Jennifer', 'Thomas', 'Linda', 'Christopher', 'Patricia', 'Daniel', 'Elizabeth', 'Matthew', 'Susan',
            'Anthony', 'Jessica', 'Mark', 'Karen', 'Donald', 'Nancy', 'Steven', 'Betty', 'Paul', 'Margaret'];
        $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez',
            'Hernandez', 'Lopez', 'Gonzalez', 'Wilson', 'Anderson', 'Thomas', 'Taylor', 'Moore', 'Jackson', 'Martin',
            'Lee', 'Perez', 'Thompson', 'White', 'Harris', 'Sanchez', 'Clark', 'Ramirez', 'Lewis', 'Robinson'];
        $titles = ['Manager', 'Senior Developer', 'Developer', 'Analyst', 'Specialist', 'Coordinator', 'Director', 'Assistant', 'Engineer', 'Consultant'];

        $employees = [];
        for ($i = 0; $i < 30; $i++) {
            $employee = Employee::create([
                'department_id' => $departments->random()->id,
                'first_name' => $firstNames[$i],
                'last_name' => $lastNames[$i],
                'email' => strtolower($firstNames[$i] . '.' . $lastNames[$i] . '@company.com'),
                'phone' => '+1-' . rand(200, 999) . '-' . rand(100, 999) . '-' . rand(1000, 9999),
                'job_title' => $titles[array_rand($titles)],
            ]);
            $employees[] = $employee;
        }

        $vendors = [
            ['name' => 'Dell Technologies', 'contact_person' => 'John Dell', 'email' => 'sales@dell.com', 'phone' => '+1-800-555-0101', 'website' => 'https://dell.com', 'address' => 'Round Rock, TX'],
            ['name' => 'HP Inc.', 'contact_person' => 'Sarah HP', 'email' => 'sales@hp.com', 'phone' => '+1-800-555-0102', 'website' => 'https://hp.com', 'address' => 'Palo Alto, CA'],
            ['name' => 'Lenovo', 'contact_person' => 'Mike Lenovo', 'email' => 'sales@lenovo.com', 'phone' => '+1-800-555-0103', 'website' => 'https://lenovo.com', 'address' => 'Morrisville, NC'],
            ['name' => 'Microsoft', 'contact_person' => 'Bill M', 'email' => 'enterprise@microsoft.com', 'phone' => '+1-800-555-0104', 'website' => 'https://microsoft.com', 'address' => 'Redmond, WA'],
            ['name' => 'Adobe', 'contact_person' => 'Shantanu A', 'email' => 'sales@adobe.com', 'phone' => '+1-800-555-0105', 'website' => 'https://adobe.com', 'address' => 'San Jose, CA'],
            ['name' => 'Apple', 'contact_person' => 'Tim A', 'email' => 'sales@apple.com', 'phone' => '+1-800-555-0106', 'website' => 'https://apple.com', 'address' => 'Cupertino, CA'],
            ['name' => 'Oracle', 'contact_person' => 'Safra C', 'email' => 'sales@oracle.com', 'phone' => '+1-800-555-0107', 'website' => 'https://oracle.com', 'address' => 'Austin, TX'],
            ['name' => 'SAP', 'contact_person' => 'Christian K', 'email' => 'sales@sap.com', 'phone' => '+1-800-555-0108', 'website' => 'https://sap.com', 'address' => 'Walldorf, Germany'],
            ['name' => 'Cisco', 'contact_person' => 'Chuck R', 'email' => 'sales@cisco.com', 'phone' => '+1-800-555-0109', 'website' => 'https://cisco.com', 'address' => 'San Jose, CA'],
            ['name' => 'VMware', 'contact_person' => 'Raghu R', 'email' => 'sales@vmware.com', 'phone' => '+1-800-555-0110', 'website' => 'https://vmware.com', 'address' => 'Palo Alto, CA'],
        ];

        foreach ($vendors as $vendor) {
            Vendor::create($vendor);
        }

        $vendors = Vendor::all();

        $categories = [
            ['name' => 'Laptop', 'description' => 'Portable computers'],
            ['name' => 'Desktop', 'description' => 'Desktop computers'],
            ['name' => 'Server', 'description' => 'Server hardware'],
            ['name' => 'Monitor', 'description' => 'Display monitors'],
            ['name' => 'Printer', 'description' => 'Printing devices'],
            ['name' => 'Network Equipment', 'description' => 'Routers, switches, firewalls'],
            ['name' => 'Mobile Device', 'description' => 'Phones and tablets'],
            ['name' => 'Peripheral', 'description' => 'Keyboards, mice, webcams'],
        ];

        foreach ($categories as $cat) {
            AssetCategory::create($cat);
        }

        $categories = AssetCategory::all();

        $laptopModels = ['Latitude 5520', 'ThinkPad X1 Carbon', 'EliteBook 840', 'MacBook Pro 14"', 'Surface Laptop 4'];
        $desktopModels = ['OptiPlex 7090', 'ThinkCentre M70q', 'ProDesk 600', 'iMac 24"', 'Precision 3650'];
        $monitorModels = ['UltraSharp U2720Q', 'ThinkVision P27h-20', 'HP Z27k G3', 'LG 27UK850-W', 'Dell S2721QS'];
        $serverModels = ['PowerEdge R750', 'ProLiant DL380 Gen10', 'ThinkSystem SR650', 'UCS C220 M5', 'vSAN ReadyNodes'];

        for ($i = 1; $i <= 120; $i++) {
            $category = $categories->random();
            $status = ['available', 'assigned', 'maintenance', 'retired'][array_rand(['available', 'assigned', 'maintenance', 'retired'])];
            
            $modelNames = match($category->name) {
                'Laptop' => $laptopModels,
                'Desktop' => $desktopModels,
                'Monitor' => $monitorModels,
                'Server' => $serverModels,
                default => ['Generic Device']
            };

            $asset = HardwareAsset::create([
                'asset_tag' => 'AST-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'name' => $modelNames[array_rand($modelNames)] . ' ' . $i,
                'category_id' => $category->id,
                'vendor_id' => $vendors->random()->id,
                'serial_number' => 'SN' . strtoupper(Str::random(10)),
                'purchase_date' => Carbon::now()->subMonths(rand(1, 36))->format('Y-m-d'),
                'purchase_cost' => rand(500, 5000),
                'warranty_expiry' => Carbon::now()->addMonths(rand(1, 36))->format('Y-m-d'),
                'status' => $status,
                'assigned_employee_id' => $status === 'assigned' ? $employees[array_rand($employees)]->id : null,
                'notes' => rand(0, 1) ? 'Asset in good condition' : null,
            ]);
        }

        $softwareNames = [
            'Microsoft Office 365 Business', 'Adobe Creative Cloud', 'Visual Studio Enterprise', 
            'JetBrains All Products', 'Slack Business+', 'Zoom Business', 'Salesforce CRM',
            'SAP ERP', 'Oracle Database', 'Windows Server 2022', 'Windows 11 Pro',
            'Autodesk AutoCAD', 'Atlassian Jira', 'Atlassian Confluence', 'GitHub Enterprise',
            'VMware vSphere', 'Citrix Workspace', 'Symantec Endpoint Protection',
            'McAfee Total Protection', 'Norton AntiVirus', 'ZoomInfo', 'HubSpot',
            'Zendesk', 'Freshdesk', 'Mailchimp', 'Hootsuite', 'Sprout Social',
            'Semrush', 'Ahrefs', 'Moz Pro', 'Google Workspace Business',
            'Dropbox Business', 'Box Business', 'OneDrive for Business',
            'Amazon Web Services', 'Google Cloud Platform', 'Azure',
            'SQL Server 2022', 'MySQL Enterprise', 'PostgreSQL Plus',
            'IntelliJ IDEA', 'PyCharm Pro', 'WebStorm', 'DataGrip',
            'Notion Team', 'Asana Business', 'Trello Enterprise', 'Monday.com',
            'Tableau Desktop', 'Power BI Pro', 'QlikView'
        ];

        $licenses = [];
        for ($i = 0; $i < 50; $i++) {
            $expiration = rand(0, 1) ? Carbon::now()->addMonths(rand(1, 36))->format('Y-m-d') : null;
            
            $license = SoftwareLicense::create([
                'software_name' => $softwareNames[$i % count($softwareNames)] . ' ' . ($i > 47 ? '' : chr(65 + floor($i / 48))),
                'vendor_id' => $vendors->random()->id,
                'license_key' => strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4)),
                'total_seats' => rand(5, 100),
                'purchase_date' => Carbon::now()->subMonths(rand(1, 24))->format('Y-m-d'),
                'expiration_date' => $expiration,
                'cost' => rand(100, 10000),
                'notes' => rand(0, 1) ? 'Enterprise license' : null,
            ]);
            $licenses[] = $license;
        }

        foreach ($licenses as $license) {
            $assignedCount = rand(0, min($license->total_seats, 10));
            for ($j = 0; $j < $assignedCount; $j++) {
                $employee = $employees[array_rand($employees)];
                $alreadyAssigned = LicenseAssignment::where('license_id', $license->id)
                    ->where('employee_id', $employee->id)->exists();
                
                if (!$alreadyAssigned) {
                    LicenseAssignment::create([
                        'license_id' => $license->id,
                        'employee_id' => $employee->id,
                        'assigned_date' => Carbon::now()->subMonths(rand(1, 12))->format('Y-m-d'),
                        'revoked_date' => rand(0, 3) == 0 ? Carbon::now()->subDays(rand(1, 30))->format('Y-m-d') : null,
                    ]);
                }
            }
        }

        $assets = HardwareAsset::all();
        $maintenanceTypes = ['preventive', 'repair', 'upgrade', 'inspection'];
        
        for ($i = 0; $i < 80; $i++) {
            MaintenanceRecord::create([
                'asset_id' => $assets->random()->id,
                'maintenance_type' => $maintenanceTypes[array_rand($maintenanceTypes)],
                'description' => 'Maintenance performed as scheduled',
                'cost' => rand(50, 1000),
                'maintenance_date' => Carbon::now()->subMonths(rand(0, 12))->format('Y-m-d'),
                'vendor_id' => $vendors->random()->id,
            ]);
        }

        $this->command->info('Data seeded successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('  Email: admin@assetit.com');
        $this->command->info('  Password: password');
    }
}
