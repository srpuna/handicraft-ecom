<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminUserController extends Controller
{
    /**
     * Display a listing of admin users.
     */
    public function index(Request $request)
    {
        $query = User::with('roles')->admins();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $admins = $query->latest()->paginate(15);

        return view('admin.users.index', compact('admins'));
    }

    /**
     * Show the form for creating a new admin user.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created admin user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['exists:roles,id'],
            'is_active' => ['boolean'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_active' => $request->boolean('is_active', true),
        ]);

        // Assign roles
        $user->roles()->attach($validated['roles']);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Admin user created successfully.');
    }

    /**
     * Display the specified admin user.
     */
    public function show(User $user)
    {
        $user->load('roles.permissions');
        $roles = Role::all();
        return view('admin.users.show', compact('user', 'roles'));
    }

    /**
     * Show the form for editing the specified admin user.
     */
    public function edit(User $user)
    {
        // Prevent non-super-admins from editing super admins
        if ($user->isSuperAdmin() && !auth()->user()->isSuperAdmin()) {
            abort(403, 'You cannot edit a Super Admin account.');
        }

        $roles = Role::all();
        $user->load('roles');
        
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified admin user.
     */
    public function update(Request $request, User $user)
    {
        // Prevent non-super-admins from editing super admins
        if ($user->isSuperAdmin() && !auth()->user()->isSuperAdmin()) {
            abort(403, 'You cannot edit a Super Admin account.');
        }

        // Prevent users from editing themselves out of super admin
        if ($user->id === auth()->id() && $user->isSuperAdmin()) {
            $requestedRoles = Role::whereIn('id', $request->roles ?? [])->pluck('name')->toArray();
            if (!in_array('super_admin', $requestedRoles)) {
                return back()->with('error', 'You cannot remove your own Super Admin role.');
            }
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['exists:roles,id'],
            'is_active' => ['boolean'],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        // Sync roles
        $user->roles()->sync($validated['roles']);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Admin user updated successfully.');
    }

    /**
     * Remove the specified admin user.
     */
    public function destroy(User $user)
    {
        // Prevent deletion of super admin by non-super-admin
        if ($user->isSuperAdmin() && !auth()->user()->isSuperAdmin()) {
            abort(403, 'You cannot delete a Super Admin account.');
        }

        // Prevent users from deleting themselves
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Admin user deleted successfully.');
    }

    /**
     * Toggle the active status of an admin user.
     */
    public function toggleStatus(User $user)
    {
        // Prevent deactivation of super admin by non-super-admin
        if ($user->isSuperAdmin() && !auth()->user()->isSuperAdmin()) {
            abort(403, 'You cannot deactivate a Super Admin account.');
        }

        // Prevent users from deactivating themselves
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot deactivate your own account.');
        }

        $user->update([
            'is_active' => !$user->is_active,
        ]);

        $status = $user->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Admin user {$status} successfully.");
    }

    /**
     * Show the form for resetting admin user password.
     */
    public function showResetPasswordForm(User $user)
    {
        // Prevent non-super-admins from resetting super admin passwords
        if ($user->isSuperAdmin() && !auth()->user()->isSuperAdmin()) {
            abort(403, 'You cannot reset a Super Admin password.');
        }

        return view('admin.users.reset-password', compact('user'));
    }

    /**
     * Reset the password for an admin user.
     */
    public function resetPassword(Request $request, User $user)
    {
        // Prevent non-super-admins from resetting super admin passwords
        if ($user->isSuperAdmin() && !auth()->user()->isSuperAdmin()) {
            abort(403, 'You cannot reset a Super Admin password.');
        }

        $validated = $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Password reset successfully.');
    }

    /**
     * Assign a role to an admin user (quick action).
     */
    public function assignRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $role = Role::findOrFail($validated['role_id']);

        // Prevent non-super-admins from assigning super_admin role
        if ($role->name === 'super_admin' && !auth()->user()->isSuperAdmin()) {
            return back()->with('error', 'You cannot assign the Super Admin role.');
        }

        // Avoid assigning to self restrictions: if assigning/removing affects current user super admin, handled separately
        if (!$user->hasRole($role->name)) {
            $user->roles()->attach($role->id);
        }

        return back()->with('success', 'Role assigned successfully.');
    }

    /**
     * Revoke a role from an admin user (quick action).
     */
    public function revokeRole(User $user, Role $role)
    {
        // Prevent non-super-admins from modifying super admin role
        if ($role->name === 'super_admin' && !auth()->user()->isSuperAdmin()) {
            return back()->with('error', 'You cannot revoke the Super Admin role.');
        }

        // Prevent users from removing their own Super Admin role
        if ($user->id === auth()->id() && $role->name === 'super_admin') {
            return back()->with('error', 'You cannot remove your own Super Admin role.');
        }

        $user->roles()->detach($role->id);

        return back()->with('success', 'Role revoked successfully.');
    }
}
