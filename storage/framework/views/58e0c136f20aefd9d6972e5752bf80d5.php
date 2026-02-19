<?php if($paginator->hasPages()): ?>
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center">
        
        <div class="flex flex-1 justify-center gap-3 sm:hidden">
            <?php if($paginator->onFirstPage()): ?>
                <span class="inline-flex items-center rounded-md border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-300">
                    <?php echo e(__('Previous')); ?>

                </span>
            <?php else: ?>
                <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" class="inline-flex items-center rounded-md border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:border-green-premium hover:text-green-premium">
                    <?php echo e(__('Previous')); ?>

                </a>
            <?php endif; ?>

            <?php if($paginator->hasMorePages()): ?>
                <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" class="inline-flex items-center rounded-md border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:border-green-premium hover:text-green-premium">
                    <?php echo e(__('Next')); ?>

                </a>
            <?php else: ?>
                <span class="inline-flex items-center rounded-md border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-300">
                    <?php echo e(__('Next')); ?>

                </span>
            <?php endif; ?>
        </div>

        
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-center">
            <div>
                <span class="inline-flex items-center gap-1">
                    
                    <?php if($paginator->onFirstPage()): ?>
                        <span aria-disabled="true" aria-label="<?php echo e(__('pagination.previous')); ?>" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-300">
                            <span aria-hidden="true">&lsaquo;</span>
                        </span>
                    <?php else: ?>
                        <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" aria-label="<?php echo e(__('pagination.previous')); ?>" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-700 hover:border-green-premium hover:text-green-premium">
                            &lsaquo;
                        </a>
                    <?php endif; ?>

                    
                    <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                        <?php if(is_string($element)): ?>
                            <span aria-disabled="true" class="inline-flex h-10 min-w-10 items-center justify-center rounded-lg border border-transparent px-3 text-sm font-medium text-gray-400">
                                <?php echo e($element); ?>

                            </span>
                        <?php endif; ?>

                        
                        <?php if(is_array($element)): ?>
                            <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($page == $paginator->currentPage()): ?>
                                    <span aria-current="page" class="inline-flex h-10 min-w-10 items-center justify-center rounded-lg border border-green-premium bg-green-premium px-3 text-sm font-semibold text-white">
                                        <?php echo e($page); ?>

                                    </span>
                                <?php else: ?>
                                    <a href="<?php echo e($url); ?>" aria-label="<?php echo e(__('Go to page :page', ['page' => $page])); ?>" class="inline-flex h-10 min-w-10 items-center justify-center rounded-lg border border-gray-200 bg-white px-3 text-sm font-medium text-gray-700 hover:border-green-premium hover:text-green-premium">
                                        <?php echo e($page); ?>

                                    </a>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    
                    <?php if($paginator->hasMorePages()): ?>
                        <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" aria-label="<?php echo e(__('pagination.next')); ?>" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-700 hover:border-green-premium hover:text-green-premium">
                            &rsaquo;
                        </a>
                    <?php else: ?>
                        <span aria-disabled="true" aria-label="<?php echo e(__('pagination.next')); ?>" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-300">
                            <span aria-hidden="true">&rsaquo;</span>
                        </span>
                    <?php endif; ?>
                </span>
            </div>
        </div>
    </nav>
<?php endif; ?>
<?php /**PATH C:\Users\DELL\Desktop\My Files\Dev\ecom\resources\views/vendor/pagination/tailwind.blade.php ENDPATH**/ ?>