<div class='flex flex-col gap-8 justify-center'>
    <!-- Display a message for an empty cart -->
    <div class="text-center">
        <?php do_action('woocommerce_cart_is_empty'); ?>
    </div>

    <?php if (wc_get_page_id('shop') > 0) : ?>
        <!-- Display the 'Return to Shop' button -->
        <div class="w-full items-center flex">
            <a class="btn mx-auto" href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>">
                <?php echo esc_html(apply_filters('woocommerce_return_to_shop_text', __('Return to shop', 'woocommerce'))); ?>
            </a>
        </div>
    <?php endif; ?>
</div>
