<?php

function elm_add_header_sections($wp_customize)
{
    $wp_customize->add_section('elm_header_logo_section', array(
        'title'    => __('Logo size', 'elmgren'),
        'priority' => 1,
        'panel'    => 'elm_header_panel'
    ));

    $wp_customize->add_section('elm_header_position_section', array(
        'title'    => __('Position', 'elmgren'),
        'priority' => 2,
        'panel'    => 'elm_header_panel'
    ));

    $wp_customize->add_section('elm_header_colors_section', array(
        'title'    => __('Background & Text colors', 'elmgren'),
        'priority' => 3,
        'panel'    => 'elm_header_panel'
    ));

    $wp_customize->add_section('elm_header_border_section', array(
        'title'    => __('Border settings', 'elmgren'),
        'priority' => 4,
        'panel'    => 'elm_header_panel'
    ));
}
add_action('customize_register', 'elm_add_header_sections');
