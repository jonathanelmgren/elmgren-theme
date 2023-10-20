<?php

function elm_add_customizer_panels($wp_customize)
{
    $wp_customize->add_panel('elm_general_panel', array(
        'title'       => __('General Options', 'elmgren'),
        'description' => __('General settings for Elmgren Theme', 'elmgren'),
        'priority'    => 25,
    ));

    $wp_customize->add_panel('elm_header_panel', array(
        'title'       => __('Header Options', 'elmgren'),
        'description' => __('Settings for the header', 'elmgren'),
        'priority'    => 30,
    ));

    $wp_customize->add_panel('elm_footer_panel', array(
        'title'       => __('Footer Options', 'elmgren'),
        'description' => __('Settings for the footer', 'elmgren'),
        'priority'    => 35,
    ));

    $wp_customize->add_panel('elm_notice_panel', array(
        'title'       => __('Notice Options', 'elmgren'),
        'description' => __('Settings for the notice box', 'elmgren'),
        'priority'    => 40,
    ));
}
add_action('customize_register', 'elm_add_customizer_panels');
