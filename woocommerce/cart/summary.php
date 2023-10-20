<dl class="space-y-4">
    <div class="flex items-center justify-between">
        <dt class="text-sm text-gray-600"><?php esc_attr_e('Subtotal', 'woocommerce'); ?></dt>
        <dd class="text-sm font-medium text-gray-400"><?php wc_cart_totals_subtotal_html(); ?></dd>
    </div>
    <?php wc_get_template('cart/cart-total-coupons.php') ?>
    <!-- Shipping Section -->
    <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
        <?php wc_cart_totals_shipping_html(); ?>
    <?php elseif (WC()->cart->needs_shipping() && 'yes' === get_option('woocommerce_enable_shipping_calc')) : ?>

        <div class="flex items-center justify-between border-t border-theme-divider pt-4">
            <dt class="text-sm text-gray-600"><?php esc_html_e('Shipping', 'woocommerce'); ?></dt>
            <dd class="text-sm text-gray-400">
                <?php woocommerce_shipping_calculator(); ?>
            </dd>
        </div>

    <?php endif; ?>
    <!-- Fees -->
    <?php foreach (WC()->cart->get_fees() as $fee) : ?>
        <div class="flex items-center justify-between border-t border-theme-divider pt-4">
            <dt class="text-sm text-gray-600"><?= esc_html($fee->name) ?></dt>
            <dd class="text-sm text-gray-400"><?php wc_cart_totals_fee_html($fee); ?></dd>
        </div>
    <?php endforeach; ?>
    <!-- Taxes -->
    <?php wc_get_template('cart/cart-tax.php') ?>
    <div class="flex items-center justify-between border-t border-theme-divider pt-4">
        <dt class="font-bold text-gray-400"><?= __('Total', 'woocommerce') ?></dt>
        <dd class="text-gray-400 flex flex-col"><?php wc_cart_totals_order_total_html(); ?></dd>
    </div>
</dl>