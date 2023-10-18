<?php

/**
 * Output a single payment method
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment-method.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.5.0
 */

if (!defined('ABSPATH')) {
	exit;
}
?>


<label data-payment-method class="relative cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none [&.active]:border-indigo-500 border-gray-300 <?= $gateway->chosen ? 'active' : '' ?>">
	<input type="radio" name="payment_method" value="<?php echo esc_attr($gateway->id); ?>" class="sr-only" <?php checked($gateway->chosen, true); ?>>

	<span class="flex flex-1">
		<span class="flex flex-col">
			<?php if ($gateway->get_icon()) : ?>
				<span class="block text-sm font-medium text-gray-900"><?php echo $gateway->get_icon(); ?></span>
			<?php else : ?>
				<span class="block text-sm font-medium text-gray-900"><?php echo $gateway->get_title(); ?></span>
			<?php endif; ?>

			<?php if ($gateway->get_description()) : ?>
				<span class="mt-1 flex items-center text-sm text-gray-500"><?php echo $gateway->get_description(); ?></span>
			<?php endif; ?>
		</span>
	</span>

	<svg class="h-5 w-5 text-indigo-600 absolute hidden top-2 [&.active]:block right-2 <?= $gateway->chosen ? 'active' : '' ?>" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
		<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
	</svg>

</label>