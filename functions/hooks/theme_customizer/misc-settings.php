<?php

function elm_customize_misc($wp_customize)
{

    // Section for Miscellaneous Settings
    $wp_customize->add_section('elm_misc_section', array(
        'title'    => __('Miscellaneous Settings', 'elmgren'),
        'priority' => 50,
    ));

    // Page width dropdown
    $wp_customize->add_setting('page_width_setting', array(
        'default'   => 'width-normal',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('page_width_control', array(
        'label'    => __('Select Page Width', 'elmgren'),
        'section'  => 'elm_misc_section',
        'settings' => 'page_width_setting',
        'type'     => 'select',
        'choices'  => array(
            'width-narrow'   => 'Narrow',
            'width-normal'   => 'Normal',
            'width-wide'     => 'Wide',
            'width-ultrawide' => 'Ultrawide',
            'width-full'     => 'Fullwidth',
        ),
    ));
}
add_action('customize_register', 'elm_customize_misc');
