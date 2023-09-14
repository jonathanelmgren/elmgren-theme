<?php

function elm_add_general_sections($wp_customize)
{
    $wp_customize->add_section('elm_page_section', array(
        'title'    => __('Page settings', 'elmgren'),
        'priority' => 1,
        'panel'    => 'elm_general_panel'
    ));
}
add_action('customize_register', 'elm_add_general_sections');
