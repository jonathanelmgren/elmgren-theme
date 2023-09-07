<?php
function elm_cart_totals_coupon_amount($coupon)
{
    if (is_string($coupon)) {
        $coupon = new WC_Coupon($coupon);
    }

    $discount_amount_html = '';

    $amount               = WC()->cart->get_coupon_discount_amount($coupon->get_code(), WC()->cart->display_cart_ex_tax);
    $discount_amount_html = '-' . wc_price($amount);

    if ($coupon->get_free_shipping() && empty($amount)) {
        $discount_amount_html = __('Free shipping coupon', 'woocommerce');
    }

    return $discount_amount_html;
}
?>

<?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
    <div class="flex items-center justify-between border-t border-gray-200 pt-4">
        <dt class="text-sm text-gray-600"><?php wc_cart_totals_coupon_label($coupon); ?></dt>
        <dd><?php elm_cart_totals_coupon_amount($coupon); ?> <?php get_template_part('templates/global/remove', null, ['href' => esc_url(add_query_arg('remove_coupon', rawurlencode($coupon->get_code()), defined('WOOCOMMERCE_CHECKOUT') ? wc_get_checkout_url() : wc_get_cart_url()))]) ?>
        </dd>
    </div>
<?php endforeach; ?>