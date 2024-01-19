<?php

defined('ABSPATH') || exit;

if (!wp_doing_ajax()) {
	do_action('woocommerce_review_order_before_payment');
}
?>

<div id="payment" class="woocommerce-checkout-payment">
	<?php if (WC()->cart->needs_payment()) : ?>
		<div class="border-t border-theme-divider">
			<fieldset>
				<legend class="text-lg font-medium text-gray-400 mb-4">Payment method</legend>
				<div class="flex flex-row md:flex-col flex-wrap gap-4">
					<?php
					if (!empty($available_gateways)) {
						foreach ($available_gateways as $gateway) {
							wc_get_template('checkout/payment-method.php', ['gateway' => $gateway]);
						}
					} else {
						echo '<li>';
						$no_payment_methods_msg = WC()->customer->get_billing_country() 
							? esc_html__('Sorry, it seems that there are no available payment methods. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce') 
							: esc_html__('Please fill in your details above to see available payment methods.', 'woocommerce');

						wc_print_notice(apply_filters('woocommerce_no_available_payment_methods_message', $no_payment_methods_msg), 'notice');
						echo '</li>';
					}
					?>
				</div>
			</fieldset>
		</div>
	<?php endif; ?>
</div>
