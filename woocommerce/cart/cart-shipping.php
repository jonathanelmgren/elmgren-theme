<?php
// Initialize variables
$formatted_destination    = $formatted_destination ?? WC()->countries->get_formatted_address($package['destination'], ', ');
$has_calculated_shipping  = !empty($has_calculated_shipping);
$show_shipping_calculator = !empty($show_shipping_calculator);
$calculator_text          = '';
?>

<!-- Shipping Section -->
<?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>

    <?php do_action('woocommerce_cart_totals_before_shipping'); ?>

    <!-- Shipping Methods -->
    <div class="flex items-center justify-between pt-4 relative">
        <dt class="text-sm text-gray-600"><?= wp_kses_post($package_name); ?></dt>
        <dd class="text-sm text-gray-400">
            <?php if ($available_methods) : ?>
                <div class="woocommerce-shipping-methods">
                    <?php foreach ($available_methods as $method) : ?>
                        <div class="flex items-center">
                            <?php
                            if (1 < count($available_methods)) {
                                printf('<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method mr-2" %4$s />', $index, esc_attr(sanitize_title($method->id)), esc_attr($method->id), checked($method->id, $chosen_method, false));
                            } else {
                                printf('<input type="hidden" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" />', $index, esc_attr(sanitize_title($method->id)), esc_attr($method->id));
                            }
                            printf('<label for="shipping_method_%1$s_%2$s">%3$s</label>', $index, esc_attr(sanitize_title($method->id)), wc_cart_totals_shipping_method_label($method));
                            ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <?= esc_html__('Please enter your address to view shipping options.', 'woocommerce'); ?>
            <?php endif; ?>

            <?php if ($show_shipping_calculator) : ?>
                <?= sprintf('<button type="button" data-shipping-calculator-button class="no-style text-theme-a">%s</button>', esc_html($button_text ?? __('Calculate', 'woocommerce'))); ?>
            <?php endif; ?>
        </dd>
    </div>

    <?php if ($show_shipping_calculator) : ?>
        <?php woocommerce_shipping_calculator($calculator_text); ?>
    <?php endif; ?>

    <!-- Shipping Destination Information -->
    <?php if (is_cart() && $formatted_destination) : ?>
        <p class="text-sm text-gray-600">
            <?= printf(esc_html__('Shipping to %s.', 'woocommerce'), '<strong>' . esc_html($formatted_destination) . '</strong>'); ?>
        </p>
    <?php endif; ?>

    <?php do_action('woocommerce_cart_totals_after_shipping'); ?>

<?php elseif (WC()->cart->needs_shipping() && 'yes' === get_option('woocommerce_enable_shipping_calc')) : ?>

    <div class="flex items-center justify-between border-t border-theme-divider pt-4">
        <dt class="text-sm text-gray-600"><?= esc_html__('Shipping', 'woocommerce'); ?></dt>
        <dd class="text-sm text-gray-400">
            <?php woocommerce_shipping_calculator(); ?>
        </dd>
    </div>

<?php endif; ?>