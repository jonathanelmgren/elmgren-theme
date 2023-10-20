<?php

/**
 * Shipping Calculator
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/shipping-calculator.php.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_shipping_calculator'); ?>

<form data-shipping-calculator action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post" style="display:none;">
	<section class="flex flex-col gap-2">
		<!-- Country Dropdown -->
		<?php if (apply_filters('woocommerce_shipping_calculator_enable_country', true)) : ?>
			<?php generate_country_dropdown(); ?>
		<?php endif; ?>

		<!-- State Input -->
		<?php if (!apply_filters('woocommerce_shipping_calculator_enable_state', true)) : ?>
			<?php generate_state_input(); ?>
		<?php endif; ?>

		<!-- City Input -->
		<?php if (apply_filters('woocommerce_shipping_calculator_enable_city', true)) : ?>
			<input type="text" class="w-full is-size-small" value="<?php echo esc_attr(WC()->customer->get_shipping_city()); ?>" placeholder="<?php esc_attr_e('City', 'woocommerce'); ?>" name="calc_shipping_city" id="calc_shipping_city" />
		<?php endif; ?>

		<!-- Postal Code Input -->
		<?php if (apply_filters('woocommerce_shipping_calculator_enable_postcode', true)) : ?>
			<input type="text" class="w-full is-size-small" value="<?php echo esc_attr(WC()->customer->get_shipping_postcode()); ?>" placeholder="<?php esc_attr_e('Postcode / ZIP', 'woocommerce'); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" />
		<?php endif; ?>

		<!-- Update Button -->
		<button type="submit" name="calc_shipping" value="1" class="w-full is-style-secondary is-size-small"><?php esc_html_e('Update', 'woocommerce'); ?></button>

		<?php wp_nonce_field('woocommerce-shipping-calculator', 'woocommerce-shipping-calculator-nonce'); ?>
	</section>
</form>

<?php do_action('woocommerce_after_shipping_calculator'); ?>

<?php
// Generate Country Dropdown
function generate_country_dropdown()
{
	$shipping_countries = WC()->countries->get_shipping_countries();
	$current_country = WC()->customer->get_shipping_country();

	echo '<select class="w-full is-size-small" name="calc_shipping_country" id="calc_shipping_country" rel="calc_shipping_state">';
	echo '<option value="default">' . esc_html__('Select a country / region&hellip;', 'woocommerce') . '</option>';

	foreach ($shipping_countries as $country_code => $country_name) {
		echo '<option value="' . esc_attr($country_code) . '"' . selected($current_country, $country_code, false) . '>' . esc_html($country_name) . '</option>';
	}

	echo '</select>';
}

// Generate State Input
function generate_state_input()
{
	$current_country = WC()->customer->get_shipping_country();
	$current_state = WC()->customer->get_shipping_state();
	$states = WC()->countries->get_states($current_country);

	if (is_array($states) && empty($states)) {
		echo '<input type="hidden" name="calc_shipping_state" id="calc_shipping_state" placeholder="' . esc_attr__('State / County', 'woocommerce') . '" />';
	} elseif (is_array($states)) {
		echo '<select name="calc_shipping_state" class="w-full is-size-small" id="calc_shipping_state" data-placeholder="' . esc_attr__('State / County', 'woocommerce') . '">';
		echo '<option value="">' . esc_html__('Select an option&hellip;', 'woocommerce') . '</option>';

		foreach ($states as $state_code => $state_name) {
			echo '<option value="' . esc_attr($state_code) . '" ' . selected($current_state, $state_code, false) . '>' . esc_html($state_name) . '</option>';
		}

		echo '</select>';
	} else {
		echo '<input type="text" class="w-full is-size-small" value="' . esc_attr($current_state) . '" placeholder="' . esc_attr__('State / County', 'woocommerce') . '" name="calc_shipping_state" id="calc_shipping_state" />';
	}
}
?>