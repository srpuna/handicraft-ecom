#!/bin/bash

# AWS Server Update Script for E-commerce Application 
# Run this script after pulling from git

echo "=========================================="
echo "Starting Server Update Process..."
echo "=========================================="
echo ""

# 1. Clear all caches
echo "1. Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
echo "✓ Caches cleared"
echo ""

# 2. Run migrations
echo "2. Running database migrations..."
php artisan migrate --force
echo "✓ Migrations completed"
echo ""

# 3. Seed roles and permissions
echo "3. Seeding roles and permissions..."
php artisan db:seed --class=RolesAndPermissionsSeeder --force
echo "✓ Roles and permissions seeded"
echo ""

# 4. Seed demo users
echo "4. Creating demo users..."
php artisan db:seed --class=DemoUsersSeeder --force
echo "✓ Demo users created"
echo ""

# 5. Create storage link if not exists
echo "5. Creating storage symbolic link..."
php artisan storage:link
echo "✓ Storage link created"
echo ""

# 6. Set proper permissions
echo "6. Setting directory permissions..."
chmod -R 775 storage bootstrap/cache
echo "✓ Permissions set"
echo ""

# 7. Optimize for production
echo "7. Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "✓ Application optimized"
echo ""

echo "=========================================="
echo "Update Complete! 🎉"
echo "=========================================="
echo ""
echo "Login Credentials:"
echo "Super Admin: admin@ecom.com / password"
echo "Admin: admin.user@ecom.com / password"
echo "Editor: editor@ecom.com / password"
echo "Viewer: viewer@ecom.com / password"
echo ""
echo "⚠️  Remember to change default passwords!"
echo "=========================================="
