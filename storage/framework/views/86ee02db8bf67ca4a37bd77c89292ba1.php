<?php $__env->startSection('header'); ?>
    <nav class="text-sm text-gray-500">
        <a href="<?php echo e(route('admin.shipping.index')); ?>" class="hover:text-gray-700">Shipping</a>
        <span class="mx-2">→</span>
        <?php
            $tabLabel = 'Settings';
            if (($defaultTab ?? null) === 'zones') $tabLabel = 'Zone Settings';
            elseif (($defaultTab ?? null) === 'providers') $tabLabel = 'Provider Settings';
            elseif (($defaultTab ?? null) === 'rates') $tabLabel = 'Rates Settings';
        ?>
        <span class="font-medium text-gray-700"><?php echo e($tabLabel); ?></span>
    </nav>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Shipping Settings</h1>
        <p class="text-gray-600 mt-1">Manage shipping zones, providers, and rates</p>
    </div>

    <!-- Success/Error Messages -->
    <?php if(session('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <?php echo e(session('error')); ?>

    </div>
    <?php endif; ?>

    <!-- Alpine.js Tab Management -->
    <div x-data="{ activeTab: '<?php echo e($defaultTab ?? 'zones'); ?>' }">
        
        <!-- Tab Navigation -->
        <div class="bg-white rounded-lg shadow-sm mb-6 overflow-hidden">
            <nav class="flex border-b border-gray-200">
                <button @click="activeTab = 'zones'" 
                    :class="activeTab === 'zones' ? 'border-b-2 border-green-600 text-green-600 bg-green-50' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50'" 
                    class="flex-1 px-6 py-4 text-sm font-medium transition-all focus:outline-none">
                    <div class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Shipping Zones
                    </div>
                </button>
                
                <button @click="activeTab = 'providers'" 
                    :class="activeTab === 'providers' ? 'border-b-2 border-green-600 text-green-600 bg-green-50' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50'" 
                    class="flex-1 px-6 py-4 text-sm font-medium transition-all focus:outline-none">
                    <div class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                        </svg>
                        Providers
                    </div>
                </button>
                
                <button @click="activeTab = 'rates'" 
                    :class="activeTab === 'rates' ? 'border-b-2 border-green-600 text-green-600 bg-green-50' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50'" 
                    class="flex-1 px-6 py-4 text-sm font-medium transition-all focus:outline-none">
                    <div class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Shipping Rates
                    </div>
                </button>
            </nav>
        </div>

        <!-- Zones Tab -->
        <div x-show="activeTab === 'zones'" class="space-y-6">
            <!-- Create New Zone Form -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center mb-4">
                    <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <h2 class="text-xl font-semibold text-gray-800">Create New Shipping Zone</h2>
                </div>
                
                <form action="<?php echo e(route('admin.shipping.zones.store')); ?>" method="POST" class="space-y-4">
                    <?php echo csrf_field(); ?>
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
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        <h2 class="text-xl font-semibold text-gray-800">Bulk Country → Zone Mapping</h2>
                    </div>
                    <span class="text-xs text-gray-500">CSV columns: country, zone</span>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Export Mapping -->
                    <form action="<?php echo e(route('admin.shipping.zones.export')); ?>" method="GET" class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <?php echo csrf_field(); ?>
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
                    <form action="<?php echo e(route('admin.shipping.zones.import')); ?>" method="POST" enctype="multipart/form-data" class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <?php echo csrf_field(); ?>
                        <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0l-4 4m4-4v12"></path>
                            </svg>
                            Import Country → Zone CSV
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 items-end">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-medium text-gray-600 mb-1">CSV File *</label>
                                <input type="file" name="zones_file" accept=".csv" required class="w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-green-100 file:text-green-700 hover:file:bg-green-200">
                                <p class="text-xs text-gray-500 mt-1">Columns: country, zone (use exact zone name or 1-based index)</p>
                            </div>
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">Import CSV</button>
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
                        <a href="<?php echo e(route('admin.shipping.zones.template')); ?>" class="inline-block bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors text-sm font-medium">Download Template</a>
                    </div>
                </div>
            </div>

            <!-- Existing Zones List -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="bg-gradient-to-r from-green-50 to-green-100 px-6 py-4 border-b border-green-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-semibold text-gray-800">Shipping Zones</h2>
                        <span class="bg-green-600 text-white text-sm px-3 py-1 rounded-full font-medium">
                            <?php echo e($zones->count()); ?> <?php echo e($zones->count() === 1 ? 'Zone' : 'Zones'); ?>

                        </span>
                    </div>
                </div>
                
                <?php if($zones->count() > 0): ?>
                <div class="divide-y divide-gray-200">
                    <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo e($zone->name); ?></h3>
                                <div class="flex items-center text-sm text-gray-600 mb-3">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span><?php echo e(implode(', ', $zone->countries ?? [])); ?></span>
                                </div>
                                <div class="flex items-center text-xs text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <?php echo e($zone->rates->count()); ?> shipping <?php echo e($zone->rates->count() === 1 ? 'rate' : 'rates'); ?>

                                </div>
                            </div>
                            
                            <div class="flex gap-2 ml-4">
                                <a href="<?php echo e(route('admin.shipping.zones.edit', $zone)); ?>" 
                                    class="bg-blue-50 text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-100 transition-colors text-sm font-medium">
                                    Edit
                                </a>
                                <form action="<?php echo e(route('admin.shipping.zones.destroy', $zone)); ?>" method="POST" 
                                    onsubmit="event.preventDefault(); openDeleteModal(this, 'Enter your password to delete this zone and all associated rates.');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" 
                                        class="bg-red-50 text-red-600 px-4 py-2 rounded-lg hover:bg-red-100 transition-colors text-sm font-medium">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php else: ?>
                <div class="p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="mt-4 text-gray-500">No shipping zones created yet</p>
                    <p class="text-sm text-gray-400 mt-1">Create your first zone to start managing shipping rates</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Providers Tab -->
        <div x-show="activeTab === 'providers'" class="space-y-6">
            <!-- Create New Provider Form -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center mb-4">
                    <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <h2 class="text-xl font-semibold text-gray-800">Add Shipping Provider</h2>
                </div>
                
                <form action="<?php echo e(route('admin.shipping.providers.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="flex gap-4 items-end">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Provider Name *</label>
                            <input type="text" name="name" placeholder="e.g., FedEx, UPS, DHL, USPS" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            <p class="text-xs text-gray-500 mt-1">Enter the shipping carrier or provider name</p>
                        </div>
                        <button type="submit" 
                            class="bg-green-600 text-white px-6 py-2.5 rounded-lg hover:bg-green-700 transition-colors font-medium flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Provider
                        </button>
                    </div>
                </form>
            </div>

            <!-- Existing Providers List -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-4 border-b border-blue-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-semibold text-gray-800">Shipping Providers</h2>
                        <span class="bg-blue-600 text-white text-sm px-3 py-1 rounded-full font-medium">
                            <?php echo e($providers->count()); ?> <?php echo e($providers->count() === 1 ? 'Provider' : 'Providers'); ?>

                        </span>
                    </div>
                </div>
                
                <?php if($providers->count() > 0): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
                    <?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-4 border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center">
                                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-gray-900"><?php echo e($provider->name); ?></h3>
                            </div>
                        </div>
                        <div class="text-xs text-gray-600 bg-white rounded px-3 py-2">
                            <span class="font-medium"><?php echo e($provider->rates->count()); ?></span> shipping <?php echo e($provider->rates->count() === 1 ? 'rate' : 'rates'); ?> configured
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php else: ?>
                <div class="p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                    </svg>
                    <p class="mt-4 text-gray-500">No shipping providers added yet</p>
                    <p class="text-sm text-gray-400 mt-1">Add providers to configure shipping rates</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Rates Tab -->
        <div x-show="activeTab === 'rates'" class="space-y-6">
            <?php if($providers->count() > 0 && $zones->count() > 0): ?>
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">Bulk Shipping Rates</h2>
                        <span class="text-xs text-gray-500">Use CSV with columns: min_weight, max_weight, Zone 1, Zone 2, ...</span>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Export Rates -->
                        <form action="<?php echo e(route('admin.shipping.rates.export')); ?>" method="GET" class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Export Shipping Rate Details
                            </h3>
                            <div class="flex flex-col md:flex-row gap-3 items-end">
                                <div class="flex-1">
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Shipping Provider *</label>
                                    <select name="shipping_provider_id" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm">
                                        <option value="">Select Provider</option>
                                        <?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($provider->id); ?>"><?php echo e($provider->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                                    Export CSV
                                </button>
                            </div>
                        </form>

                        <!-- Import Rates -->
                        <form action="<?php echo e(route('admin.shipping.rates.import')); ?>" method="POST" enctype="multipart/form-data" class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <?php echo csrf_field(); ?>
                            <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0l-4 4m4-4v12"></path>
                                </svg>
                                Import Bulk Shipping Rates (Zones & Weights)
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 items-end">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Shipping Provider *</label>
                                    <select name="shipping_provider_id" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm">
                                        <option value="">Select Provider</option>
                                        <?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($provider->id); ?>"><?php echo e($provider->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">CSV File *</label>
                                    <input type="file" name="rates_file" accept=".csv" required
                                        class="w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-green-100 file:text-green-700 hover:file:bg-green-200">
                                </div>
                                <button type="submit"
                                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">
                                    Import CSV
                                </button>
                            </div>
                        </form>
                            <!-- Download Rates Template -->
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    CSV Template (Rates)
                                </h3>
                                <p class="text-xs text-gray-600 mb-3">Header: min_weight, max_weight, then current zone names.</p>
                                <a href="<?php echo e(route('admin.shipping.rates.template')); ?>" class="inline-block bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors text-sm font-medium">Download Template</a>
                            </div>
                    </div>
                </div>

                <?php
                    $shownProviders = isset($selectedProvider) ? collect([$selectedProvider]) : $providers;
                ?>
                <?php $__currentLoopData = $shownProviders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <!-- Provider Header -->
                    <div class="bg-gradient-to-r from-purple-50 to-purple-100 px-6 py-4 border-b border-purple-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="bg-purple-600 p-2 rounded-lg mr-3">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                                    </svg>
                                </div>
                                <h2 class="text-xl font-semibold text-gray-800"><?php echo e($provider->name); ?></h2>
                            </div>
                            <span class="bg-purple-600 text-white text-sm px-3 py-1 rounded-full font-medium">
                                <?php echo e($provider->rates->count()); ?> <?php echo e($provider->rates->count() === 1 ? 'Rate' : 'Rates'); ?>

                            </span>
                        </div>
                    </div>

                    <div class="p-6 space-y-6">
                        <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php 
                            $providerRates = $zone->rates->where('shipping_provider_id', $provider->id); 
                        ?>
                        
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <!-- Zone Header -->
                            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <h3 class="font-semibold text-gray-800"><?php echo e($zone->name); ?></h3>
                                    </div>
                                    <span class="text-xs text-gray-500 bg-white px-2 py-1 rounded">
                                        <?php echo e(implode(', ', $zone->countries ?? [])); ?>

                                    </span>
                                </div>
                            </div>

                            <div class="p-4">
                                <!-- Existing Rates -->
                                <?php if($providerRates->count() > 0): ?>
                                <div class="mb-4">
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Weight Range
                                                    </th>
                                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Shipping Price
                                                    </th>
                                                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                        Actions
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <?php $__currentLoopData = $providerRates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-4 py-3">
                                                        <div class="flex items-center text-sm text-gray-900">
                                                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                                                            </svg>
                                                            <span class="font-medium"><?php echo e($rate->min_weight); ?> kg</span>
                                                            <span class="mx-2 text-gray-400">→</span>
                                                            <span class="font-medium"><?php echo e($rate->max_weight); ?> kg</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <div class="flex items-center">
                                                            <span class="text-lg font-bold text-green-600">$<?php echo e(number_format($rate->price, 2)); ?></span>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3 text-right">
                                                        <div class="flex justify-end gap-2">
                                                            <a href="<?php echo e(route('admin.shipping.rates.edit', $rate)); ?>" 
                                                                class="bg-blue-50 text-blue-600 px-3 py-1.5 rounded hover:bg-blue-100 transition-colors text-sm font-medium">
                                                                Edit
                                                            </a>
                                                            <form action="<?php echo e(route('admin.shipping.rates.destroy', $rate)); ?>" method="POST" class="inline-block" 
                                                                onsubmit="event.preventDefault(); openDeleteModal(this, 'Enter your password to delete this shipping rate.');">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('DELETE'); ?>
                                                                <button type="submit" 
                                                                    class="bg-red-50 text-red-600 px-3 py-1.5 rounded hover:bg-red-100 transition-colors text-sm font-medium">
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php else: ?>
                                <div class="mb-4 text-center py-4 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                                    <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-sm text-gray-500 mt-2">No rates configured for <?php echo e($provider->name); ?> in this zone</p>
                                </div>
                                <?php endif; ?>

                                <!-- Add New Rate Form -->
                                <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-4 rounded-lg border border-gray-200">
                                    <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Add New Rate
                                    </h4>
                                    <form action="<?php echo e(route('admin.shipping.rates.store')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="shipping_zone_id" value="<?php echo e($zone->id); ?>">
                                        <input type="hidden" name="shipping_provider_id" value="<?php echo e($provider->id); ?>">
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 mb-1">Min Weight (kg) *</label>
                                                <input type="number" step="0.001" name="min_weight" placeholder="0.000" 
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm" required>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 mb-1">Max Weight (kg) *</label>
                                                <input type="number" step="0.001" name="max_weight" placeholder="5.000" 
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm" required>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 mb-1">Price ($) *</label>
                                                <input type="number" step="0.01" name="price" placeholder="10.00" 
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm" required>
                                            </div>
                                            <div class="flex items-end">
                                                <button type="submit" 
                                                    class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">
                                                    Add Rate
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No Rates Available</h3>
                    <p class="mt-2 text-sm text-gray-500">You need to create shipping zones and providers first before adding rates.</p>
                    <div class="mt-6 flex justify-center gap-3">
                        <button @click="activeTab = 'zones'" 
                            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">
                            Create Zones
                        </button>
                        <button @click="activeTab = 'providers'" 
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:blue-green-700 transition-colors text-sm font-medium">
                            Add Providers
                        </button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\My Files\Dev\ecom\resources\views/admin/shipping/index.blade.php ENDPATH**/ ?>