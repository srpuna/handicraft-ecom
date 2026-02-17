# Admin Password Management & Role-Based Access Control System

## Overview
This system provides a complete admin management solution with role-based access control (RBAC), password management, and user permissions.

## Features

### 1. Role-Based Access Control (RBAC)
- **Roles**: Organize permissions into reusable groups
- **Permissions**: Granular control over system features
- **Hierarchical Access**: Super Admin > Admin > Editor > Viewer

### 2. Admin User Management
- Create, edit, and delete admin users
- Assign multiple roles to users
- Activate/deactivate user accounts
- Track last login time and IP address
- Password reset functionality

### 3. Security Features
- Protected Super Admin role (cannot be deleted or edited by non-super-admins)
- Middleware-based access control
- Active status checking (inactive users are automatically logged out)
- Password hashing with Laravel's built-in bcrypt
- Self-protection (users cannot delete/deactivate themselves)

## Database Structure

### Tables Created:
1. **roles** - Store role definitions
2. **permissions** - Store permission definitions
3. **role_user** - Many-to-many relationship between users and roles
4. **permission_role** - Many-to-many relationship between permissions and roles
5. **users** - Enhanced with `is_active`, `last_login_at`, `last_login_ip`

## Default Roles

### Super Admin
- **Full system access**
- Can manage all users, roles, and permissions
- Cannot be edited or deleted
- Has all permissions

### Admin
- Can manage products, categories, inquiries, and shipping
- Cannot manage users or roles
- Limited to operational tasks

### Editor
- Can edit products and categories
- Can view inquiries
- Cannot delete or manage shipping

### Viewer
- Read-only access to most areas
- Cannot make any changes
- Useful for reporting or monitoring

## Default Permissions

| Permission | Description |
|------------|-------------|
| manage_users | Create, edit, delete admin users |
| manage_roles | Manage roles and permissions |
| manage_products | Full product management |
| view_products | View products only |
| manage_categories | Full category management |
| view_categories | View categories only |
| manage_inquiries | Reply to inquiries |
| view_inquiries | View inquiries only |
| manage_shipping | Manage shipping settings |
| view_shipping | View shipping settings |
| manage_settings | System configuration |
| view_dashboard | Access dashboard |

## Middleware

### 1. `super_admin`
- Checks if user has the Super Admin role
- Usage: `Route::middleware('super_admin')`

### 2. `admin`
- Checks if user has any admin role
- Usage: `Route::middleware('admin')`

### 3. `role:role1,role2`
- Checks if user has any of the specified roles
- Usage: `Route::middleware('role:admin,editor')`

### 4. `permission:permission1,permission2`
- Checks if user has any of the specified permissions
- Usage: `Route::middleware('permission:manage_products,manage_categories')`

## Installation & Setup

### Step 1: Run Migrations
```bash
php artisan migrate
```

This will create all necessary tables.

### Step 2: Seed Initial Data
```bash
php artisan db:seed --class=RolesAndPermissionsSeeder
```

This creates:
- All default roles and permissions
- Super Admin user with credentials:
  - **Email**: admin@ecom.com
  - **Password**: password

**⚠️ IMPORTANT**: Change the Super Admin password immediately after first login!

### Step 3: Access Admin Panel
1. Login at: `/login`
2. Use the Super Admin credentials
3. Navigate to "Admin Users" in the sidebar
4. Create additional admin accounts as needed

## Usage Examples

### In Controllers
```php
// Check if user has a role
if (auth()->user()->hasRole('super_admin')) {
    // Super admin only code
}

// Check if user has any role
if (auth()->user()->hasAnyRole(['admin', 'editor'])) {
    // Code for admins or editors
}

// Check if user has a permission
if (auth()->user()->hasPermission('manage_products')) {
    // Can manage products
}

// Check if user is super admin
if (auth()->user()->isSuperAdmin()) {
    // Super admin code
}

// Check if user is any admin
if (auth()->user()->isAdmin()) {
    // Any admin code
}
```

### In Blade Templates
```blade
@if(auth()->user()->hasRole('super_admin'))
    <a href="{{ route('admin.users.index') }}">Manage Users</a>
@endif

@if(auth()->user()->hasPermission('manage_products'))
    <button>Create Product</button>
@endif

@if(auth()->user()->isSuperAdmin())
    <div>Super Admin Controls</div>
@endif
```

### In Routes
```php
// Super admin only routes
Route::middleware('super_admin')->group(function () {
    Route::resource('users', AdminUserController::class);
});

// Admin routes (any admin role)
Route::middleware('admin')->group(function () {
    Route::resource('products', ProductController::class);
});

// Specific role(s)
Route::middleware('role:admin,editor')->group(function () {
    Route::get('reports', [ReportController::class, 'index']);
});

// Specific permission(s)
Route::middleware('permission:manage_products')->group(function () {
    Route::post('products', [ProductController::class, 'store']);
});
```

