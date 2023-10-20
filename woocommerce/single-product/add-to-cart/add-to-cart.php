<?php
global $product;

$isVariableProduct = $product->is_type('variable');
$dataStore = WC_Data_Store::load('product');

if ($isVariableProduct) {
    $attributes = $product->get_variation_attributes();
    $selectedAttributes = getSelectedAttributesFromGetRequest($attributes);

    $variantId = $dataStore->find_matching_product_variation($product, $selectedAttributes);
    if ($variantId > 0) {
        $product = wc_get_product($variantId);
    }
}

function getSelectedAttributesFromGetRequest(array $attributes): array
{
    $selectedAttributes = [];
    foreach ($attributes as $attributeName => $options) {
        $key = 'attribute_' . $attributeName;
        if (isset($_GET[$key])) {
            $selectedAttributes[$key] = $_GET[$key];
        }
    }
    return $selectedAttributes;
}

?>

<form id="add-to-cart" class="flex flex-col gap-4 border-t-2 border-theme-divider pt-4">
    <?php if ($isVariableProduct) : ?>
        <?php foreach ($attributes as $attributeName => $options) : ?>
            <div data-product-attribute="<?php echo $attributeName ?>">
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

    <p class="text-lg text-gray-400 sm:text-xl" data-product-variant-price>
        <?php wc_get_template('single-product/price.php'); ?>
    </p>

    <div data-add-to-cart-container class="flex">
        <?php woocommerce_quantity_input([
            'classes' => [
                'max-w-[4rem]',
                'rounded-r-none',
                'border-theme-button-primary',
                'border-opacity-100',
                $isVariableProduct && !$variantId ? 'disabled' : ''
            ]
        ]); ?>
        <button <?= $isVariableProduct && !$variantId ? 'disabled' : '' ?> type="submit" name="add-to-cart" value="<?= esc_attr($product->get_id()) ?>" class="rounded-l-none border-l-0" style="--elm_button_padding_inline: 2.5rem">
            <?php _e('Add to cart', 'woocommerce'); ?>
        </button>
    </div>
</form>