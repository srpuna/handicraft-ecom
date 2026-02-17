

<?php $__env->startSection('title', __('Error')); ?>

<?php $__env->startSection('message'); ?>
    <div style="font-size: 72px; font-weight: bold; margin-bottom: 20px;">
        <?php echo $__env->yieldContent('code'); ?>
    </div>
    <div style="font-size: 24px;">
        <?php if (! empty(trim($__env->yieldContent('message')))): ?>
            <?php echo $__env->yieldContent('message'); ?>
        <?php else: ?>
            An error occurred
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('errors::layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\My Files\Dev\ecom\resources\views/errors/minimal.blade.php ENDPATH**/ ?>