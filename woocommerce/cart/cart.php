<div>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl"><?php the_title() ?></h1>
    <div class="mt-12 lg:grid lg:grid-cols-12 lg:items-start lg:gap-x-12 xl:gap-x-16">
        <section aria-labelledby="cart-heading" class="lg:col-span-7">
            <h2 id="cart-heading" class="sr-only"><?php _e('Items in your shopping cart', 'elmgren') ?></h2>
            <ul role="list" class="divide-y divide-gray-200 border-b border-t border-gray-200">
                <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) : ?>
                    <?php
                    $product   = $cart_item['data'];
                    $quantity = $cart_item['quantity'];
                    $variations = $cart_item['variation'] ?? [];
                    $parent = wc_get_product($product->get_parent_id());
                    $parent_name = $parent instanceof WC_Product ? $parent->get_name() : null;
                    $remove_link = sprintf(
                        '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                        esc_url(wc_get_cart_remove_url($cart_item_key)),
                        /* translators: %s is the product name */
                        esc_attr(sprintf(__('Remove %s from cart', 'woocommerce'), wp_strip_all_tags($product->get_name()))),
                        esc_attr($product->get_id()),
                        esc_attr($product->get_sku())
                    );
                    ?>

                    <li class="flex py-6 sm:py-10">
                        <div class="flex-shrink-0">
                            <?php echo $product->get_image('woocommerce_thumbnail', ['class' => 'h-24 w-24 rounded-md object-cover object-center sm:h-48 sm:w-48']) ?>
                        </div>

                        <div class="ml-4 flex flex-1 flex-col justify-between sm:ml-6">
                            <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                                <div>
                                    <div class="flex justify-between">
                                        <h3 class="text-sm">
                                            <a href="#" class="font-medium text-gray-700 hover:text-gray-800"><?= $parent_name ?? $product->get_name() ?></a>
                                        </h3>
                                    </div>
                                    <div class="mt-1 flex text-sm">
                                        <?php foreach ($variations as $key => $variation) :  ?>
                                            <p class="text-gray-500 [&:not(:first-child)]:border-l [&:not(:first-child)]:pl-2 [&:not(:first-child)]:ml-2"><?= ucfirst($variation) ?></p>
                                        <?php endforeach; ?>
                                    </div>
                                    <p class="mt-1 text-sm font-medium text-gray-900"><?php echo WC()->cart->get_product_price($product) ?></p>
                                </div>

                                <div class="mt-4 sm:mt-0 sm:pr-9">
                                    <label for="quantity-0" class="sr-only"><?php _e('Quantity', 'woocommerce') ?>, <?php echo $product->get_name() ?></label>
                                    <input type="number" value="<?php echo $quantity ?>" id="quantity-0" name="quantity-0" class="max-w-[4rem] rounded-md border border-gray-300 py-1.5 text-left text-base font-medium leading-5 text-gray-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm" />
                                    <div class="absolute right-0 top-0">
                                        <a href="<?= esc_url(wc_get_cart_remove_url($cart_item_key)) ?>" class="-m-2 inline-flex p-2 text-gray-400 hover:text-gray-500">
                                            <span class="sr-only"><?php _e('Remove', 'woocommerce') ?></span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

        <!-- Order summary -->
        <section aria-labelledby="summary-heading" class="mt-16 rounded-lg bg-gray-50 px-4 py-6 sm:p-6 lg:col-span-5 lg:mt-0 lg:p-8 lg:sticky lg:top-10">
            <h2 id="summary-heading" class="text-lg font-medium text-gray-900"><?php esc_html_e('Cart totals', 'woocommerce'); ?></h2>
            <?php if (wc_coupons_enabled()) : ?>
                <form class='mt-4' action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
                    <label for="coupon_code" class="sr-only"><?php esc_html_e('Coupon code', 'woocommerce'); ?></label>
                    <div class='flex gap-2 items-center justify-between'>
                        <input type="text" name="coupon_code" id="coupon_code" value="" class="focus:outline-none focus:ring-0 focus:border-transparent focus:shadow-none focus:bg-gray-100 grow bg-transparent border-0 border-b-[1px] border-lightgray-700" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" />
                        <button type="submit" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>" class="text-xs bg-primary text-white px-2 py-1"><?php esc_attr_e('Apply', 'elmgren'); ?></button>
                    </div>
                    <?php do_action('woocommerce_cart_coupon'); ?>
                </form>
            <?php endif; ?>

            <dl class="mt-10 space-y-4">
                <div class="flex items-center justify-between">
                    <dt class="text-sm text-gray-600"><?php esc_attr_e('Subtotal', 'woocommerce'); ?></dt>
                    <dd class="text-sm font-medium text-gray-900"><?php wc_cart_totals_subtotal_html(); ?></dd>
                </div>
                <!-- Todo: Add shipping, coupons etcetera from native cart.php template -->
                <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                    <dt class="text-base font-bold text-gray-900"><?= __('Total', 'woocommerce') ?></dt>
                    <dd class="text-base text-gray-900"><?php wc_cart_totals_order_total_html(); ?></dd>
                </div>
            </dl>

            <div class="mt-6">
                <button type="submit" class="w-full rounded-md border border-transparent bg-indigo-600 px-4 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50"><?= __('Checkout', 'woocommerce') ?></button>
            </div>
        </section>
    </div>
</div>