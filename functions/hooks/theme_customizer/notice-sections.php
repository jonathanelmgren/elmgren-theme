<?php

function elm_add_notice_sections($wp_customize)
{
    $wp_customize->add_section('elm_notice_position_section', array(
        'title'    => __('Position & Sizing', 'elmgren'),
        'priority' => 1,
        'panel'    => 'elm_notice_panel'
    ));

    $wp_customize->add_section('elm_notice_success_section', array(
        'title'    => __('Success colors', 'elmgren'),
        'priority' => 1,
        'panel'    => 'elm_notice_panel'
    ));
    $wp_customize->add_section('elm_notice_warning_section', array(
        'title'    => __('Warning colors', 'elmgren'),
        'priority' => 1,
        'panel'    => 'elm_notice_panel'
    ));
    $wp_customize->add_section('elm_notice_info_section', array(
        'title'    => __('Info colors', 'elmgren'),
        'priority' => 1,
        'panel'    => 'elm_notice_panel'
    ));
    $wp_customize->add_section('elm_notice_error_section', array(
        'title'    => __('Error colors', 'elmgren'),
        'priority' => 1,
        'panel'    => 'elm_notice_panel'
    ));
}
add_action('customize_register', 'elm_add_notice_sections');
