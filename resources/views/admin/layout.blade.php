<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - {{ $siteSettings['site_name'] ?? 'Ecom' }}</title>
    @if(isset($siteSettings['favicon']) && $siteSettings['favicon']->value)
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $siteSettings['favicon']->value) }}">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col">
            <div class="h-16 flex items-center justify-center border-b border-gray-200 px-4">
                @if(isset($siteSettings['navbar_logo']) && $siteSettings['navbar_logo']->value)
                    <img src="{{ asset('storage/' . $siteSettings['navbar_logo']->value) }}" 
                         alt="{{ $siteSettings['site_name'] ?? 'LuxeStore' }} Admin" 
                         class="h-10 w-auto object-contain">
                @else
                    <h1 class="text-2xl font-bold text-green-600">{{ $siteSettings['site_name'] ?? 'LuxeStore' }} Admin</h1>
                @endif
            </div>

            <nav class="flex-1 overflow-y-auto py-4" x-data="{ shippingOpen: {{ request()->routeIs('admin.shipping.*') ? 'true' : 'false' }} }">
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center px-6 py-3 text-gray-600 hover:bg-green-50 hover:text-green-600 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-green-50 text-green-600 border-r-4 border-green-600' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                </path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.categories.index') }}"
                            class="flex items-center px-6 py-3 text-gray-600 hover:bg-green-50 hover:text-green-600 transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-green-50 text-green-600 border-r-4 border-green-600' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                            Categories
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.products.index') }}"
                            class="flex items-center px-6 py-3 text-gray-600 hover:bg-green-50 hover:text-green-600 transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-green-50 text-green-600 border-r-4 border-green-600' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Products
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.inquiries.index') }}"
                            class="flex items-center px-6 py-3 text-gray-600 hover:bg-green-50 hover:text-green-600 transition-colors {{ request()->routeIs('admin.inquiries.*') ? 'bg-green-50 text-green-600 border-r-4 border-green-600' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            Inquiries
                        </a>
                    </li>
                    <li>
                        <button @click="shippingOpen = !shippingOpen" type="button"
                            class="w-full flex items-center justify-between px-6 py-3 text-gray-600 hover:bg-green-50 hover:text-green-600 transition-colors {{ request()->routeIs('admin.shipping.*') ? 'bg-green-50 text-green-600 border-r-4 border-green-600' : '' }}">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0">
                                    </path>
                                </svg>
                                <span>Shipping Settings</span>
                            </div>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': shippingOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </li>
                    <!-- Nested Shipping submenu -->
                    @php($sidebarProviders = \App\Models\ShippingProvider::orderBy('name')->get())
                    <li class="ml-6" x-show="shippingOpen" x-transition>
                        <ul class="space-y-1 mt-1">
                            <li>
                                <a href="{{ route('admin.shipping.zones.settings') }}"
                                    class="flex items-center px-6 py-2 text-gray-600 hover:bg-green-50 hover:text-green-600 transition-colors {{ request()->routeIs('admin.shipping.zones.settings') ? 'bg-green-50 text-green-600 border-r-4 border-green-600' : '' }}">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064" /></svg>
                                    Zone Settings
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.shipping.providers.settings') }}"
                                    class="flex items-center px-6 py-2 text-gray-600 hover:bg-green-50 hover:text-green-600 transition-colors {{ request()->routeIs('admin.shipping.providers.settings') ? 'bg-green-50 text-green-600 border-r-4 border-green-600' : '' }}">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4v10h1" /></svg>
                                    Providers Settings
                                </a>
                            </li>
                            @foreach($sidebarProviders as $prov)
                            <li class="ml-4">
                                <a href="{{ route('admin.shipping.providers.show', $prov) }}"
                                    class="flex items-center px-6 py-2 text-gray-600 hover:bg-green-50 hover:text-green-600 transition-colors {{ request()->routeIs('admin.shipping.providers.show') && request()->route('provider')?->id == $prov->id ? 'bg-green-50 text-green-600 border-r-4 border-green-600' : '' }}">
                                    <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                                    {{ $prov->name }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('admin.blog.index') }}"
                            class="flex items-center px-6 py-3 text-gray-600 hover:bg-green-50 hover:text-green-600 transition-colors {{ request()->routeIs('admin.blog.*') ? 'bg-green-50 text-green-600 border-r-4 border-green-600' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                                </path>
                            </svg>
                            Blog Posts
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.settings.index') }}"
                            class="flex items-center px-6 py-3 text-gray-600 hover:bg-green-50 hover:text-green-600 transition-colors {{ request()->routeIs('admin.settings.*') ? 'bg-green-50 text-green-600 border-r-4 border-green-600' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Site Settings
                        </a>
                    </li>
                    @if(auth()->user()->isSuperAdmin())
                    <li>
                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center px-6 py-3 text-gray-600 hover:bg-green-50 hover:text-green-600 transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-green-50 text-green-600 border-r-4 border-green-600' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                            Admin Users
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.roles.index') }}"
                            class="flex items-center px-6 py-3 text-gray-600 hover:bg-green-50 hover:text-green-600 transition-colors {{ request()->routeIs('admin.roles.*') ? 'bg-green-50 text-green-600 border-r-4 border-green-600' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                            Roles & Permissions
                        </a>
                    </li>
                    @endif
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6">
                <div>
                    @yield('header')
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <div class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-gray-500">
                            @foreach(auth()->user()->roles as $role)
                                <span class="inline-block">{{ $role->display_name }}</span>{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        </div>
                    </div>
                    <div class="h-10 w-10 bg-green-100 rounded-full flex items-center justify-center text-green-600 font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-red-600 transition-colors" title="Logout">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto bg-gray-50 p-6">
                @if(session('success'))
                    <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Password Confirmation Modal for Delete Operations -->
    <div id="deletePasswordModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 text-center mt-4">Confirm Deletion</h3>
                <div class="mt-2 px-4">
                    <p class="text-sm text-gray-500 text-center" id="deleteModalMessage">
                        Enter your password to confirm this deletion.
                    </p>
                    <div class="mt-4">
                        <input type="password" id="deletePasswordInput" placeholder="Enter your password" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 border p-2">
                        <p id="deletePasswordError" class="mt-1 text-sm text-red-600 hidden">Incorrect password. Please try again.</p>
                    </div>
                    <div class="flex gap-2 justify-center mt-4">
                        <button type="button" onclick="closeDeleteModal()"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition">Cancel</button>
                        <button type="button" onclick="confirmDelete()" id="confirmDeleteBtn"
                            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Expose CSRF token globally for JS-based requests
        window.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let pendingDeleteForm = null;

        function openDeleteModal(form, message = 'Enter your password to confirm this deletion.') {
            pendingDeleteForm = form;
            document.getElementById('deleteModalMessage').textContent = message;
            document.getElementById('deletePasswordInput').value = '';
            document.getElementById('deletePasswordError').classList.add('hidden');
            document.getElementById('deletePasswordModal').classList.remove('hidden');
            document.getElementById('deletePasswordInput').focus();
        }

        function closeDeleteModal() {
            document.getElementById('deletePasswordModal').classList.add('hidden');
            pendingDeleteForm = null;
        }

        async function confirmDelete() {
            const password = document.getElementById('deletePasswordInput').value;
            const errorEl = document.getElementById('deletePasswordError');
            const confirmBtn = document.getElementById('confirmDeleteBtn');
            
            if (!password) {
                errorEl.textContent = 'Please enter your password.';
                errorEl.classList.remove('hidden');
                return;
            }

            confirmBtn.disabled = true;
            confirmBtn.textContent = 'Verifying...';

            try {
                const response = await fetch('{{ route("admin.verify-password") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': window.csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ password: password })
                });

                const data = await response.json();

                if (data.success) {
                    if (pendingDeleteForm) {
                        console.log('Submitting form:', pendingDeleteForm);
                        // Remove the onsubmit handler and submit
                        pendingDeleteForm.onsubmit = null;
                        pendingDeleteForm.submit();
                    } else {
                        console.error('No pending form found');
                        closeDeleteModal();
                    }
                } else {
                    errorEl.textContent = 'Incorrect password. Please try again.';
                    errorEl.classList.remove('hidden');
                    document.getElementById('deletePasswordInput').value = '';
                    document.getElementById('deletePasswordInput').focus();
                    confirmBtn.disabled = false;
                    confirmBtn.textContent = 'Delete';
                }
            } catch (error) {
                errorEl.textContent = 'An error occurred. Please try again.';
                errorEl.classList.remove('hidden');
            } finally {
                confirmBtn.disabled = false;
                confirmBtn.textContent = 'Delete';
            }
        }

        // Handle Enter key in password input
        document.getElementById('deletePasswordInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                confirmDelete();
            }
        });

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });
    </script>

</body>

</html>