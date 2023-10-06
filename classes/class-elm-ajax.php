<?php
class Elm_Ajax
{
    public static function init()
    {
        add_action('wp_enqueue_scripts', array(__CLASS__, 'enqueue_scripts'));
        add_action('wp_ajax_add_to_cart', array(__CLASS__, 'add_to_cart'));
        add_action('wp_ajax_nopriv_add_to_cart', array(__CLASS__, 'add_to_cart'));
    }

    public static function enqueue_scripts()
    {
        if (elm_is_woocommerce_activated() && is_product()) {
            wp_enqueue_script('elm-add-to-cart-ajax-js', JS_PATH . 'add-to-cart-ajax.js', ['jquery'], false, true);
        }

        // Localize the script with server-side data.
        wp_localize_script('elm-main-js', 'elmAjax', array('url' => admin_url('admin-ajax.php')));
    }
    public static function add_to_cart()
    {
        ob_start();

        // phpcs:disable WordPress.Security.NonceVerification.Missing
        if (!isset($_POST['product_id'])) {
            return;
        }
        $product_id        = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
        $product           = wc_get_product($product_id);
        $quantity          = empty($_POST['quantity']) ? 1 : wc_stock_amount(wp_unslash($_POST['quantity']));
        $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
        $product_status    = get_post_status($product_id);
        $variation_id      = 0;
        $variation         = $_POST['variation'];

        if ($product && 'variation' === $product->get_type()) {
            $variation_id = $product_id;
            $product_id   = $product->get_parent_id();
            if (empty($variation)) {
                $variation    = $product->get_variation_attributes();
            }
        }

        if ($passed_validation && false !== WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation) && 'publish' === $product_status) {

            do_action('woocommerce_ajax_added_to_cart', $product_id);

            new Elm_JSON_Response(__('Item(s) added', 'elmgren'), true, 200, [
                'message' => __('Item(s) added', 'elmgren'),
                'type' => 'success',
                'variant' => 'toast',
                'settings' => [
                    'visibility' => 'auto-dismiss',
                    'interaction' => 'clickable'
                ]
            ]);
        } else {
            new Elm_JSON_Response(__('Item(s) not added', 'elmgren'), false, 500, [
                'message' => __('Item(s) added', 'elmgren'),
                'type' => 'error',
                'variant' => 'toast',
                'settings' => [
                    'visibility' => 'auto-dismiss',
                    'interaction' => 'clickable'
                ]
            ]);
        }
    }
}

Elm_Ajax::init();
