<?php

/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if (!defined('ABSPATH')) {
	exit;
}

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
	echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
	return;
}

$order_button_text = apply_filters('woocommerce_order_button_text', __('Place order', 'woocommerce'));

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout flex flex-col md:flex-row gap-8" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
	<?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>
	<div class="grow">
		<?php if ($checkout->get_checkout_fields()) : ?>
			<?php do_action('woocommerce_checkout_billing'); ?>
			<?php do_action('woocommerce_checkout_shipping'); ?>
		<?php endif; ?>
	</div>

	<div id="order_review" class="woocommerce-checkout-review-order md:max-w-sm lg:max-w-md w-full">
		<h3>
			<?php esc_html_e('Your order', 'woocommerce'); ?>
		</h3>
		<div class='sticky top-5'>
			<?php wc_get_template('checkout/review-order.php') ?>
			<?php wc_get_template('checkout/terms.php'); ?>
			<?php echo apply_filters('woocommerce_order_button_html', '<button type="submit" class="w-full py-2 text-white mt-4 bg-primary button alt' . esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : '') . '" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr($order_button_text) . '" data-value="' . esc_attr($order_button_text) . '">' . esc_html($order_button_text) . '</button>'); // @codingStandardsIgnoreLine 
			?>
		</div>
	</div>
</form>