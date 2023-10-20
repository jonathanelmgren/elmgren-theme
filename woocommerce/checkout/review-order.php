<?php

/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined('ABSPATH') || exit;
?>
<div>
	<ul role="list" class="divide-y border-theme-divider">
		<?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) : ?>
			<?php wc_get_template('checkout/order-item.php', ['cart_item_key' => $cart_item_key, 'cart_item' => $cart_item, 'readonly' => true]) ?>
		<?php endforeach; ?>
	</ul>
	<?php wc_get_template('cart/summary.php') ?>
</div>