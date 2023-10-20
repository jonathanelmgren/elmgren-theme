<div class="lg:grid lg:grid-cols-12 lg:items-start lg:gap-x-12 xl:gap-x-16">
    <section aria-labelledby="cart-heading" class="lg:col-span-7">
        <h2 id="cart-heading" class="sr-only"><?php _e('Items in your shopping cart', 'elmgren') ?></h2>
        <ul role="list" class="divide-y divide-theme-divider">
            <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) : ?>
                <?php wc_get_template('cart/cart-item.php', ['cart_item_key' => $cart_item_key, 'cart_item' => $cart_item]) ?>
            <?php endforeach; ?>
        </ul>
    </section>

    <!-- Order summary -->
    <section aria-labelledby="summary-heading" class="mt-16 rounded-theme shadow-lg px-4 py-6 sm:p-6 lg:col-span-5 lg:mt-0 lg:sticky lg:top-10">
        <h2 id="summary-heading" class="text-lg font-medium text-gray-400"><?php esc_html_e('Cart totals', 'woocommerce'); ?></h2>
        <?php if (wc_coupons_enabled()) : ?>
            <form class='mt-4' action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
                <label for="coupon_code" class="sr-only"><?php esc_html_e('Coupon code', 'woocommerce'); ?></label>
                <div class='flex gap-6 items-center justify-between'>
                    <input type="text" name="coupon_code" id="coupon_code" value="" class="w-full border-0 border-b-[1px] border-lightgray-600 rounded-none text-xs" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" />
                    <button type="submit" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>" class="is-size-xsmall is-style-secondary"><?php esc_attr_e('Apply', 'elmgren'); ?></button>
                </div>
                <?php do_action('woocommerce_cart_coupon'); ?>
            </form>
        <?php endif; ?>

        <div class="mt-10">
            <?php wc_get_template('cart/summary.php') ?>
        </div>

        <div class="mt-6">
            <?php do_action('woocommerce_proceed_to_checkout'); ?>
        </div>
    </section>
</div>