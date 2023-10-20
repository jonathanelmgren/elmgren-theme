<?php

function elm_customize_header($wp_customize)
{

    // Logo
    add_setting_and_control(
        $wp_customize,
        [
            'setting' => "logo_height_setting",
            'settingArgs' => [
                'default' => '8',
            ],
            'controlArgs' => [
                'label' => __("Logo height", 'elmgren'),
                'section' => 'elm_header_logo_section',
                'type' => 'range',
                'input_attrs' => array(
                    'min' => '4',
                    'max' => '48',
                    'step' => '1',
                ),
            ],
        ]
    );

    // Position
    add_setting_and_control(
        $wp_customize,
        [
            'setting' => "elm_header_absolute_position",
            'settingArgs' => ['default' => false],
            'controlArgs' => [
                'label' => __("Header position absolute", 'elmgren'),
                'section' => 'elm_header_position_section',
                'type'     => 'checkbox'
            ],
        ]
    );
    add_setting_and_control(
        $wp_customize,
        [
            'setting' => "elm_header_sticky",
            'settingArgs' => ['default' => false],
            'controlArgs' => [
                'label' => __("Header sticky", 'elmgren'),
                'section' => 'elm_header_position_section',
                'type'     => 'checkbox'
            ],
        ]
    );

    // Background & Text colors
    add_setting_and_control(
        $wp_customize,
        [
            'setting' => "elm_header_border",
            'settingArgs' => ['default' => false],
            'controlArgs' => [
                'label' => __("Header border", 'elmgren'),
                'section' => 'elm_header_border_section',
                'type'     => 'checkbox'
            ],
        ]
    );

    add_tailwind_color_picker_control($wp_customize, 'header_bg_color', 'Header Background Color', 'elm_header_colors_section');
    add_tailwind_color_picker_control_with_hover($wp_customize, 'header_link_color', 'Header Link Color', 'elm_header_colors_section');

    if (elm_is_woocommerce_activated()) {
        // Cart
        add_tailwind_color_picker_control($wp_customize, 'elm_woo_cart_qty_bg_color', 'Cart quantity background color', 'elm_header_colors_section');
        add_tailwind_color_picker_control($wp_customize, 'elm_woo_cart_bg_color', 'Cart background color', 'elm_header_colors_section');
        add_tailwind_color_picker_control($wp_customize, 'elm_woo_cart_text_color', 'Cart number text color', 'elm_header_colors_section');
    }

    // Border settings
    add_tailwind_color_picker_control($wp_customize, 'header_border_color', 'Header Border color', 'elm_header_border_section');
}
add_action('customize_register', 'elm_customize_header');
