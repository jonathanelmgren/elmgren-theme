<form id="add-to-cart" class='flex flex-col gap-4'>
    <?php
    global $product;

    $is_variable = $product->is_type('variable');
    $data_store = WC_Data_Store::load('product');

    if ($is_variable) :
        $attributes = $product->get_variation_attributes();

        $selected_attributes = [];
        foreach ($attributes as $attribute_name => $options) {
            $key = 'attribute_' . $attribute_name;
            if (isset($_GET[$key])) {
                $selected_attributes[$key] = $_GET[$key];
            }
        }
        $variant_id = $data_store->find_matching_product_variation($product, $selected_attributes);
        if ($variant_id > 0) {
            $product = wc_get_product($variant_id);
        }
    ?>

        <?php foreach ($attributes as $attribute_name => $options) : ?>
            <div data-product-attribute="<?php echo $attribute_name ?>">
                <fieldset>
                    <legend><?php echo wc_attribute_label($attribute_name); ?></legend>
                    <div class="mt-1 flex gap-4 box-border flex-wrap">
                        <?php foreach ($options as $option) :
                            $isActive = isset($selected_attributes['attribute_' . $attribute_name]) && $selected_attributes['attribute_' . $attribute_name] === $option;
                        ?>
                            <button data-attr-button type="button" class="border-theme-button-primary [&.active]:border-opacity-100 border-opacity-30 hover:border-opacity-60 no-style px-4 py-2 <?= $isActive ? 'active' : '' ?>">
                                <input <?= $isActive ? 'checked' : '' ?> type="radio" name="attribute_<?php echo esc_attr($attribute_name); ?>" value="<?php echo esc_attr($option); ?>" class="sr-only">
                                <p><?php echo ucfirst(esc_html($option)); ?></p>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </fieldset>
            </div>
        <?php endforeach; ?>

    <?php endif; ?>
    <div data-product-variant-price>
        <?= isset($variant_id) && $variant_id > 0 ? $product->get_price_html() : '' ?>
    </div>

    <div data-add-to-cart-container class="flex">
        <?php woocommerce_quantity_input(['classes' => ['max-w-[5rem] rounded-r-none border-theme-button-primary border-opacity-100 [&.disabled]:border-opacity-50', $is_variable && !$variant_id ? ' disabled' : '']]); ?>
        <button <?= $is_variable && !$variant_id ? 'disabled' : '' ?> type="submit" name="add-to-cart" value="<?= esc_attr($product->get_id()) ?>" class="rounded-l-none border-l-0">
            <?php _e('Add to cart', 'woocommerce') ?>
        </button>
    </div>
</form>