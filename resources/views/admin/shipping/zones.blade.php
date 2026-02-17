@extends('admin.layout')

@section('header')
    <nav class="text-sm text-gray-500">
        <a href="{{ route('admin.shipping.index') }}" class="hover:text-gray-700">Shipping</a>
        <span class="mx-2">→</span>
        <span class="font-medium text-gray-700">Zone Settings</span>
    </nav>
@endsection

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Shipping Zone Settings</h1>
        <p class="text-gray-600 mt-1">Manage shipping zones and country assignments</p>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        {{ session('error') }}
    </div>
    @endif

    <!-- Create New Zone Form -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex items-center mb-4">
            <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <h2 class="text-xl font-semibold text-gray-800">Create New Shipping Zone</h2>
        </div>
        
        <form action="{{ route('admin.shipping.zones.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Zone Name *</label>
                    <input type="text" name="name" placeholder="e.g., North America, Europe, Asia Pacific" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                    <p class="text-xs text-gray-500 mt-1">A descriptive name for this shipping zone</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Countries *</label>
                    <input type="text" name="countries" placeholder="US, CA, MX" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                    <p class="text-xs text-gray-500 mt-1">Comma-separated country codes (e.g., US, CA, MX)</p>
                </div>
            </div>
            
            <div class="flex justify-end pt-2">
                <button type="submit" 
                    class="bg-green-600 text-white px-6 py-2.5 rounded-lg hover:bg-green-700 transition-colors font-medium flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create Zone
                </button>
            </div>
        </form>
    </div>

    <!-- Bulk Country-to-Zone CSV -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                <h2 class="text-xl font-semibold text-gray-800">Bulk Country → Zone Mapping</h2>
            </div>
            <span class="text-xs text-gray-500">CSV columns: country, zone</span>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Export Mapping -->
            <form action="{{ route('admin.shipping.zones.export') }}" method="GET" class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Export Country → Zone CSV
                </h3>
                <p class="text-xs text-gray-600 mb-3">Downloads all current country assignments by zone.</p>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">Export CSV</button>
            </form>

            <!-- Import Mapping -->
            <form action="{{ route('admin.shipping.zones.import') }}" method="POST" enctype="multipart/form-data" class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                @csrf
                <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0l-4 4m4-4v12"></path>
                    </svg>
                    Import Country → Zone CSV
                </h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">CSV File *</label>
                        <input type="file" name="zones_file" accept=".csv" required class="w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-green-100 file:text-green-700 hover:file:bg-green-200">
                        <p class="text-xs text-gray-500 mt-1">Columns: country, zone (use exact zone name or 1-based index)</p>
                    </div>
                    <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">Import CSV</button>
                </div>
            </form>

            <!-- Download Template -->
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    CSV Template
                </h3>
                <p class="text-xs text-gray-600 mb-3">Download a starter CSV with the required columns.</p>
                <a href="{{ route('admin.shipping.zones.template') }}" class="inline-block bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors text-sm font-medium">Download Template</a>
            </div>
        </div>
    </div>

    <!-- Existing Zones List -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-green-50 to-green-100 px-6 py-4 border-b border-green-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Shipping Zones</h2>
                <span class="bg-green-600 text-white text-sm px-3 py-1 rounded-full font-medium">
                    {{ $zones->count() }} {{ $zones->count() === 1 ? 'Zone' : 'Zones' }}
                </span>
            </div>
        </div>
        
        @if($zones->count() > 0)
        <div class="divide-y divide-gray-200">
            @foreach($zones as $zone)
            <div class="p-6 hover:bg-gray-50 transition-colors">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $zone->name }}</h3>
                        <div class="flex items-center text-sm text-gray-600 mb-3">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ implode(', ', $zone->countries ?? []) }}</span>
                        </div>
                        <div class="flex items-center text-xs text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $zone->rates->count() }} shipping {{ $zone->rates->count() === 1 ? 'rate' : 'rates' }}
                        </div>
                    </div>
                    
                    <div class="flex gap-2 ml-4">
                        <a href="{{ route('admin.shipping.zones.edit', $zone) }}" 
                            class="bg-blue-50 text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-100 transition-colors text-sm font-medium">
                            Edit
                        </a>
                        <form action="{{ route('admin.shipping.zones.destroy', $zone) }}" method="POST" 
                            onsubmit="event.preventDefault(); openDeleteModal(this, 'Enter your password to delete this zone and all associated rates.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="bg-red-50 text-red-600 px-4 py-2 rounded-lg hover:bg-red-100 transition-colors text-sm font-medium">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="mt-4 text-gray-500">No shipping zones created yet</p>
            <p class="text-sm text-gray-400 mt-1">Create your first zone to start managing shipping rates</p>
        </div>
        @endif
    </div>
</div>
@endsection
