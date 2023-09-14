<?php

function elm_add_footer_sections($wp_customize)
{
    $wp_customize->add_section('elm_footer_links_section', array(
        'title'    => __('Social links', 'elmgren'),
        'priority' => 1,
        'panel'    => 'elm_footer_panel'
    ));

    $wp_customize->add_section('elm_footer_colors_section', array(
        'title'    => __('Background & Text colors', 'elmgren'),
        'priority' => 2,
        'panel'    => 'elm_footer_panel'
    ));

    $wp_customize->add_section('elm_footer_text_section', array(
        'title'    => __('Text settings', 'elmgren'),
        'priority' => 3,
        'panel'    => 'elm_footer_panel'
    ));
}
add_action('customize_register', 'elm_add_footer_sections');
