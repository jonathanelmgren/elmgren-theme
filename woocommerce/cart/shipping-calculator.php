<?php

/**
 * Shipping Calculator
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/shipping-calculator.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_shipping_calculator'); ?>

<form data-shipping-calculator action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post" style="display:none;">
	<section class="flex flex-col gap-2">
		<?php if (apply_filters('woocommerce_shipping_calculator_enable_country', true)) : ?>
			<select class="w-full is-size-small" name="calc_shipping_country" id="calc_shipping_country" rel="calc_shipping_state">
				<option value="default"><?php esc_html_e('Select a country / region&hellip;', 'woocommerce'); ?></option>
				<?php
				foreach (WC()->countries->get_shipping_countries() as $key => $value) {
					echo '<option value="' . esc_attr($key) . '"' . selected(WC()->customer->get_shipping_country(), esc_attr($key), false) . '>' . esc_html($value) . '</option>';
				}
				?>
			</select>
		<?php endif; ?>

		<?php if (!apply_filters('woocommerce_shipping_calculator_enable_state', true)) : ?>
			<?php
			$current_cc = WC()->customer->get_shipping_country();
			$current_r  = WC()->customer->get_shipping_state();
			$states     = WC()->countries->get_states($current_cc);

			if (is_array($states) && empty($states)) {
			?>
				<input type="hidden" name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php esc_attr_e('State / County', 'woocommerce'); ?>" />
			<?php
			} elseif (is_array($states)) {
			?>
				<select name="calc_shipping_state" class="w-full is-size-small" id="calc_shipping_state" data-placeholder="<?php esc_attr_e('State / County', 'woocommerce'); ?>">
					<option value=""><?php esc_html_e('Select an option&hellip;', 'woocommerce'); ?></option>
					<?php
					foreach ($states as $ckey => $cvalue) {
						echo '<option value="' . esc_attr($ckey) . '" ' . selected($current_r, $ckey, false) . '>' . esc_html($cvalue) . '</option>';
					}
					?>
				</select>
			<?php
			} else {
			?>
				<input type="text" class="w-full is-size-small" value="<?php echo esc_attr($current_r); ?>" placeholder="<?php esc_attr_e('State / County', 'woocommerce'); ?>" name="calc_shipping_state" id="calc_shipping_state" />
			<?php
			}
			?>
		<?php endif; ?>

		<?php if (apply_filters('woocommerce_shipping_calculator_enable_city', true)) : ?>
			<input type="text" class="w-full is-size-small" value="<?php echo esc_attr(WC()->customer->get_shipping_city()); ?>" placeholder="<?php esc_attr_e('City', 'woocommerce'); ?>" name="calc_shipping_city" id="calc_shipping_city" />
		<?php endif; ?>

		<?php if (apply_filters('woocommerce_shipping_calculator_enable_postcode', true)) : ?>
			<input type="text" class="w-full is-size-small" value="<?php echo esc_attr(WC()->customer->get_shipping_postcode()); ?>" placeholder="<?php esc_attr_e('Postcode / ZIP', 'woocommerce'); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" />
		<?php endif; ?>

		<button type="submit" name="calc_shipping" value="1" class="w-full is-style-secondary is-size-small"><?php esc_html_e('Update', 'woocommerce'); ?></button>
		<?php wp_nonce_field('woocommerce-shipping-calculator', 'woocommerce-shipping-calculator-nonce'); ?>
	</section>
</form>

<?php do_action('woocommerce_after_shipping_calculator'); ?>