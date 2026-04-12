@extends('admin.layout')

@section('header')
    <h2 class="font-semibold text-xl text-truffle-extra-dark leading-tight">
        Dashboard
    </h2>
@endsection

@php
    use Illuminate\Support\Facades\Cache;
@endphp

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <a href="{{ route('admin.products.index') }}"
            class="bg-cream rounded-lg shadow p-6 border-l-4 border-green-500 hover:shadow-lg hover:scale-[1.02] transition-all duration-200 block">
            <h3 class="text-truffle-extra-dark text-sm font-medium uppercase">Total Products</h3>
            <p class="text-3xl font-bold text-truffle-extra-dark mt-2">{{ $totalProducts ?? 0 }}</p>
        </a>
        <a href="{{ route('admin.categories.index') }}"
            class="bg-cream rounded-lg shadow p-6 border-l-4 border-yellow-500 hover:shadow-lg hover:scale-[1.02] transition-all duration-200 block">
            <h3 class="text-truffle-extra-dark text-sm font-medium uppercase">Total Categories</h3>
            <p class="text-3xl font-bold text-truffle-extra-dark mt-2">{{ $totalCategories ?? 0 }}</p>
        </a>
        <a href="{{ route('admin.orders.index', ['type' => 'inquiry']) }}"
            class="bg-cream rounded-lg shadow p-6 border-l-4 border-blue-500 hover:shadow-lg hover:scale-[1.02] transition-all duration-200 block">
            <h3 class="text-truffle-extra-dark text-sm font-medium uppercase">Total Inquiries</h3>
            <p class="text-3xl font-bold text-truffle-extra-dark mt-2">{{ $totalInquiries ?? 0 }}</p>
        </a>
    </div>

    <!-- Maintenance Mode Toggle -->
    <div class="col-span-1 md:col-span-3 mb-6 bg-cream rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-medium text-truffle-extra-dark">System Status</h3>
                <p class="text-sm text-truffle-extra-dark mt-1">
                    Current Status:
                    @if(Cache::get('maintenance_mode'))
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            Maintenance Mode
                        </span>
                    @else
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-premium/20 text-green-800">
                            Live
                        </span>
                    @endif
                </p>
            </div>
            <button onclick="document.getElementById('maintenanceModal').classList.remove('hidden')"
                class="bg-gray-800 text-white px-4 py-2 rounded shadow hover:bg-gray-700 transition">
                {{ Cache::get('maintenance_mode') ? 'Disable Maintenance' : 'Enable Maintenance' }}
            </button>
        </div>
    </div>

    <!-- Modal -->
    <div id="maintenanceModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-cream">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-truffle-extra-dark">Confirm Action</h3>
                <div class="mt-2 px-1">
                    <p class="text-sm text-truffle-extra-dark">
                        Enter your password to {{ Cache::get('maintenance_mode') ? 'disable' : 'enable' }} maintenance mode.
                    </p>
                    <form action="{{ route('admin.maintenance.toggle') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="password" name="password" placeholder="Confirm Password" required
                            class="w-full rounded-md border-truffle-medium/30 shadow-sm focus:border-green-500 focus:ring-green-500 border p-2 mb-4">
                        <div class="flex gap-2 justify-center">
                            <button type="button"
                                onclick="document.getElementById('maintenanceModal').classList.add('hidden')"
                                class="bg-[#E8E2D2] text-truffle-extra-dark px-4 py-2 rounded hover:bg-[#C5A059]">Cancel</button>
                            <button type="submit"
                                class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-cream rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-truffle-extra-dark mb-4">Recent Activity</h3>
        <p class="text-truffle-extra-dark">No recent activity.</p>
    </div>
@endsection
