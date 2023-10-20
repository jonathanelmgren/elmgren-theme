<?php

if (!defined('ABSPATH')) {
	exit;
}

// Check if the user needs to be logged in to checkout
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
	echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
	return;
}

// Initialize order button text
$order_button_text = apply_filters('woocommerce_order_button_text', __('Place order', 'woocommerce'));

// Display breadcrumbs
woocommerce_breadcrumb();

?>
<form name="checkout" method="post" class="checkout woocommerce-checkout flex flex-col md:flex-row gap-8" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
	<?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>
	<div class="grow">
		<?php
		// Render billing and shipping forms if fields are available
		if ($checkout->get_checkout_fields()) :
			do_action('woocommerce_checkout_billing');
			do_action('woocommerce_checkout_shipping');
		endif;
		?>
	</div>
	<div id="order_review" class="woocommerce-checkout-review-order md:max-w-sm lg:max-w-md w-full">
		<h3><?php esc_html_e('Your order', 'woocommerce'); ?></h3>
		<div class="sticky top-5">
			<?php
			wc_get_template('checkout/review-order.php');
			wc_get_template('checkout/terms.php');
			?>
			<button type="submit" class="w-full mt-4<?= esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : '') ?>" name="woocommerce_checkout_place_order" id="place_order" value="<?= esc_attr($order_button_text) ?>" data-value="<?= esc_attr($order_button_text) ?>">
				<?= esc_html($order_button_text) ?>
			</button>
		</div>
	</div>
</form>
