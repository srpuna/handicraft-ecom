@extends('admin.layout')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Roles & Permissions</h1>
            <p class="text-gray-600 mt-1">Manage roles and their associated permissions</p>
        </div>
        <a href="{{ route('admin.roles.create') }}"
            class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Role
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
    @endif

    <!-- Roles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($roles as $role)
        <div class="bg-white rounded-lg shadow-sm p-6 {{ $role->name === 'super_admin' ? 'border-2 border-purple-200' : '' }}">
            <!-- Role Header -->
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-xl font-semibold {{ $role->name === 'super_admin' ? 'text-purple-700' : 'text-gray-800' }}">
                        {{ $role->display_name }}
                    </h3>
                    @if($role->description)
                    <p class="text-sm text-gray-500 mt-1">{{ $role->description }}</p>
                    @endif
                </div>
                @if($role->name === 'super_admin')
                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                    System
                </span>
                @endif
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="bg-gray-50 rounded-lg p-3">
                    <div class="text-sm text-gray-500">Users</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $role->users_count }}</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-3">
                    <div class="text-sm text-gray-500">Permissions</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $role->permissions_count }}</div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-2 pt-4 border-t">
                <a href="{{ route('admin.roles.show', $role) }}" 
                    class="flex-1 text-center bg-blue-50 text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-100 transition-colors text-sm font-medium">
                    View Details
                </a>
                
                @if($role->name !== 'super_admin')
                <a href="{{ route('admin.roles.edit', $role) }}" 
                    class="flex-1 text-center bg-green-50 text-green-600 px-4 py-2 rounded-lg hover:bg-green-100 transition-colors text-sm font-medium">
                    Edit
                </a>

                @if($role->users_count === 0)
                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" 
                    onsubmit="event.preventDefault(); openDeleteModal(this, 'Enter your password to delete this role.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                        class="bg-red-50 text-red-600 px-4 py-2 rounded-lg hover:bg-red-100 transition-colors text-sm font-medium">
                        Delete
                    </button>
                </form>
                @endif
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
