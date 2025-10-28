<?php
    use Jenssegers\Agent\Agent;

    $agent = new Agent();
    $isDesktop = $agent->isDesktop();
    $isTablet = $agent->isTablet();
    
   
 $categoryId = $getCategorydetail['product_category'][0]->category_id ?? null;
 $categorySlug = $categoryId 
        ? DB::table('category_translations')
            ->where('category_id', $categoryId)
            ->where('locale', app()->getLocale()) // 'en', 'es', etc.
            ->value('name') 
        : 'not-available';

if (Auth::check()) {
    $date_of_birth = auth()->user()->date_of_birth;
} else {
    $guestToken = Session::token();
    $guestDob = DB::table('customers')
        ->where('token', $guestToken)
        ->value('date_of_birth');

    $date_of_birth = $guestDob;
}
        
?>

<input type="hidden" 
    id="userAge"    
        value="<?php echo e($date_of_birth ? \Carbon\Carbon::parse($date_of_birth)->age : ''); ?>"
   
>

<?php $__currentLoopData = $getCategorydetail['products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <div class="container product-card-new product-custom-class product-item"
        data-name="<?php echo e(strtolower($product['name'])); ?>">
        
        <div class="row my-4 ml-0 <?php if(($isDesktop || $isTablet) || (!$isDesktop && !$isTablet && $product['type'] != 'simple')): ?> align-items-center <?php endif; ?>"> 
            <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
            <div class="col-10 p-md-0 p-lg-0 pr-0">
                <div class="product-name no-padding custom-product-name">
                    <span class="fs16" id = "ProductName"><?php echo e($product['name']); ?></span>
                    <br />
                    <p><?php echo e($product['description']); ?></p>
                    <?php if($isDesktop || $isTablet): ?>
                    <?php if($product['isSaleable']): ?>
                    <?php if($product['type'] == 'simple'): ?>
                    <a id="category_instructions" data-toggle="collapse" class="m-0"
                        href="#category_instructions_Div<?php echo e($product['id']); ?>" role="button" aria-expanded="true"
                        aria-controls="category_instructions_Div">Special Instructions
                        (optional)
                        <span class="toggle-icon">-</span></a>
                    <div class="collapse multi-collapse mt-2 mb-2 show in" id="category_instructions_Div<?php echo e($product['id']); ?>">
                        <div id="category_instructions_Div" class="">
                            <textarea id="textarea-customize" name="special_instruction" placeholder="Add your special instructions here..."></textarea>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="AddToCartButton col-2 mt-0 mt-lg-2 mt-md-2 p-md-0 p-lg-0 pt-2">
                <input type="hidden" name="product_id" value="<?php echo e($product['id']); ?>" id="ProductId">
                <?php if($product['isSaleable']): ?>
                    <?php if($product['type'] == 'simple'): ?>
                        <quantity-changer :product-id="<?php echo e($product['id']); ?>"
                            :quantity-id="'quantity_' + <?php echo e($product['id']); ?>"
                            quantity-text="<?php echo e(__('shop::app.products.quantity')); ?>">
                        </quantity-changer> 
                        <div id="quantityError_<?php echo e($product['id']); ?>_<?php echo e($cate_id); ?>" class="text-danger quantityError_message"
                            style="color: red"></div>

                        <div class="AddButton text-center">
                            <button type="submit"
                                    class="add_button AddToCartButton"
                                    id="AddToCartButton"
                                    data="<?php echo e($product['type']); ?>"
                                    attr="<?php echo e($cate_id); ?>"
                                    data-category-slug="<?php echo e($product['product_categories']); ?>"
                                   
                                   
                                >Add</button>
                            <span id="successMessage_<?php echo e($product['id']); ?>_<?php echo e($cate_id); ?>"
                                class="text-success successMessage"></span>
                        </div>
                    <?php else: ?>
                        <div class="configurable_product">
                            <div class="AddButton text-center">
                                <input type="hidden" id="slug" value="<?php echo e($product['slug']); ?>">
                                <button type="button" data-toggle="modal"
                                    data-target="#exampleModal<?php echo e($product['id']); ?>_<?php echo e($cate_id); ?>"
                                    class="OptionsAddButton" id="AddToCartButtonpopup" data-category-slug="<?php echo e($product['product_categories']); ?>" >Add</button>
                                <span class="customisable">Customizable</span>
                                <br>
                                <span id="successMessage_<?php echo e($product['id']); ?>_<?php echo e($cate_id); ?>"
                                    class="text-success successMessage"></span>

                            </div>  
                            <!-- Modal -->
                            <div class="modal custom_modal fade"
                                id="exampleModal<?php echo e($product['id']); ?>_<?php echo e($cate_id); ?>" data="<?php echo e($product['id']); ?>" tabindex="-1"
                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog  modal-dialog-centered " role="document">
                                    <div class="modal-content pb-3">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Add To Cart</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body p-3">
                                            <span class="fs16 ProductName"
                                                id = "ProductName"><?php echo e($product['name']); ?></span>
                                            <br />
                                            <p class="description"><?php echo e($product['description']); ?></p>
                                            <quantity-changer :product-id="<?php echo e($product['id']); ?>"
                                                :quantity-id="'quantity_' + <?php echo e($product['id']); ?>"
                                                quantity-text="<?php echo e(__('shop::app.products.quantity')); ?>">
                                            </quantity-changer>
                                            
                                            <div id="quantityError_<?php echo e($product['id']); ?>_<?php echo e($cate_id); ?>"
                                                class="text-danger quantityError_message" style="color: red"></div>
                                            <div class="variant__option"></div>
                                        </div>


                                        <button type="submit" class="add_button mx-auto"
                                            data="<?php echo e($product['type']); ?>" id="Add_Button_Popop"
                                            attr="<?php echo e($cate_id); ?>">Add</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="AddButton text-center p-md-0 p-lg-0">
                        <button type="submit" class="stockoutButton" disabled>Out of stock</button>
                    </div>
                <?php endif; ?>  

            </div>
            <?php if(!$isDesktop && !$isTablet): ?>
            <?php if($product['isSaleable']): ?>
            <?php if($product['type'] == 'simple'): ?>
            <div class="category-instructions-div col-12 p-md-0 p-lg-0">
                <a id="category_instructions" data-toggle="collapse" class="m-0"
                    href="#category_instructions_Div<?php echo e($product['id']); ?>" role="button"
                    aria-expanded="false" aria-controls="category_instructions_Div">Special Instructions
                    (optional)
                    <span class="toggle-icon">-</span></a>
                <div class="collapse multi-collapse mb-2 mt-2 show in"
                    id="category_instructions_Div<?php echo e($product['id']); ?>">
                    <div id="category_instructions_Div" class="">
                        <textarea id="textarea-customize" name="special_instruction" placeholder="Add your special instructions here..."></textarea>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        <?php endif; ?>
        <?php endif; ?>
        </div>

    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php echo $__env->make('shop::search.agemodel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="pagination-wrapper">
    <?php echo $getCategorydetail['paginationHTML']; ?>

</div>
<?php /**PATH /home/ubuntu/volantiScottsdale/resources/themes/volantijetcatering/views/products/category-products/single-category-products.blade.php ENDPATH**/ ?>