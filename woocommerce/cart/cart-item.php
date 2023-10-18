<?php
$readonly = isset($args['readonly']) ? $args['readonly'] : false;
$cart_item = $args['cart_item'];
$cart_item_key = $args['cart_item_key'];
$product   = $cart_item['data'];
$quantity = $cart_item['quantity'];
$variations = $cart_item['variation'] ?? [];
$parent = wc_get_product($product->get_parent_id());
$parent_name = $parent instanceof WC_Product ? $parent->get_name() : null;
$remove_link = sprintf(
    '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
    esc_url(wc_get_cart_remove_url($cart_item_key)),
    /* translators: %s is the product name */
    esc_attr(sprintf(__('Remove %s from cart', 'woocommerce'), wp_strip_all_tags($product->get_name()))),
    esc_attr($product->get_id()),
    esc_attr($product->get_sku())
);

// Get product permalink base
$base_permalink = $product->get_permalink();

// Collect variations
$variation_query_args = [];
foreach ($variations as $key => $variation_value) {
    if (str_contains($base_permalink, $key)) {
        continue;
    }
    $variation_query_args[$key] = $variation_value;
}

// Construct the URL
$product_permalink_with_variations = add_query_arg($variation_query_args, $base_permalink);

?>

<li class="flex py-6 sm:py-10">
    <div class="flex-shrink-0">
        <?php echo $product->get_image('woocommerce_thumbnail', ['class' => 'h-24 w-24 rounded-md object-cover object-center sm:h-48 sm:w-48']) ?>
    </div>

    <div class="ml-4 flex flex-1 flex-col justify-between sm:ml-6">
        <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
            <div>
                <div class="flex justify-between">
                    <h3 class="text-sm">
                        <a href="<?= $product_permalink_with_variations ?>" class="font-medium text-gray-700 hover:text-gray-800"><?= $parent_name ?? $product->get_name() ?></a>
                    </h3>
                </div>
                <div class="mt-1 flex text-sm">
                    <?php foreach ($variations as $key => $variation) :  ?>
                        <p class="text-gray-500 [&:not(:first-child)]:border-l [&:not(:first-child)]:pl-2 [&:not(:first-child)]:ml-2"><?= ucfirst($variation) ?></p>
                    <?php endforeach; ?>
                </div>
                <p class="mt-1 text-sm font-medium text-gray-900"><?php echo WC()->cart->get_product_price($product) ?></p>
            </div>

            <div class="mt-4 sm:mt-0 sm:pr-9">
                <form class='flex flex-col max-w-[4rem] gap-1' action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
                    <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                    <?php if ($readonly) : ?>
                        <p>x<?php echo $quantity ?></p>
                    <?php else : ?>
                        <input data-cart-qty-input type="number" value="<?php echo $quantity ?>" id="quantity-<?php echo esc_attr($cart_item_key); ?>" name="cart[<?php echo esc_attr($cart_item_key); ?>][qty]" class="rounded-md border border-gray-300 py-1.5 text-left text-base font-medium leading-5 text-gray-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm" />
                        <button class="text-xs hidden items-center" type="submit" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>">Update</button>
                    <?php endif; ?>
                </form>
                <?php if (!$readonly) : ?>
                    <div class="absolute right-0 top-0">
                        <?php get_template_part('templates/global/remove', null, ['href' => esc_url(wc_get_cart_remove_url($cart_item_key))]) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</li>