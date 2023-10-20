<?php

defined('ABSPATH') || exit;

$is_checked_by_default = apply_filters('woocommerce_terms_is_checked_default', isset($_POST['terms']));
$is_terms_checkbox_enabled = function_exists('wc_terms_and_conditions_checkbox_enabled') && wc_terms_and_conditions_checkbox_enabled();

if (apply_filters('woocommerce_checkout_show_terms', true) && $is_terms_checkbox_enabled) :
?>
	<div class="woocommerce-terms-and-conditions-wrapper">
		<div id="ship-to-different-address validate-required" class="mt-6 flex space-x-2">
			<div class="flex h-5 items-center">
				<input 
					type="checkbox" 
					id="terms" 
					name="terms" 
					class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" 
					<?php checked($is_checked_by_default, true); ?>
				>
			</div>
			<input type="hidden" name="terms-field" value="1" />
			<label for="terms" class="text-sm font-medium text-gray-400">
				<?php wc_terms_and_conditions_checkbox_text(); ?>
				&nbsp;<abbr class="required" title="<?php esc_attr_e('required', 'woocommerce'); ?>">*</abbr>
			</label>
		</div>
	</div>
<?php
endif;
?>
