<?php

function elm_customize_header($wp_customize)
{

    // Section for Header Settings
    $wp_customize->add_section('elm_header_section', array(
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
        'section'  => 'elm_header_section',
        'settings' => 'logo_height_setting',
        'type'     => 'range',
        'input_attrs' => array(
            'min' => '4',
            'max' => '48',
            'step' => '1',
        ),
    ));

    // Adding setting for header spacing to content
    $wp_customize->add_setting('content_spacing_setting', array(
        'default'   => '0',  // default height
        'transport' => 'refresh',
    ));

    // Adding control for header spacing to content
    $wp_customize->add_control('content_spacing_control', array(
        'label'    => __('Set header spacing to content', 'elmgren'),
        'section'  => 'elm_header_section',
        'settings' => 'content_spacing_setting',
        'type'     => 'range',
        'input_attrs' => array(
            'min' => '0',
            'max' => '12',
            'step' => '0.5',
        ),
    ));

    // Absolute header positioning
    $wp_customize->add_setting('header_absolute_position', array(
        'default'   => false,
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('header_absolute_position_control', array(
        'label'    => __('Header Position Absolute', 'elmgren'),
        'section'  => 'elm_header_section',
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
        'section'  => 'elm_header_section',
        'settings' => 'header_sticky',
        'type'     => 'checkbox',
    ));

    // Header background color
    $wp_customize->add_setting('header_bg_color', array(
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_tailwind'
    ));
    $wp_customize->add_control(new TailwindColorPickerThemeCustomizer($wp_customize, 'header_bg_color_control', array(
        'label'    => __('Header Background Color', 'elmgren'),
        'section'  => 'elm_header_section',
        'settings' => 'header_bg_color',
        'description' => 'Choose a preset or select your own color.',
    )));

    // Header link color
    $wp_customize->add_setting('header_link_color', array(
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_tailwind'
    ));
    $wp_customize->add_control(new TailwindColorPickerThemeCustomizer($wp_customize, 'header_link_color_control', array(
        'label'    => __('Header Link Color', 'elmgren'),
        'section'  => 'elm_header_section',
        'settings' => 'header_link_color',
    )));

    // Header link color - Hover
    $wp_customize->add_setting('header_link_color_hover', array(
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_tailwind'
    ));
    $wp_customize->add_control(new TailwindColorPickerThemeCustomizer($wp_customize, 'header_link_color_hover_control', array(
        'label'    => __('Header Link Color - Hover', 'elmgren'),
        'section'  => 'elm_header_section',
        'settings' => 'header_link_color_hover',
    )));

    // Header border
    $wp_customize->add_setting('header_border', array(
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('header_border_control', array(
        'label'    => __('Header border?', 'elmgren'),
        'section'  => 'elm_header_section',
        'settings' => 'header_border',
        'type'     => 'checkbox',
    ));

    // Header border color
    $wp_customize->add_setting('header_border_color', array(
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_tailwind'
    ));
    $wp_customize->add_control(new TailwindColorPickerThemeCustomizer($wp_customize, 'header_border_color_control', array(
        'label'    => __('Header Border color', 'elmgren'),
        'section'  => 'elm_header_section',
        'settings' => 'header_border_color',
    )));
}
add_action('customize_register', 'elm_customize_header');
