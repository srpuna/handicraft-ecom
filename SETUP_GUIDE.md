# Quick Setup Guide - Admin Management System

## Installation Steps

### 1. Run Database Migrations
```bash
php artisan migrate
```

### 2. Seed Initial Roles, Permissions, and Super Admin
```bash
php artisan db:seed --class=RolesAndPermissionsSeeder
```

### 3. Login to Admin Panel

**Default Super Admin Credentials:**
- **Email**: `admin@ecom.com`
- **Password**: `password`

**Login URL**: `http://your-domain/login`

### 4. Change Default Password (CRITICAL!)

After logging in:
1. Click on "Admin Users" in the sidebar
2. Find the Super Admin user
3. Click "Edit" or "Reset Password"
4. Set a strong, secure password

## What Was Created

### ✅ Database Tables
- `roles` - Role definitions
- `permissions` - Permission definitions  
- `role_user` - User-Role associations
- `permission_role` - Role-Permission associations
- Enhanced `users` table with admin fields

### ✅ Models
- `Role` - With permission management methods
- `Permission` - Basic permission model
- Enhanced `User` - With role/permission checking methods

### ✅ Middleware
- `super_admin` - Super Admin access only
- `admin` - Any admin access
- `role:role1,role2` - Specific role(s) access
- `permission:perm1,perm2` - Specific permission(s) access

### ✅ Controllers
- `AdminUserController` - Manage admin users
- `RoleController` - Manage roles and permissions

### ✅ Views
- Admin user listing with search/filters
- Create/edit admin user forms
- User detail view
- Password reset form
- Roles management interface

### ✅ Default Roles Created
1. **Super Admin** - Full system access (all permissions)
2. **Admin** - Operational management
3. **Editor** - Content editing
4. **Viewer** - Read-only access

### ✅ Default Permissions Created
- manage_users, manage_roles
- manage_products, view_products
- manage_categories, view_categories
- manage_inquiries, view_inquiries
- manage_shipping, view_shipping
- manage_settings, view_dashboard

## Quick Test

1. **Login as Super Admin**
   ```
   Email: admin@ecom.com
   Password: password
   ```

2. **Navigate to Admin Users**
   - Click "Admin Users" in the sidebar

3. **Create a Test Admin**
   - Click "Add Admin User"
   - Fill in details
   - Assign roles (try "Admin" or "Editor")
   - Submit

4. **Test Permissions**
   - Logout and login with the new admin
   - Verify they can only access features their role allows
   - Verify they cannot see "Admin Users" menu (non-super-admin)

## Key Features to Test

### For Super Admin:
- ✅ Can see "Admin Users" menu
- ✅ Can create/edit/delete users
- ✅ Can activate/deactivate users
- ✅ Can reset passwords
- ✅ Can manage roles

### For Regular Admin:
- ❌ Cannot see "Admin Users" menu
- ✅ Can access dashboard
- ✅ Can manage products, categories, etc.
- ❌ Cannot manage users or roles

### Security Features:
- ✅ Cannot edit/delete Super Admin (non-super-admin)
- ✅ Cannot delete yourself
- ✅ Cannot deactivate yourself
- ✅ Inactive users are logged out automatically

## Common Commands

### Create Additional Permissions
```php
php artisan tinker

$permission = \App\Models\Permission::create([
    'name' => 'manage_reports',
    'display_name' => 'Manage Reports',
    'description' => 'Can generate and view reports'
]);
```

### Assign Permission to Role
```php
$role = \App\Models\Role::where('name', 'admin')->first();
$role->givePermissionTo('manage_reports');
```

### Create New Role
```php
$role = \App\Models\Role::create([
    'name' => 'manager',
    'display_name' => 'Manager',
    'description' => 'Store manager with limited access'
]);
```

### Assign Role to User
```php
$user = \App\Models\User::find(1);
$user->assignRole('manager');
```

## Troubleshooting

### Issue: Cannot login
**Solution**: Make sure you ran the seeder and user is active:
```bash
php artisan db:seed --class=RolesAndPermissionsSeeder
```

### Issue: Permission denied errors
**Solution**: Check user has correct role and role has correct permissions:
```php
// In tinker
$user = \App\Models\User::where('email', 'admin@ecom.com')->first();
$user->roles; // Check roles
$user->roles->first()->permissions; // Check permissions
```

### Issue: Middleware not working
**Solution**: Verify middleware is registered in `bootstrap/app.php`

### Issue: Cannot see Admin Users menu
**Solution**: Only Super Admin can see this. Verify user has 'super_admin' role:
```php
$user->hasRole('super_admin'); // Should return true
```

## Next Steps

1. ✅ Change Super Admin password
2. ✅ Create admin users for your team
3. ✅ Assign appropriate roles
4. ✅ Test permissions work as expected
5. ✅ Review and customize roles/permissions as needed
6. ✅ Add middleware to your existing routes
7. ✅ Implement permission checks in your controllers

## Documentation

For detailed documentation, see: [ADMIN_SYSTEM_DOCUMENTATION.md](ADMIN_SYSTEM_DOCUMENTATION.md)

## Security Reminders

⚠️ **CRITICAL SECURITY STEPS:**

1. **Change the default Super Admin password immediately!**
2. Use strong passwords for all admin accounts
3. Regularly review active admin users
4. Deactivate unused accounts
5. Monitor last login times for suspicious activity
6. Only grant Super Admin to trusted administrators
7. Follow the principle of least privilege

---

**System Status**: ✅ Ready to use!

If you encounter any issues, refer to the full documentation or check the troubleshooting section.
