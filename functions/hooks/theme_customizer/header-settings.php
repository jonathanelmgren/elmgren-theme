<?php

function elm_customize_header($wp_customize)
{

    // Logo
    $wp_customize->add_setting('logo_height_setting', array(
        'default'   => '8',  // default height
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('logo_height_control', array(
        'label'    => __('Set Logo Height', 'elmgren'),
        'section'  => 'elm_header_logo_section',
        'settings' => 'logo_height_setting',
        'type'     => 'range',
        'input_attrs' => array(
            'min' => '4',
            'max' => '48',
            'step' => '1',
        ),
    ));

    // Position
    $wp_customize->add_setting('header_absolute_position', array(
        'default'   => false,
        'transport' => 'refresh',
    ));
    $wp_customize->add_setting('header_sticky', array(
        'default'   => false,
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('header_absolute_position_control', array(
        'label'    => __('Header Position Absolute', 'elmgren'),
        'section'  => 'elm_header_position_section',
        'settings' => 'header_absolute_position',
        'type'     => 'checkbox',
    ));
    $wp_customize->add_control('header_sticky_control', array(
        'label'    => __('Sticky Header', 'elmgren'),
        'section'  => 'elm_header_position_section',
        'settings' => 'header_sticky',
        'type'     => 'checkbox',
    ));

    // Background & Text colors
    $wp_customize->add_setting('header_bg_color', array(
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_tailwind'
    ));
    $wp_customize->add_setting('header_link_color', array(
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_tailwind'
    ));
    $wp_customize->add_setting('header_link_color_hover', array(
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_tailwind'
    ));
    $wp_customize->add_setting('header_border', array(
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new TailwindColorPickerThemeCustomizer($wp_customize, 'header_bg_color_control', array(
        'label'    => __('Header Background Color', 'elmgren'),
        'section'  => 'elm_header_colors_section',
        'settings' => 'header_bg_color',
        'description' => 'Choose a preset or select your own color.',
    )));
    $wp_customize->add_control(new TailwindColorPickerThemeCustomizer($wp_customize, 'header_link_color_control', array(
        'label'    => __('Header Link Color', 'elmgren'),
        'section'  => 'elm_header_colors_section',
        'settings' => 'header_link_color',
    )));
    $wp_customize->add_control(new TailwindColorPickerThemeCustomizer($wp_customize, 'header_link_color_hover_control', array(
        'label'    => __('Header Link Color - Hover', 'elmgren'),
        'section'  => 'elm_header_colors_section',
        'settings' => 'header_link_color_hover',
    )));
    $wp_customize->add_control('header_border_control', array(
        'label'    => __('Header border?', 'elmgren'),
        'section'  => 'elm_header_border_section',
        'settings' => 'header_border',
        'type'     => 'checkbox',
    ));
    if (elm_is_woocommerce_activated()) {

        $wp_customize->add_setting("elm_woo_cart_qty_bg_color", array(
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_tailwind'
        ));
        $wp_customize->add_control(new TailwindColorPickerThemeCustomizer($wp_customize, "elm_woo_cart_qty_bg_color_control", array(
            'label'    => __("Cart quantity background color", 'elmgren'),
            'section'  => 'elm_header_colors_section',
            'settings' => "elm_woo_cart_qty_bg_color",
        )));


        $wp_customize->add_setting("elm_woo_cart_bg_color", array(
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_tailwind'
        ));
        $wp_customize->add_control(new TailwindColorPickerThemeCustomizer($wp_customize, "elm_woo_cart_bg_color_control", array(
            'label'    => __("Cart background color", 'elmgren'),
            'section'  => 'elm_header_colors_section',
            'settings' => "elm_woo_cart_bg_color",
        )));

        $wp_customize->add_setting("elm_woo_cart_text_color", array(
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_tailwind'
        ));
        $wp_customize->add_control(new TailwindColorPickerThemeCustomizer($wp_customize, "elm_woo_cart_text_color_control", array(
            'label'    => __("Cart number text color", 'elmgren'),
            'section'  => 'elm_header_colors_section',
            'settings' => "elm_woo_cart_text_color",
        )));
    }

    // Border settings
    $wp_customize->add_setting('header_border_color', array(
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_tailwind'
    ));
    $wp_customize->add_control(new TailwindColorPickerThemeCustomizer($wp_customize, 'header_border_color_control', array(
        'label'    => __('Header Border color', 'elmgren'),
        'section'  => 'elm_header_border_section',
        'settings' => 'header_border_color',
    )));
}
add_action('customize_register', 'elm_customize_header');
