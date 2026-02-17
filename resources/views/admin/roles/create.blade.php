@extends('admin.layout')

@section('header')
    <h2 class="text-2xl font-semibold text-gray-900">Create New Role</h2>
@endsection

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-lg shadow-sm">
        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf

            <!-- Role Information -->
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Role Information</h3>
                
                <div class="space-y-4">
                    <!-- Display Name -->
                    <div>
                        <label for="display_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Display Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="display_name" id="display_name" 
                            value="{{ old('display_name') }}"
                            required
                            placeholder="e.g., Content Manager"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('display_name') border-red-500 @enderror">
                        @error('display_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- System Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            System Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" 
                            value="{{ old('name') }}"
                            required
                            placeholder="e.g., content_manager (lowercase, underscores only)"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent font-mono @error('name') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-gray-500">Use lowercase letters and underscores only. This cannot be changed later.</p>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea name="description" id="description" rows="3"
                            placeholder="Describe the purpose and responsibilities of this role..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Permissions -->
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Permissions</h3>
                <p class="text-sm text-gray-600 mb-4">Select the permissions this role should have</p>
                
                @if($permissions->count() > 0)
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @foreach($permissions as $permission)
                    <label class="flex items-start p-3 bg-gray-50 rounded-lg border border-gray-200 hover:bg-green-50 hover:border-green-300 cursor-pointer transition-colors">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                            {{ (is_array(old('permissions')) && in_array($permission->id, old('permissions'))) ? 'checked' : '' }}
                            class="mt-1 rounded border-gray-300 text-green-600 focus:ring-green-500">
                        <div class="ml-3 flex-1">
                            <div class="text-sm font-medium text-gray-900">{{ $permission->display_name }}</div>
                            @if($permission->description)
                            <div class="text-xs text-gray-600 mt-1">{{ $permission->description }}</div>
                            @endif
                            <div class="text-xs text-gray-500 mt-1 font-mono">{{ $permission->name }}</div>
                        </div>
                    </label>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8 bg-gray-50 rounded-lg">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">No permissions available in the system.</p>
                </div>
                @endif

                @error('permissions')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="p-6 bg-gray-50 flex items-center justify-between">
                <a href="{{ route('admin.roles.index') }}" 
                    class="px-4 py-2 text-gray-700 hover:text-gray-900 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                    Create Role
                </button>
            </div>
        </form>
    </div>

    <!-- Quick Tips -->
    <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
        <div class="flex">
            <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            <div class="text-sm text-blue-700">
                <p class="font-medium">Role Creation Tips:</p>
                <ul class="mt-1 list-disc list-inside space-y-1">
                    <li>System name must be unique and cannot be changed after creation</li>
                    <li>Use descriptive names that clearly indicate the role's purpose</li>
                    <li>Select only the minimum permissions required for the role</li>
                    <li>Common examples: content_manager, customer_support, inventory_manager</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-generate system name from display name
document.getElementById('display_name').addEventListener('input', function(e) {
    const nameInput = document.getElementById('name');
    if (!nameInput.value || nameInput.dataset.autoGenerated) {
        const systemName = e.target.value
            .toLowerCase()
            .replace(/[^a-z0-9\s]/g, '')
            .replace(/\s+/g, '_');
        nameInput.value = systemName;
        nameInput.dataset.autoGenerated = 'true';
    }
});

document.getElementById('name').addEventListener('input', function(e) {
    if (e.target.value) {
        delete e.target.dataset.autoGenerated;
    }
});
</script>
@endsection
