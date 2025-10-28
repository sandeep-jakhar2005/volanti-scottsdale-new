<?php if($crossSellProductsCount = $crossSellProducts->count()): ?>
    <card-list-header
        heading="<?php echo e(__('shop::app.products.cross-sell-title')); ?>"
        view-all="false"
        row-class="pt20"
    ></card-list-header>

    <div class="carousel-products vc-full-screen">
        <carousel-component
            slides-per-page="6"
            navigation-enabled="hide"
            pagination-enabled="hide"
            id="upsell-products-carousel"
            :slides-count="<?php echo e($crossSellProductsCount); ?>">
            
            <?php $__currentLoopData = $crossSellProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $crossSellProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <slide slot="slide-<?php echo e($index); ?>">
                    <?php echo $__env->make('shop::products.list.card', [
                        'product' => $crossSellProduct,
                        'addToCartBtnClass' => 'small-padding',
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </slide>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </carousel-component>
    </div>

    <div class="carousel-products vc-small-screen">
        <carousel-component
            :slides-count="<?php echo e($crossSellProductsCount); ?>"
            slides-per-page="2"
            id="upsell-products-carousel"
            navigation-enabled="hide"
            pagination-enabled="hide">

            <?php $__currentLoopData = $crossSellProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $crossSellProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <slide slot="slide-<?php echo e($index); ?>">
                    <?php echo $__env->make('shop::products.list.card', [
                        'product' => $crossSellProduct,
                        'addToCartBtnClass' => 'small-padding',
                    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </slide>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </carousel-component>
    </div>
<?php endif; ?>
<?php /**PATH /home/ubuntu/volantiScottsdale/resources/themes/volantijetcatering/views/products/view/cross-sells.blade.php ENDPATH**/ ?>