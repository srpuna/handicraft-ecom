@extends('admin.layout')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Role Details</h1>
            <p class="text-gray-600 mt-1">View role information and permissions</p>
        </div>
        <div class="flex gap-2">
            @if($role->name !== 'super_admin')
            <a href="{{ route('admin.roles.edit', $role) }}" 
                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                Edit Role
            </a>
            @endif
            <a href="{{ route('admin.roles.index') }}" 
                class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">
                Back to Roles
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Role Information -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Role Information</h2>
                
                <div class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Display Name</dt>
                        <dd class="mt-1 text-lg font-semibold {{ $role->name === 'super_admin' ? 'text-purple-700' : 'text-gray-900' }}">
                            {{ $role->display_name }}
                            @if($role->name === 'super_admin')
                            <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                System Role
                            </span>
                            @endif
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">System Name</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-mono bg-gray-50 px-3 py-2 rounded">
                            {{ $role->name }}
                        </dd>
                    </div>

                    @if($role->description)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Description</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $role->description }}
                        </dd>
                    </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4 pt-4 border-t">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Created</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $role->created_at->format('M d, Y - H:i') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $role->updated_at->format('M d, Y - H:i') }}
                            </dd>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permissions -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">
                    Permissions
                    <span class="text-sm font-normal text-gray-500 ml-2">({{ $role->permissions->count() }})</span>
                </h2>
                
                @if($role->permissions->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach($role->permissions as $permission)
                    <div class="flex items-start p-3 bg-green-50 rounded-lg border border-green-100">
                        <svg class="w-5 h-5 text-green-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="flex-1">
                            <div class="text-sm font-medium text-gray-900">{{ $permission->display_name }}</div>
                            @if($permission->description)
                            <div class="text-xs text-gray-600 mt-1">{{ $permission->description }}</div>
                            @endif
                            <div class="text-xs text-gray-500 mt-1 font-mono">{{ $permission->name }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">No permissions assigned to this role.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Statistics -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Statistics</h2>
                
                <div class="space-y-4">
                    <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                        <div class="text-sm text-blue-600 font-medium">Users with this role</div>
                        <div class="text-3xl font-bold text-blue-900 mt-1">{{ $role->users->count() }}</div>
                    </div>

                    <div class="bg-green-50 rounded-lg p-4 border border-green-100">
                        <div class="text-sm text-green-600 font-medium">Total permissions</div>
                        <div class="text-3xl font-bold text-green-900 mt-1">{{ $role->permissions->count() }}</div>
                    </div>
                </div>
            </div>

            <!-- Users with this role -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">
                    Users
                    <span class="text-sm font-normal text-gray-500 ml-2">({{ $role->users->count() }})</span>
                </h2>
                
                @if($role->users->count() > 0)
                <div class="space-y-2">
                    @foreach($role->users as $user)
                    <a href="{{ route('admin.users.show', $user) }}" 
                        class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex-shrink-0 h-10 w-10 bg-green-100 rounded-full flex items-center justify-center">
                            <span class="text-green-600 font-semibold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                        <div class="ml-3 flex-1">
                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $user->email }}</div>
                        </div>
                        <div>
                            @if($user->is_active)
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Active
                            </span>
                            @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                Inactive
                            </span>
                            @endif
                        </div>
                    </a>
                    @endforeach
                </div>
                @else
                <div class="text-center py-6">
                    <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">No users assigned to this role.</p>
                </div>
                @endif
            </div>

            <!-- Actions -->
            @if($role->name !== 'super_admin')
            <div class="bg-white rounded-lg shadow-sm p-6 mt-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Actions</h2>
                
                <div class="space-y-2">
                    <a href="{{ route('admin.roles.edit', $role) }}" 
                        class="block w-full text-center px-4 py-2 text-sm bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition-colors">
                        Edit Role
                    </a>

                    @if($role->users->count() === 0)
                    <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" 
                        onsubmit="event.preventDefault(); openDeleteModal(this, 'Enter your password to delete this role.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 text-sm bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-colors">
                            Delete Role
                        </button>
                    </form>
                    @else
                    <div class="px-4 py-2 text-xs bg-yellow-50 text-yellow-700 rounded-lg text-center">
                        Cannot delete role with assigned users
                    </div>
                    @endif
                </div>
            </div>
            @else
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 mt-6">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-purple-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3">
                        <p class="text-sm text-purple-700 font-medium">System Role</p>
                        <p class="text-xs text-purple-600 mt-1">
                            This is a protected system role and cannot be modified or deleted.
                        </p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
