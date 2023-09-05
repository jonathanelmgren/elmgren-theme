<form id="add-to-cart" class='flex flex-col gap-4'>
    <?php
    global $product;

    $is_variable = $product->is_type('variable');
    if ($is_variable) :
        $attributes = $product->get_variation_attributes();
    ?>

        <?php foreach ($attributes as $attribute_name => $options) : ?>
            <div data-product-attribute="<?php echo $attribute_name ?>" class="sm:flex sm:justify-between">
                <fieldset>
                    <legend class="block text-sm font-medium text-gray-700"><?php echo wc_attribute_label($attribute_name); ?></legend>
                    <div class="mt-1 flex gap-4 box-border">
                        <?php foreach ($options as $option) : ?>
                            <button data-attr-button type="button" class="block cursor-pointer rounded border-lightgray-600 border-2 p-4 [&.active]:border-primary">
                                <input type="radio" name="<?php echo esc_attr($attribute_name); ?>" value="<?php echo esc_attr($option); ?>" class="sr-only">
                                <p class="text-base font-medium text-gray-900"><?php echo ucfirst(esc_html($option)); ?></p>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </fieldset>
            </div>
        <?php endforeach; ?>

    <?php endif; ?>

    <div class="flex">
        <?php woocommerce_quantity_input(['classes' => 'max-w-[5rem] rounded-l border-gray-300']); ?>
        <button <?php echo $is_variable ? 'disabled' : '' ?> type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="bg-primary rounded-r hover:bg-primary-600 text-white px-8">
            <?php _e('Add to cart', 'woocommerce') ?>
        </button>
    </div>
</form>