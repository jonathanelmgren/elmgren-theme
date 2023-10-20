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

<form action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">

	<?php printf('<button type="button" data-shipping-calculator-button class="no-style text-theme-color-a">%s</button>', esc_html(!empty($button_text) ? $button_text : __('Calculate', 'woocommerce'))); ?>

	<section data-shipping-calculator class="absolute left-0 right-0 top-full p-3 bg-lightgray flex-col gap-2 hidden">

		<?php if (apply_filters('woocommerce_shipping_calculator_enable_country', true)) : ?>
			<p id="calc_shipping_country_field">
				<label for="calc_shipping_country" class="sr-only"><?php esc_html_e('Country / region:', 'woocommerce'); ?></label>
				<select class="py-1 m-0 w-full" name="calc_shipping_country" id="calc_shipping_country" rel="calc_shipping_state">
					<option value="default"><?php esc_html_e('Select a country / region&hellip;', 'woocommerce'); ?></option>
					<?php
					foreach (WC()->countries->get_shipping_countries() as $key => $value) {
						echo '<option value="' . esc_attr($key) . '"' . selected(WC()->customer->get_shipping_country(), esc_attr($key), false) . '>' . esc_html($value) . '</option>';
					}
					?>
				</select>
			</p>
		<?php endif; ?>

		<?php if (!apply_filters('woocommerce_shipping_calculator_enable_state', true)) : ?>
			<p id="calc_shipping_state_field">
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
					<span>
						<label for="calc_shipping_state" class="sr-only"><?php esc_html_e('State / County:', 'woocommerce'); ?></label>
						<select name="calc_shipping_state" class="py-1 m-0 w-full" id="calc_shipping_state" data-placeholder="<?php esc_attr_e('State / County', 'woocommerce'); ?>">
							<option value=""><?php esc_html_e('Select an option&hellip;', 'woocommerce'); ?></option>
							<?php
							foreach ($states as $ckey => $cvalue) {
								echo '<option value="' . esc_attr($ckey) . '" ' . selected($current_r, $ckey, false) . '>' . esc_html($cvalue) . '</option>';
							}
							?>
						</select>
					</span>
				<?php
				} else {
				?>
					<label for="calc_shipping_state" class="sr-only"><?php esc_html_e('State / County:', 'woocommerce'); ?></label>
					<input type="text" class="py-1 w-full" value="<?php echo esc_attr($current_r); ?>" placeholder="<?php esc_attr_e('State / County', 'woocommerce'); ?>" name="calc_shipping_state" id="calc_shipping_state" />
				<?php
				}
				?>
			</p>
		<?php endif; ?>

		<?php if (apply_filters('woocommerce_shipping_calculator_enable_city', true)) : ?>
			<p class="" id="calc_shipping_city_field">
				<label for="calc_shipping_city" class="sr-only"><?php esc_html_e('City:', 'woocommerce'); ?></label>
				<input type="text" class="py-1 w-full" value="<?php echo esc_attr(WC()->customer->get_shipping_city()); ?>" placeholder="<?php esc_attr_e('City', 'woocommerce'); ?>" name="calc_shipping_city" id="calc_shipping_city" />
			</p>
		<?php endif; ?>

		<?php if (apply_filters('woocommerce_shipping_calculator_enable_postcode', true)) : ?>
			<p class="" id="calc_shipping_postcode_field">
				<label for="calc_shipping_postcode" class="sr-only"><?php esc_html_e('Postcode / ZIP:', 'woocommerce'); ?></label>
				<input type="text" class="py-1 w-full" value="<?php echo esc_attr(WC()->customer->get_shipping_postcode()); ?>" placeholder="<?php esc_attr_e('Postcode / ZIP', 'woocommerce'); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" />
			</p>
		<?php endif; ?>

		<p><button type="submit" name="calc_shipping" value="1" class="w-full py-2 bg-primary text-white"><?php esc_html_e('Update', 'woocommerce'); ?></button></p>
		<?php wp_nonce_field('woocommerce-shipping-calculator', 'woocommerce-shipping-calculator-nonce'); ?>
	</section>
</form>

<?php do_action('woocommerce_after_shipping_calculator'); ?>