

<?php $__env->startSection('header'); ?>
    <h2 class="text-2xl font-semibold text-gray-900">Site Settings</h2>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl">
    <div class="bg-white rounded-lg shadow-sm">
        <form action="<?php echo e(route('admin.settings.update')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <!-- General Settings Section -->
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">General Settings</h3>
                
                <div class="space-y-4">
                    <!-- Site Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Site Name</label>
                        <input type="text" name="site_name" 
                            value="<?php echo e(old('site_name', $siteName->value ?? 'LuxeStore')); ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <?php $__errorArgs = ['site_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- WhatsApp Number -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">WhatsApp Number</label>
                        <p class="text-xs text-gray-500 mb-2">Enter number with country code (e.g., 9779812345678 for Nepal)</p>
                        <input type="text" name="whatsapp_number" 
                            value="<?php echo e(old('whatsapp_number', $whatsappNumber->value ?? '')); ?>"
                            placeholder="9779812345678"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <?php $__errorArgs = ['whatsapp_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <!-- Logo Settings Section -->
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Logo Settings</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Navbar Logo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Navbar Logo</label>
                        <p class="text-xs text-gray-500 mb-3">Recommended: 200x60px (PNG with transparent background)</p>
                        
                        <?php if($navbarLogo && $navbarLogo->value): ?>
                            <div class="mb-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <img src="<?php echo e(asset('storage/' . $navbarLogo->value)); ?>" 
                                     alt="Current Navbar Logo" 
                                     class="h-16 w-auto object-contain mb-2">
                                <label class="flex items-center text-sm text-red-600 cursor-pointer">
                                    <input type="checkbox" name="remove_navbar_logo" value="1" class="mr-2">
                                    Remove current logo
                                </label>
                            </div>
                        <?php else: ?>
                            <div class="mb-3 p-4 bg-gray-50 rounded-lg border border-gray-200 text-center text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <p class="text-sm">No logo uploaded</p>
                            </div>
                        <?php endif; ?>
                        
                        <input type="file" name="navbar_logo" accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <?php $__errorArgs = ['navbar_logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Footer Logo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Footer Logo</label>
                        <p class="text-xs text-gray-500 mb-3">Recommended: 200x60px (PNG with transparent background)</p>
                        
                        <?php if($footerLogo && $footerLogo->value): ?>
                            <div class="mb-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <img src="<?php echo e(asset('storage/' . $footerLogo->value)); ?>" 
                                     alt="Current Footer Logo" 
                                     class="h-16 w-auto object-contain mb-2 bg-gray-800 p-2 rounded">
                                <label class="flex items-center text-sm text-red-600 cursor-pointer">
                                    <input type="checkbox" name="remove_footer_logo" value="1" class="mr-2">
                                    Remove current logo
                                </label>
                            </div>
                        <?php else: ?>
                            <div class="mb-3 p-4 bg-gray-50 rounded-lg border border-gray-200 text-center text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <p class="text-sm">No logo uploaded</p>
                            </div>
                        <?php endif; ?>
                        
                        <input type="file" name="footer_logo" accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <?php $__errorArgs = ['footer_logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Favicon Section -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="max-w-md">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Favicon</label>
                        <p class="text-xs text-gray-500 mb-3">Recommended: 32x32px or 64x64px (ICO, PNG, or SVG)</p>
                        
                        <?php if($favicon && $favicon->value): ?>
                            <div class="mb-3 p-4 bg-gray-50 rounded-lg border border-gray-200 flex items-center justify-between">
                                <div class="flex items-center">
                                    <img src="<?php echo e(asset('storage/' . $favicon->value)); ?>" 
                                         alt="Current Favicon" 
                                         class="h-8 w-8 object-contain mr-3">
                                    <span class="text-sm text-gray-600">Current favicon</span>
                                </div>
                                <label class="flex items-center text-sm text-red-600 cursor-pointer">
                                    <input type="checkbox" name="remove_favicon" value="1" class="mr-2">
                                    Remove
                                </label>
                            </div>
                        <?php else: ?>
                            <div class="mb-3 p-4 bg-gray-50 rounded-lg border border-gray-200 text-center text-gray-400">
                                <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01">
                                    </path>
                                </svg>
                                <p class="text-sm">No favicon uploaded</p>
                            </div>
                        <?php endif; ?>
                        
                        <input type="file" name="favicon" accept="image/*,.ico"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <?php $__errorArgs = ['favicon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="text-sm text-blue-700">
                            <p class="font-medium">Logo & Icon Tips:</p>
                            <ul class="mt-1 list-disc list-inside space-y-1">
                                <li>Use PNG format with transparent background for logos</li>
                                <li>Keep file size under 2MB for logos, 1MB for favicon</li>
                                <li>Favicon supports ICO, PNG, and SVG formats (32x32px or 64x64px)</li>
                                <li>The same logo can be used for both navbar and footer</li>
                                <li>If no logo is uploaded, the site name will be displayed instead</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- QR Code Section -->
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Footer QR Code</h3>
                <p class="text-sm text-gray-600 mb-4">Add a QR code to your footer (e.g., for social media, payment, or contact info)</p>
                
                <div class="max-w-md">
                    <label class="block text-sm font-medium text-gray-700 mb-2">QR Code Image</label>
                    <p class="text-xs text-gray-500 mb-3">Recommended: 300x300px or higher (PNG/JPG with good contrast)</p>
                    
                    <?php if($footerQrCode && $footerQrCode->value): ?>
                        <div class="mb-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img src="<?php echo e(asset('storage/' . $footerQrCode->value)); ?>" 
                                         alt="Current QR Code" 
                                         class="w-24 h-24 object-contain border border-gray-300 rounded mr-4 bg-white p-2">
                                    <span class="text-sm text-gray-600">Current QR Code</span>
                                </div>
                                <label class="flex items-center text-sm text-red-600 cursor-pointer">
                                    <input type="checkbox" name="remove_footer_qr_code" value="1" class="mr-2">
                                    Remove
                                </label>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="mb-3 p-4 bg-gray-50 rounded-lg border border-gray-200 text-center text-gray-400">
                            <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                                </path>
                            </svg>
                            <p class="text-sm">No QR code uploaded</p>
                        </div>
                    <?php endif; ?>
                    
                    <input type="file" name="footer_qr_code" accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <?php $__errorArgs = ['footer_qr_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    
                    <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex">
                            <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <div class="text-xs text-blue-700">
                                <p class="font-medium">QR Code Tips:</p>
                                <ul class="mt-1 list-disc list-inside space-y-0.5">
                                    <li>Use high contrast (dark QR on white background)</li>
                                    <li>Test QR code before uploading to ensure it scans correctly</li>
                                    <li>Square images work best (300x300px or larger)</li>
                                    <li>Common uses: WhatsApp, payment apps, social media, contact info</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Contact Info Section -->
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Footer Contact Information</h3>
                <p class="text-sm text-gray-600 mb-4">This information will be displayed in the website footer.</p>
                
                <div class="space-y-4">
                    <!-- Address -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Business Address</label>
                        <textarea name="footer_address" rows="3" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="Enter your business address..."><?php echo e(old('footer_address', $footerAddress->value ?? '')); ?></textarea>
                        <?php $__errorArgs = ['footer_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="text" name="footer_phone" 
                            value="<?php echo e(old('footer_phone', $footerPhone->value ?? '')); ?>"
                            placeholder="+977 1234567890"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <?php $__errorArgs = ['footer_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" name="footer_email" 
                            value="<?php echo e(old('footer_email', $footerEmail->value ?? '')); ?>"
                            placeholder="contact@example.com"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <?php $__errorArgs = ['footer_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Business Hours -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Business Hours</label>
                        <input type="text" name="footer_hours" 
                            value="<?php echo e(old('footer_hours', $footerHours->value ?? '')); ?>"
                            placeholder="Sun - Fri: 9:00 AM - 6:00 PM"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <?php $__errorArgs = ['footer_hours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <!-- Shipping Policy Section -->
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Shipping Policy</h3>
                <p class="text-sm text-gray-600 mb-4">This content will be displayed on the Shipping Policy page accessible from the footer.</p>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Policy Content</label>
                    <textarea name="shipping_policy" rows="12" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Enter your shipping policy content here..."><?php echo e(old('shipping_policy', $shippingPolicy->value ?? '')); ?></textarea>
                    <?php $__errorArgs = ['shipping_policy'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <p class="mt-2 text-xs text-gray-500">You can use plain text. Each new line will be preserved when displayed.</p>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="p-6 bg-gray-50">
                <button type="submit" 
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\My Files\Dev\ecom\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>