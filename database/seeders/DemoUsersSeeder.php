<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin (already created, but ensure it exists)
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@ecom.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $superAdmin->assignRole('super_admin');

        // Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin.user@ecom.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $admin->assignRole('admin');

        // Editor User
        $editor = User::firstOrCreate(
            ['email' => 'editor@ecom.com'],
            [
                'name' => 'Editor User',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $editor->assignRole('editor');

        // Viewer User
        $viewer = User::firstOrCreate(
            ['email' => 'viewer@ecom.com'],
            [
                'name' => 'Viewer User',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $viewer->assignRole('viewer');

        $this->command->info('Demo users created successfully!');
        $this->command->info('');
        $this->command->info('=== LOGIN CREDENTIALS ===');
        $this->command->info('');
        $this->command->info('Super Admin (Full Access):');
        $this->command->info('  Email: admin@ecom.com');
        $this->command->info('  Password: password');
        $this->command->info('');
        $this->command->info('Admin (Product & Inquiry Management):');
        $this->command->info('  Email: admin.user@ecom.com');
        $this->command->info('  Password: password');
        $this->command->info('');
        $this->command->info('Editor (Edit Products & Categories):');
        $this->command->info('  Email: editor@ecom.com');
        $this->command->info('  Password: password');
        $this->command->info('');
        $this->command->info('Viewer (Read-Only Access):');
        $this->command->info('  Email: viewer@ecom.com');
        $this->command->info('  Password: password');
        $this->command->info('');
        $this->command->warn('IMPORTANT: Change these passwords after first login!');
    }
}
