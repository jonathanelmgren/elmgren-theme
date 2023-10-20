<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

do_action('woocommerce_before_proceed_to_checkout_button');
?>

<a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="w-full btn block is-style-large text-center">
	<?php esc_html_e('Proceed to checkout', 'woocommerce'); ?>
</a>

<?php
do_action('woocommerce_after_proceed_to_checkout_button');
