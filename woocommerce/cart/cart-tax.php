<?php
if (!wc_tax_enabled() || WC()->cart->display_prices_including_tax()) {
    return;
}

$taxable_address = WC()->customer->get_taxable_address();
$estimated_text = WC()->customer->is_customer_outside_base() && !WC()->customer->has_calculated_shipping()
    ? sprintf(
        ' <small>%s</small>',
        esc_html(
            sprintf(
                __('(estimated for %s)', 'woocommerce'),
                WC()->countries->estimated_for_prefix($taxable_address[0]) . WC()->countries->countries[$taxable_address[0]]
            )
        )
    )
    : '';

$tax_display_option = get_option('woocommerce_tax_total_display');
?>

<?php if ('itemized' === $tax_display_option) : ?>
    <?php foreach (WC()->cart->get_tax_totals() as $tax) : ?>
        <div class="flex items-center justify-between border-t border-gray-200 pt-4">
            <dt class="text-sm text-gray-600"><?= esc_html($tax->label) . $estimated_text; ?></dt>
            <dd class="text-sm text-gray-900"><?= wp_kses_post($tax->formatted_amount); ?></dd>
        </div>
    <?php endforeach; ?>
<?php else : ?>
    <div class="flex items-center justify-between border-t border-gray-200 pt-4">
        <dt class="text-sm text-gray-600"><?= esc_html(WC()->countries->tax_or_vat()) . $estimated_text; ?></dt>
        <dd class="text-sm text-gray-900"><?= wc_cart_totals_taxes_total_html(); ?></dd>
    </div>
<?php endif; ?>