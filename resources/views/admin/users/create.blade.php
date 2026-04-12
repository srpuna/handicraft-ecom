@extends('admin.layout')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-truffle-extra-dark">Create Admin User</h1>
        <p class="text-truffle-extra-dark mt-1">Add a new admin user to the system</p>
    </div>

    <!-- Form -->
    <div class="bg-cream rounded-lg shadow-sm p-6 max-w-2xl">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-truffle-extra-dark mb-2">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-2 border border-truffle-medium/30 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('name') border-red-500 @enderror">
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-truffle-extra-dark mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-2 border border-truffle-medium/30 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('email') border-red-500 @enderror">
                @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-truffle-extra-dark mb-2">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-2 border border-truffle-medium/30 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('password') border-red-500 @enderror">
                @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-truffle-extra-dark mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="w-full px-4 py-2 border border-truffle-medium/30 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>

            <!-- Roles -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-truffle-extra-dark mb-2">Roles</label>
                <div class="space-y-2">
                    @foreach($roles as $role)
                    <div class="flex items-center">
                        <input type="checkbox" name="roles[]" id="role_{{ $role->id }}" value="{{ $role->id }}"
                            {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}
                            class="h-4 w-4 text-green-premium focus:ring-green-500 border-truffle-medium/30 rounded">
                        <label for="role_{{ $role->id }}" class="ml-2 block text-sm text-truffle-extra-dark">
                            {{ $role->display_name }}
                            @if($role->description)
                            <span class="text-truffle-extra-dark text-xs ml-1">({{ $role->description }})</span>
                            @endif
                        </label>
                    </div>
                    @endforeach
                </div>
                @error('roles')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Active Status -->
            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" checked
                        class="h-4 w-4 text-green-premium focus:ring-green-500 border-truffle-medium/30 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-truffle-extra-dark">
                        Active (User can login)
                    </label>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3">
                <button type="submit" 
                    class="bg-green-premium text-white px-6 py-2 rounded-lg hover:bg-green-800 transition-colors">
                    Create Admin User
                </button>
                <a href="{{ route('admin.users.index') }}" 
                    class="bg-[#E8E2D2] text-truffle-extra-dark px-6 py-2 rounded-lg hover:bg-[#E8E2D2] transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
