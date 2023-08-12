<?php

function elmgren_customize_header($wp_customize)
{

    // Section for Header Settings
    $wp_customize->add_section('elmgren_header_section', array(
        'title'    => __('Header Settings', 'elmgren'),
        'priority' => 30,
    ));

    // Adding setting for logo height
    $wp_customize->add_setting('logo_height_setting', array(
        'default'   => '8',  // default height
        'transport' => 'refresh',
    ));

    // Adding control for logo height
    $wp_customize->add_control('logo_height_control', array(
        'label'    => __('Set Logo Height', 'elmgren'),
        'section'  => 'elmgren_header_section',
        'settings' => 'logo_height_setting',
        'type'     => 'range',
        'input_attrs' => array(
            'min' => '4',
            'max' => '48',
            'step' => '1',
        ),
    ));

    // Absolute header positioning
    $wp_customize->add_setting('header_absolute_position', array(
        'default'   => false,
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('header_absolute_position_control', array(
        'label'    => __('Header Position Absolute', 'elmgren'),
        'section'  => 'elmgren_header_section',
        'settings' => 'header_absolute_position',
        'type'     => 'checkbox',
    ));

    // Sticky header
    $wp_customize->add_setting('header_sticky', array(
        'default'   => false,
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('header_sticky_control', array(
        'label'    => __('Sticky Header', 'elmgren'),
        'section'  => 'elmgren_header_section',
        'settings' => 'header_sticky',
        'type'     => 'checkbox',
    ));

    // Header background color
    $wp_customize->add_setting('header_bg_color', array(
        'default'   => TAILWIND_COLORS['primary'] ?? 'transparent',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'header_bg_color_control', array(
        'label'    => __('Header Background Color', 'elmgren'),
        'section'  => 'elmgren_header_section',
        'settings' => 'header_bg_color',
        'description' => 'Choose a preset or select your own color.',
    )));

    // Header link color
    $wp_customize->add_setting('header_link_color', array(
        'default'   => '#000000',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'header_link_color_control', array(
        'label'    => __('Header Link Color', 'elmgren'),
        'section'  => 'elmgren_header_section',
        'settings' => 'header_link_color',
    )));
}
add_action('customize_register', 'elmgren_customize_header');
