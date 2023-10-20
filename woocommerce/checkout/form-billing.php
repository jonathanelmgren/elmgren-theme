<?php

defined('ABSPATH') || exit;

function render_form_fields($fields, $checkout) {
    foreach ($fields as $key => $field) {
        if (!isset($field['label'])) {
            continue;
        }
        $field['label_class'] = ['block text-sm font-medium text-gray-700 [&>.required]:no-underline'];
        $field['input_class'] = ['block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm'];
        woocommerce_form_field($key, $field, $checkout->get_value($key));
    }
}
?>
<div class="woocommerce-billing-fields">
    <h3><?php esc_html_e(wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ? 'Billing &amp; Shipping' : 'Billing details', 'woocommerce'); ?></h3>

    <?php do_action('woocommerce_before_checkout_billing_form', $checkout); ?>

    <div class="woocommerce-billing-fields__field-wrapper my-4 grid grid-cols-2 gap-4">
        <?php render_form_fields($checkout->get_checkout_fields('billing'), $checkout); ?>
    </div>

    <?php do_action('woocommerce_after_checkout_billing_form', $checkout); ?>
</div>

<?php if (!is_user_logged_in() && $checkout->is_registration_enabled()) : ?>
    <div class="woocommerce-account-fields">
        <?php if (!$checkout->is_registration_required()) : ?>
            <p class="form-row form-row-wide create-account">
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                    <input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount" <?php checked((true === $checkout->get_value('createaccount') || (true === apply_filters('woocommerce_create_account_default_checked', false))), true); ?> type="checkbox" name="createaccount" value="1" />
                    <span><?php esc_html_e('Create an account?', 'woocommerce'); ?></span>
                </label>
            </p>
        <?php endif; ?>

        <?php do_action('woocommerce_before_checkout_registration_form', $checkout); ?>

        <?php if ($account_fields = $checkout->get_checkout_fields('account')) : ?>
            <div class="create-account">
                <?php render_form_fields($account_fields, $checkout); ?>
            </div>
        <?php endif; ?>

        <?php do_action('woocommerce_after_checkout_registration_form', $checkout); ?>
    </div>
<?php endif; ?>
