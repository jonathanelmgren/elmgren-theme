<?php
global $product;
if (is_string($product)) {
    $product = wc_get_product(get_the_ID());
}

if ($product && $product->get_image_id()) :
    $image_url = wp_get_attachment_image_url($product->get_image_id(), 'full');
?>
    <div class="w-full h-full aspect-h-1 aspect-w-1 overflow-hidden">
        <img data-product-image src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($product->get_name()); ?>" class="h-full w-full object-cover object-center">
    </div>

<?php
endif;
?>