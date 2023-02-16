<?php

function elmgren_has_woo(): bool
{
    if (!function_exists('is_woocommerce_activated')) {
        function is_woocommerce_activated()
        {
            if (class_exists('woocommerce')) {
                return true;
            } else {
                return false;
            }
        }
    }
    return false;
}
