<?php

function elm_customize_woo($wp_customize)
{
    $wp_customize->add_section('elm_woo_section', array(
        'title'    => __('Elmgren Theme', 'elmgren'),
        'priority' => 30,
        'panel' => 'woocommerce'
    ));

    $wp_customize->add_setting("elm_woo_cart_qty_bg_color", array(
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_tailwind'
    ));
    $wp_customize->add_control(new TailwindColorPickerThemeCustomizer($wp_customize, "elm_woo_cart_qty_bg_color_control", array(
        'label'    => __("Cart quantity background color", 'elmgren'),
        'section'  => 'elm_woo_section',
        'settings' => "elm_woo_cart_qty_bg_color",
    )));


    $wp_customize->add_setting("elm_woo_cart_bg_color", array(
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_tailwind'
    ));
    $wp_customize->add_control(new TailwindColorPickerThemeCustomizer($wp_customize, "elm_woo_cart_bg_color_control", array(
        'label'    => __("Cart background color", 'elmgren'),
        'section'  => 'elm_woo_section',
        'settings' => "elm_woo_cart_bg_color",
    )));

    $wp_customize->add_setting("elm_woo_cart_text_color", array(
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_tailwind'
    ));
    $wp_customize->add_control(new TailwindColorPickerThemeCustomizer($wp_customize, "elm_woo_cart_text_color_control", array(
        'label'    => __("Cart number text color", 'elmgren'),
        'section'  => 'elm_woo_section',
        'settings' => "elm_woo_cart_text_color",
    )));
}
if (elm_is_woocommerce_activated()) {
    add_action('customize_register', 'elm_customize_woo');
}
