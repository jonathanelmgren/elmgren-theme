<?php
$readonly = isset($args['readonly']) ? $args['readonly'] : false;
$cart_item = $args['cart_item'];
$product   = $cart_item['data'];
$quantity = $cart_item['quantity'];
$variations = $cart_item['variation'] ?? [];
$parent = wc_get_product($product->get_parent_id());
$parent_name = $parent instanceof WC_Product ? $parent->get_name() : null;

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

<li class="flex py-6">
    <div class="flex-shrink-0">
        <?php echo $product->get_image('woocommerce_thumbnail', ['class' => 'w-20 rounded-md']) ?>
    </div>

    <div class="ml-6 flex flex-1 flex-col">
        <div class="flex">
            <div class="min-w-0 flex-1">
                <h4 class="text-sm">
                    <a href="<?= $product_permalink_with_variations ?>" class="font-medium text-gray-700 hover:text-gray-800"><?= $parent_name ?? $product->get_name() ?></a>
                </h4>
                <?php foreach ($variations as $variation) :  ?>
                    <p class="mt-1 text-sm text-gray-500"><?= ucfirst($variation) ?></p>
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