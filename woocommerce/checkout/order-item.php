<?php
$readonly = isset($args['readonly']) ? $args['readonly'] : false;
$cart_item = $args['cart_item'];
$cart_item_key = $args['cart_item_key'];
$product   = $cart_item['data'];
$quantity = $cart_item['quantity'];
$variations = $cart_item['variation'] ?? [];
$parent = wc_get_product($product->get_parent_id());
$parent_name = $parent instanceof WC_Product ? $parent->get_name() : null;

// Get product permalink base
$base_permalink = apply_filters('woocommerce_cart_item_permalink', $product->is_visible() ? $product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);

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

<li class="flex py-6">
    <div class="flex-shrink-0">
        <?php
        $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $product->get_image('woocommerce_thumbnail', ['class' => 'w-20']), $cart_item, $cart_item_key);

        if (!$product_permalink_with_variations) {
            echo $thumbnail; // PHPCS: XSS ok.
        } else {
            printf('<a href="%s">%s</a>', esc_url($product_permalink_with_variations), $thumbnail); // PHPCS: XSS ok.
        }
        ?>
    </div>

    <div class="ml-6 flex flex-1 flex-col">
        <div>
            <div class="flex justify-between">
                <h3 class="text-sm">
                    <a class="text-gray-400 no-underline hover:underline" href="<?= $product_permalink_with_variations ?>"><?= $parent_name ?? $product->get_name() ?></a>
                </h3>
            </div>
            <div class="mt-1 flex text-sm divide-x divide-theme-divider -mx-2">
                <?php foreach ($variations as $key => $variation) :  ?>
                    <p class="text-gray-100 font-light px-2"><?= ucfirst($variation) ?></p>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="flex flex-1 items-end justify-between pt-2">
            <p class="mt-1 text-sm font-medium text-gray-400"><?php echo WC()->cart->get_product_price($product) ?></p>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-700">x<?php echo $quantity ?></p>
            </div>
        </div>
    </div>
</li>