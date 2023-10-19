<?php

/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined('ABSPATH') || exit;
$is_checked = apply_filters('woocommerce_ship_to_different_address_checked', 'shipping' === get_option('woocommerce_ship_to_destination') ? 1 : 0);
?>
<div class="woocommerce-shipping-fields">
	<?php if (true === WC()->cart->needs_shipping_address()) : ?>

		<div id="ship-to-different-address" class="mt-6 flex space-x-2">
			<div class="flex h-5 items-center">
				<input name="ship_to_different_address" id="ship-to-different-address-checkbox" name="ship-to-different-address-checkbox" type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" <?php checked($is_checked, 1); ?>>
			</div>
			<label for="ship-to-different-address-checkbox" class="text-sm font-medium text-gray-400"><?php esc_html_e('Ship to a different address?', 'woocommerce'); ?></label>
		</div>

		<div class="shipping_address <?= $is_checked ? '' : 'hidden' ?>">

			<?php do_action('woocommerce_before_checkout_shipping_form', $checkout); ?>

			<div class="woocommerce-shipping-fields__field-wrapper my-4 grid grid-cols-2 gap-4">
				<?php
				$fields = $checkout->get_checkout_fields('shipping');

				foreach ($fields as $key => $field) {
					$field['label_class'] = ['block text-sm font-medium text-gray-700 [&>.required]:no-underline'];
					$field['input_class'] = ['block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm'];
					woocommerce_form_field($key, $field, $checkout->get_value($key));
				}
				?>
			</div>

			<?php do_action('woocommerce_after_checkout_shipping_form', $checkout); ?>

		</div>

	<?php endif; ?>
</div>
<div class="woocommerce-additional-fields my-4">
	<?php do_action('woocommerce_before_order_notes', $checkout); ?>

	<?php if (apply_filters('woocommerce_enable_order_notes_field', 'yes' === get_option('woocommerce_enable_order_comments', 'yes'))) : ?>

		<?php if (!WC()->cart->needs_shipping() || wc_ship_to_billing_address_only()) : ?>

			<h3><?php esc_html_e('Additional information', 'woocommerce'); ?></h3>

		<?php endif; ?>

		<div class="woocommerce-additional-fields__field-wrapper">
			<?php foreach ($checkout->get_checkout_fields('order') as $key => $field) : ?>
				<?php
				$field['label_class'] = ['block text-sm font-medium text-gray-700 [&>.required]:no-underline'];
				$field['input_class'] = ['block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm'];
				?>
				<?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
			<?php endforeach; ?>
		</div>

	<?php endif; ?>

	<?php do_action('woocommerce_after_order_notes', $checkout); ?>
</div>