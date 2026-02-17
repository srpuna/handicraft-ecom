@extends('admin.layout')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Admin User Details</h1>
            <p class="text-gray-600 mt-1">View detailed information about this admin user</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.users.edit', $user) }}" 
                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                Edit User
            </a>
            <a href="{{ route('admin.users.index') }}" 
                class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">
                Back to List
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- User Information -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">User Information</h2>
                
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-16 w-16 bg-green-100 rounded-full flex items-center justify-center">
                            <span class="text-green-600 font-semibold text-2xl">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                        <div class="ml-4">
                            <div class="text-lg font-medium text-gray-900">{{ $user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <dl class="grid grid-cols-1 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
                                    @if($user->is_active)
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                    @else
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                    @endif
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Last Login</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $user->last_login_at ? $user->last_login_at->format('F d, Y - H:i:s') : 'Never logged in' }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Last Login IP</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $user->last_login_ip ?? 'N/A' }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Account Created</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $user->created_at->format('F d, Y - H:i:s') }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $user->updated_at->format('F d, Y - H:i:s') }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Permissions -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Permissions</h2>
                
                @php
                    $allPermissions = $user->roles->flatMap(function($role) {
                        return $role->permissions;
                    })->unique('id');
                @endphp

                @if($allPermissions->count() > 0)
                <div class="grid grid-cols-2 gap-3">
                    @foreach($allPermissions as $permission)
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <div class="text-sm font-medium text-gray-900">{{ $permission->display_name }}</div>
                            @if($permission->description)
                            <div class="text-xs text-gray-500">{{ $permission->description }}</div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500 text-sm">No permissions assigned.</p>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Roles -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Roles</h2>
                
                @if($user->roles->count() > 0)
                <div class="space-y-2">
                    @foreach($user->roles as $role)
                    <div class="p-3 rounded-lg {{ $role->name === 'super_admin' ? 'bg-purple-50 border border-purple-200' : 'bg-blue-50 border border-blue-200' }}">
                        <div class="font-medium {{ $role->name === 'super_admin' ? 'text-purple-800' : 'text-blue-800' }}">
                            {{ $role->display_name }}
                        </div>
                        @if($role->description)
                        <div class="text-xs {{ $role->name === 'super_admin' ? 'text-purple-600' : 'text-blue-600' }} mt-1">
                            {{ $role->description }}
                        </div>
                        @endif
                        <div class="text-xs {{ $role->name === 'super_admin' ? 'text-purple-500' : 'text-blue-500' }} mt-1">
                            {{ $role->permissions->count() }} permissions
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500 text-sm">No roles assigned.</p>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Quick Actions</h2>
                
                <div class="space-y-2">
                    @if(auth()->user()->isSuperAdmin() && $user->id !== auth()->id())
                    <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm bg-yellow-50 text-yellow-700 rounded-lg hover:bg-yellow-100 transition-colors">
                            {{ $user->is_active ? 'Deactivate Account' : 'Activate Account' }}
                        </button>
                    </form>

                    <a href="{{ route('admin.users.reset-password', $user) }}" 
                        class="block px-4 py-2 text-sm bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition-colors">
                        Reset Password
                    </a>

                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" 
                        onsubmit="event.preventDefault(); openDeleteModal(this, 'Enter your password to delete this admin user.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-colors">
                            Delete Account
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
