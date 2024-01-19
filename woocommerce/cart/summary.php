<dl class="space-y-4">
    <!-- Subtotal -->
    <?php render_summary_item(__('Subtotal', 'woocommerce'), WC()->cart->get_cart_subtotal()); ?>

    <!-- Coupons -->
    <?php wc_get_template('cart/cart-total-coupons.php'); ?>

    <!-- Shipping Section -->
    <?php render_shipping_section(); ?>

    <!-- Fees -->
    <?php foreach (WC()->cart->get_fees() as $fee) : ?>
        <?php render_summary_item(esc_html($fee->name), wc_cart_totals_fee_html($fee)); ?>
    <?php endforeach; ?>

    <!-- Taxes -->
    <?php wc_get_template('cart/cart-tax.php'); ?>

    <!-- Total -->
    <div class="flex items-start justify-between border-t border-theme-divider pt-4">
        <dt class="font-bold text-gray-400"><?= __('Total', 'woocommerce'); ?></dt>
        <dd class="text-gray-400 flex flex-col items-end"><?php wc_cart_totals_order_total_html(); ?></dd>
    </div>
</dl>

<?php
// Render summary item
function render_summary_item($title, $value)
{
    echo '<div class="flex items-center justify-between">';
    echo '<dt class="text-sm text-gray-600">' . esc_attr($title) . '</dt>';
    echo '<dd class="text-sm font-medium text-gray-400">' . $value . '</dd>';
    echo '</div>';
}

// Render shipping section
function render_shipping_section()
{
    if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) {
        wc_cart_totals_shipping_html();
    } elseif (WC()->cart->needs_shipping() && 'yes' === get_option('woocommerce_enable_shipping_calc')) {
        render_summary_item(
            __('Shipping', 'woocommerce'),
            woocommerce_shipping_calculator()
        );
    }
}
?>