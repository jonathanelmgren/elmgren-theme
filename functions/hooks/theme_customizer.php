<?php

function elmgren_customize_register($wp_customize)
{

    // Adding setting for logo height
    $wp_customize->add_setting('logo_height_setting', array(
        'default'   => '8',  // default height
        'transport' => 'refresh',
    ));

    // Adding section for Logo
    $wp_customize->add_section('elmgren_logo_section', array(
        'title'    => __('Logo Settings', 'elmgren'),
        'priority' => 30,
    ));

    // Adding control for logo height
    $wp_customize->add_control('logo_height_control', array(
        'label'    => __('Set Logo Height', 'elmgren'),
        'section'  => 'elmgren_logo_section',
        'settings' => 'logo_height_setting',
        'type'     => 'number',  // or 'range' based on your preference
        'input_attrs' => array(
            'min' => '4',
            'max' => '48',  // you can adjust the range based on the maximum size you want
            'step' => '1',
        ),
    ));
}
add_action('customize_register', 'elmgren_customize_register');

function get_logo_height()
{
    return get_theme_mod('logo_height_setting', '8');
}