## User Model Methods

### Role Methods
- `hasRole(string|array $roles): bool` - Check if user has role(s)
- `hasAnyRole(array $roles): bool` - Check if user has any of the roles
- `hasAllRoles(array $roles): bool` - Check if user has all roles
- `assignRole(Role|string $role): void` - Assign a role to user
- `removeRole(Role|string $role): void` - Remove a role from user
- `syncRoles(array $roles): void` - Sync user's roles
- `isSuperAdmin(): bool` - Check if user is super admin
- `isAdmin(): bool` - Check if user has any admin role

### Permission Methods
- `hasPermission(string $permission): bool` - Check if user has permission
- `hasAnyPermission(array $permissions): bool` - Check if user has any permission

### Query Scopes
- `User::active()` - Get only active users
- `User::inactive()` - Get only inactive users
- `User::admins()` - Get only users with admin roles

## Admin Routes

| Route | Method | Description |
|-------|--------|-------------|
| /admin/users | GET | List all admin users |
| /admin/users/create | GET | Show create user form |
| /admin/users | POST | Create new admin user |
| /admin/users/{user} | GET | Show user details |
| /admin/users/{user}/edit | GET | Edit user form |
| /admin/users/{user} | PUT | Update user |
| /admin/users/{user} | DELETE | Delete user |
| /admin/users/{user}/toggle-status | PATCH | Activate/deactivate user |
| /admin/users/{user}/reset-password | GET | Show password reset form |
| /admin/users/{user}/reset-password | PUT | Reset user password |
| /admin/roles | GET | List all roles |
| /admin/roles/create | GET | Create role form |
| /admin/roles | POST | Create new role |
| /admin/roles/{role} | GET | Show role details |
| /admin/roles/{role}/edit | GET | Edit role form |
| /admin/roles/{role} | PUT | Update role |
| /admin/roles/{role} | DELETE | Delete role |

## Security Best Practices

1. **Change Default Password**: Immediately change the Super Admin password after initial setup
2. **Use Strong Passwords**: Enforce Laravel's password rules (configured in validation)
3. **Regular Audits**: Monitor the last login information for suspicious activity
4. **Principle of Least Privilege**: Only assign permissions users actually need
5. **Regular Reviews**: Periodically review and deactivate unused admin accounts
6. **Role Separation**: Don't grant Super Admin to regular admins

## Troubleshooting

### Cannot Login as Admin
1. Check if user has any roles assigned
2. Verify user's `is_active` status is true
3. Check password is correct

### Permission Denied Errors
1. Verify user has required role/permission
2. Check middleware is correctly applied to routes
3. Ensure role has the required permissions assigned

### Cannot See Admin Users Menu
- Only Super Admin can see this menu
- Check if logged-in user has 'super_admin' role

## Extending the System

### Adding New Permissions
1. Create permission in database or seeder
2. Assign to appropriate roles
3. Use in middleware or controllers

### Creating Custom Roles
1. Navigate to "Roles & Permissions" in admin
2. Click "Add Role"
3. Select permissions
4. Save

### Adding Custom Middleware
1. Create middleware class
2. Register in `bootstrap/app.php`
3. Apply to routes as needed

## File Structure

```
app/
├── Models/
│   ├── User.php (Enhanced with roles/permissions)
│   ├── Role.php
│   └── Permission.php
├── Http/
│   ├── Controllers/Admin/
│   │   ├── AdminUserController.php
│   │   └── RoleController.php
│   └── Middleware/
│       ├── CheckRole.php
│       ├── CheckPermission.php
│       ├── IsSuperAdmin.php
│       └── IsAdmin.php
database/
├── migrations/
│   ├── 2026_02_03_000001_create_roles_table.php
│   ├── 2026_02_03_000002_create_permissions_table.php
│   ├── 2026_02_03_000003_create_role_user_table.php
│   ├── 2026_02_03_000004_create_permission_role_table.php
│   └── 2026_02_03_000005_add_admin_fields_to_users_table.php
└── seeders/
    └── RolesAndPermissionsSeeder.php
resources/
└── views/admin/
    ├── users/
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   ├── edit.blade.php
    │   ├── show.blade.php
    │   └── reset-password.blade.php
    └── roles/
        └── index.blade.php
```

## Support & Maintenance

For issues or questions:
1. Check the troubleshooting section
2. Review the code comments
3. Test with the default Super Admin account
4. Verify database migrations ran successfully

## Version History

- **v1.0** (2026-02-03): Initial implementation
  - Full RBAC system
  - Admin user management
  - Password management
  - Role & permission management
  - Complete UI with Tailwind CSS
