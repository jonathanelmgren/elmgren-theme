<div class='flex flex-col gap-8'>

    <h1 class='text-center'><?php do_action('woocommerce_cart_is_empty'); ?></h1>

    <?php
    if (wc_get_page_id('shop') > 0) : ?>
        <div class="w-full items-center flex">
            <a class="px-4 py-2 bg-primary mx-auto text-white" href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>">
                <?php
                /**
                 * Filter "Return To Shop" text.
                 *
                 * @since 4.6.0
                 * @param string $default_text Default text.
                 */
                echo esc_html(apply_filters('woocommerce_return_to_shop_text', __('Return to shop', 'woocommerce')));
                ?>
            </a>
        </div>
    <?php endif; ?>
</div>