<?php

defined('ABSPATH') || exit;

?>

<div>
	<ul role="list" class="divide-y divide-theme-divider">
		<?php
		foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
			$template_args = [
				'cart_item_key' => $cart_item_key,
				'cart_item'     => $cart_item,
				'readonly'      => true
			];
			wc_get_template('checkout/order-item.php', $template_args);
		}
		?>
	</ul>
	<?php wc_get_template('cart/summary.php'); ?>
</div>
