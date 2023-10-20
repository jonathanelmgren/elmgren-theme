<?php

add_filter('woocommerce_cart_totals_order_total_html', 'elm_add_class_to_tax_text');
function elm_add_class_to_tax_text($value)
{
    return str_replace('class="includes_tax"', 'class="includes_tax text-lightgray-900 text-sm"', $value);
}
