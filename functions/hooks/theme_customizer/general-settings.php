<?php

function elm_customizer_general_settings($wp_customize)
{
    // Page settings
    $wp_customize->add_setting('content_spacing_setting', array(
        'default'   => '0',  // default height
        'transport' => 'refresh',
    ));
    $wp_customize->add_setting('page_width_setting', array(
        'default'   => 'width-normal',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('content_spacing_control', array(
        'label'    => __('Content spacing', 'elmgren'),
        'description' => 'Set the spacing between content and header/footer',
        'section'  => 'elm_page_section',
        'settings' => 'content_spacing_setting',
        'type'     => 'range',
        'input_attrs' => array(
            'min' => '0',
            'max' => '12',
            'step' => '0.5',
        ),
    ));
    $wp_customize->add_control('page_width_control', array(
        'label'    => __('Select Page Width', 'elmgren'),
        'section'  => 'elm_page_section',
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
add_action('customize_register', 'elm_customizer_general_settings');
