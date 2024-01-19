<?php
$readonly = $args['readonly'] ?? false;
$cart_item = $args['cart_item'];
$cart_item_key = $args['cart_item_key'];
$product = $cart_item['data'];
$quantity = $cart_item['quantity'];
$variations = $cart_item['variation'] ?? [];
$parent = wc_get_product($product->get_parent_id());
$parent_name = $parent instanceof WC_Product ? $parent->get_name() : null;

$remove_link = sprintf(
    '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
    esc_url(wc_get_cart_remove_url($cart_item_key)),
    esc_attr(sprintf(__('Remove %s from cart', 'woocommerce'), wp_strip_all_tags($product->get_name()))),
    esc_attr($product->get_id()),
    esc_attr($product->get_sku())
);

$base_permalink = apply_filters('woocommerce_cart_item_permalink', $product->is_visible() ? $product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
$variation_query_args = array_filter($variations, fn ($key) => !str_contains($base_permalink, $key), ARRAY_FILTER_USE_KEY);
$product_permalink_with_variations = add_query_arg($variation_query_args, $base_permalink);

do_action('woocommerce_before_cart_item');

?>

<li class="flex py-6 sm:py-10">
    <div class="flex-shrink-0">
        <?php
        $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $product->get_image('woocommerce_thumbnail', ['class' => 'w-24 object-cover object-center sm:w-48']), $cart_item, $cart_item_key);

        if (!$product_permalink_with_variations) {
            echo $thumbnail; // PHPCS: XSS ok.
        } else {
            printf('<a href="%s">%s</a>', esc_url($product_permalink_with_variations), $thumbnail); // PHPCS: XSS ok.
        }
        ?> </div>
    <div class="ml-4 flex flex-1 flex-col justify-between sm:ml-6">
        <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
            <div>
                <div class="flex justify-between">
                    <h3 class="text-sm">
                        <a href="<?php echo esc_url($product_permalink_with_variations); ?>" class="text-gray-400 no-underline hover:underline">
                            <?php echo esc_html($parent_name ?? $product->get_name()); ?>
                        </a>
                    </h3>
                </div>
                <div class="mt-1 flex text-sm divide-x divide-theme-divider -mx-2">
                    <?php foreach ($variations as $variation) : ?>
                        <p class="text-gray-100 font-light px-2"><?php echo esc_html(ucfirst($variation)); ?></p>
                    <?php endforeach; ?>
                </div>
                <p class="mt-1 text-sm font-medium text-gray-400">
                    <?php echo WC()->cart->get_product_price($product); ?>
                </p>
            </div>
            <div class="mt-4 sm:mt-0 sm:pr-9">
                <form class="flex flex-col max-w-[4rem] gap-1" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
                    <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                    <?php if ($readonly) : ?>
                        <p>x<?php echo esc_html($quantity); ?></p>
                    <?php else : ?>
                        <input data-cart-qty-input type="number" value="<?php echo esc_attr($quantity); ?>" id="quantity-<?php echo esc_attr($cart_item_key); ?>" name="cart[<?php echo esc_attr($cart_item_key); ?>][qty]" class="py-1.5 text-sm border-lightgray-800" />
                        <button type="submit" class="hidden items-center no-style text-theme-a text-sm" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>">Update</button>
                    <?php endif; ?>
                </form>
                <?php if (!$readonly) : ?>
                    <div class="absolute right-0 top-0">
                        <?php get_template_part('templates/global/remove', null, ['href' => esc_url(wc_get_cart_remove_url($cart_item_key))]); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</li>

<?php do_action('woocommerce_after_cart_item'); ?>