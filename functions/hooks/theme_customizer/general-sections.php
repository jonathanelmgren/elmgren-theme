<?php

function elm_add_general_sections($wp_customize)
{
    $wp_customize->add_section('elm_general_section', array(
        'title'    => __('General settings', 'elmgren'),
        'priority' => 1,
        'panel'    => 'elm_general_panel'
    ));

    $wp_customize->add_section('elm_text_sizes', array(
        'title'    => __('Text sizes', 'elmgren'),
        'priority' => 2,
        'panel'    => 'elm_general_panel'
    ));

    $wp_customize->add_section('elm_text_colors', array(
        'title'    => __('Text colors', 'elmgren'),
        'priority' => 3,
        'panel'    => 'elm_general_panel'
    ));

    $wp_customize->add_section('elm_button_settings', array(
        'title'    => __('Buttons', 'elmgren'),
        'priority' => 4,
        'panel'    => 'elm_general_panel'
    ));
}
add_action('customize_register', 'elm_add_general_sections');
