<?php

function custom_checkout_fields_class($fields)
{
    // Adjust both first_name and last_name
    $fields['billing']['billing_first_name']['class'] = array('form-row-first', 'col-span-full', 'md:col-span-1');
    $fields['billing']['billing_last_name']['class'] = array('form-row-last', 'col-span-full', 'md:col-span-1');
    $fields['billing']['billing_company']['class'] = array('form-row-wide', 'col-span-full');
    $fields['billing']['billing_country']['class'] = array('form-row-wide', 'col-span-full');
    $fields['billing']['billing_address_1']['class'] = array('form-row-wide', 'col-span-full');
    $fields['billing']['billing_address_2']['class'] = array('form-row-wide', 'col-span-full');
    $fields['billing']['billing_city']['class'] = array('form-row-wide', 'col-span-full', 'md:col-span-1');
    $fields['billing']['billing_state']['class'] = array('form-row-wide', 'col-span-full', 'md:col-span-1');
    $fields['billing']['billing_postcode']['class'] = array('form-row-wide', 'col-span-full', 'md:col-span-1');
    $fields['billing']['billing_phone']['class'] = array('form-row-wide', 'col-span-full', 'md:col-span-1');
    $fields['billing']['billing_email']['class'] = array('form-row-wide', 'col-span-full');

    $fields['shipping']['shipping_first_name']['class'] = array('form-row-first', 'col-span-full', 'md:col-span-1');
    $fields['shipping']['shipping_last_name']['class'] = array('form-row-last', 'col-span-full', 'md:col-span-1');
    $fields['shipping']['shipping_company']['class'] = array('form-row-wide', 'col-span-full');
    $fields['shipping']['shipping_country']['class'] = array('form-row-wide', 'col-span-full');
    $fields['shipping']['shipping_address_1']['class'] = array('form-row-wide', 'col-span-full');
    $fields['shipping']['shipping_address_2']['class'] = array('form-row-wide', 'col-span-full');
    $fields['shipping']['shipping_city']['class'] = array('form-row-wide', 'col-span-full', 'md:col-span-1');
    $fields['shipping']['shipping_state']['class'] = array('form-row-wide', 'col-span-full', 'md:col-span-1');
    $fields['shipping']['shipping_postcode']['class'] = array('form-row-wide', 'col-span-full', 'md:col-span-1');

    return $fields;
}
add_filter('woocommerce_checkout_fields', 'custom_checkout_fields_class');
