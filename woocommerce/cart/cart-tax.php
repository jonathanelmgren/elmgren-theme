<?php
if (!wc_tax_enabled() || WC()->cart->display_prices_including_tax()) {
    return;
}

$taxable_address     = WC()->customer->get_taxable_address();
$is_outside_base      = WC()->customer->is_customer_outside_base() && !WC()->customer->has_calculated_shipping();
$tax_display_option  = get_option('woocommerce_tax_total_display');
$estimated_text      = $is_outside_base 
    ? sprintf('<small>%s</small>', esc_html(sprintf(__('(estimated for %s)', 'woocommerce'), WC()->countries->estimated_for_prefix($taxable_address[0]) . WC()->countries->countries[$taxable_address[0]])))
    : '';

// Action before displaying tax information
do_action('woocommerce_cart_totals_before_tax');

?>

<?php if ('itemized' === $tax_display_option) : ?>
    <?php foreach (WC()->cart->get_tax_totals() as $tax) : ?>
        <div class="flex items-center justify-between border-t border-theme-divider pt-4">
            <dt class="text-sm text-gray-600"><?= esc_html(apply_filters('woocommerce_cart_item_tax_label', $tax->label)) . $estimated_text; ?></dt>
            <dd class="text-sm text-gray-400"><?= wp_kses_post(apply_filters('woocommerce_cart_item_tax_amount', $tax->formatted_amount)); ?></dd>
        </div>
    <?php endforeach; ?>
<?php else : ?>
    <div class="flex items-center justify-between border-t border-theme-divider pt-4">
        <dt class="text-sm text-gray-600"><?= esc_html(apply_filters('woocommerce_cart_tax_or_vat_label', WC()->countries->tax_or_vat())) . $estimated_text; ?></dt>
        <dd class="text-sm text-gray-400"><?= apply_filters('woocommerce_cart_totals_taxes_total_html', wc_cart_totals_taxes_total_html()); ?></dd>
    </div>
<?php endif; ?>

<?php
// Action after displaying tax information
do_action('woocommerce_cart_totals_after_tax');
?>
