<div>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900">Shopping Cart</h1>

    <form class="mt-12" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
        <!-- WooCommerce Loop Starts -->
        <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
            $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
            $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
            $product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
            $qty = $cart_item['quantity'];
        ?>

            <li class="flex py-6 sm:py-10">
                <div class="flex-shrink-0">
                    <?php echo $thumbnail; ?>
                </div>

                <div class="relative ml-4 flex flex-1 flex-col justify-between sm:ml-6">
                    <div>
                        <div class="flex justify-between sm:grid sm:grid-cols-2">
                            <div class="pr-6">
                                <h3 class="text-sm">
                                    <a href="<?php echo esc_url(get_permalink($product_id)); ?>" class="font-medium text-gray-700 hover:text-gray-800">
                                        <?php echo $product_name; ?>
                                    </a>
                                </h3>
                                <!-- Add other product details like color, size etc. if needed -->
                            </div>
                            <p class="text-right text-sm font-medium text-gray-900"><?php echo $product_price; ?></p>
                        </div>

                        <div class="mt-4 flex items-center sm:absolute sm:left-1/2 sm:top-0 sm:mt-0 sm:block">
                            <label for="quantity-<?php echo esc_attr($cart_item_key); ?>" class="sr-only">Quantity</label>
                            <input value="<?php echo $qty ?>" id="quantity-<?php echo esc_attr($cart_item_key); ?>" name="cart[<?php echo esc_attr($cart_item_key); ?>][qty]" class="block max-w-full rounded-md border border-gray-300 py-1.5 text-left text-base font-medium leading-5 text-gray-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm" />
                            <a href="<?php echo esc_url(wc_get_cart_remove_url($cart_item_key)); ?>" class="ml-4 text-sm font-medium text-indigo-600 hover:text-indigo-500 sm:ml-0 sm:mt-3">
                                <span>Remove</span>
                            </a>
                        </div>
                    </div>

                    <p class="mt-4 flex space-x-2 text-sm text-gray-700">
                        <!-- Add stock status, etc. -->
                    </p>
                </div>
            </li>

        <?php endforeach; ?>

        <!-- WooCommerce Loop Ends -->

        <!-- Order Summary -->
        <div class="mt-10">
            <div class="rounded-lg bg-gray-50 px-4 py-6 sm:p-6 lg:p-8">
                <h2 class="sr-only">Order summary</h2>
                <div class="flow-root">
                    <dl class="-my-4 divide-y divide-gray-200 text-sm">
                        <div class="flex items-center justify-between py-4">
                            <dt class="text-gray-600">Subtotal</dt>
                            <dd class="font-medium text-gray-900"><?php echo WC()->cart->get_cart_subtotal(); ?></dd>
                        </div>
                        <!-- Add other fields like shipping, tax -->
                    </dl>
                </div>
            </div>
            <div class="mt-10">
                <button type="submit" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>" class="button hidden"></button>
                <?php do_action('woocommerce_cart_actions'); ?>
                <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
            </div>
        </div>
    </form>
</div>