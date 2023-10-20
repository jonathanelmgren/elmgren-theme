<?php
function elm_cart_totals_coupon_amount($coupon)
{
    if (is_string($coupon)) {
        $coupon = new WC_Coupon($coupon);
    }

    $amount = WC()->cart->get_coupon_discount_amount($coupon->get_code(), WC()->cart->display_cart_ex_tax);
    $discount_amount_html = '-' . wc_price($amount);

    if ($coupon->get_free_shipping() && empty($amount)) {
        $discount_amount_html = __('Free shipping coupon', 'woocommerce');
    }

    return apply_filters('elm_cart_totals_coupon_amount_html', $discount_amount_html, $coupon);
}
?>

<?php
// Action before displaying coupons
do_action('woocommerce_cart_totals_before_coupons');
?>

<?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
    <div class="flex items-center justify-between border-t border-theme-divider pt-4">
        <dt class="text-sm text-gray-600">
            <?= esc_html(apply_filters('woocommerce_cart_totals_coupon_label', wc_cart_totals_coupon_label($coupon), $coupon)); ?>
        </dt>
        <dd class="flex items-center gap-2 text-sm">
            <div>
                <?= elm_cart_totals_coupon_amount($coupon); ?>
            </div>
            <?php
            $remove_url = esc_url(add_query_arg('remove_coupon', rawurlencode($coupon->get_code()), defined('WOOCOMMERCE_CHECKOUT') ? wc_get_checkout_url() : wc_get_cart_url()));
            get_template_part('templates/global/remove', null, ['href' => $remove_url]);
            ?>
        </dd>
    </div>
<?php endforeach; ?>

<?php
// Action after displaying coupons
do_action('woocommerce_cart_totals_after_coupons');
?>