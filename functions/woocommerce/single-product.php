<?php

function elm_localize_product_variations()
{
    global $product;

    if (is_string($product)) {
        $product = wc_get_product(get_the_ID());
    }

    if (!$product instanceof WC_Product || !$product->is_type('variable')) {
        return;
    }

    $available_variations = $product->get_available_variations();

    wp_localize_script('elm-main-js', 'productVariations', ['availableVariations' => $available_variations]);
}
add_action('wp_enqueue_scripts', 'elm_localize_product_variations');
