<?php

function elmgren_customize_footer($wp_customize)
{

    // Section for Footer Settings
    $wp_customize->add_section('elmgren_footer_section', array(
        'title'    => __('Footer Settings', 'elmgren'),
        'priority' => 40,
    ));

    // Social links
    $socials = array('facebook', 'instagram', 'youtube', 'github', 'twitter');
    foreach ($socials as $social) {
        $wp_customize->add_setting('footer_' . $social . '_link', array(
            'default'   => '',
            'transport' => 'refresh',
        ));
        $wp_customize->add_control('footer_' . $social . '_link_control', array(
            'label'    => ucfirst($social) . ' Link',
            'section'  => 'elmgren_footer_section',
            'settings' => 'footer_' . $social . '_link',
            'type'     => 'url',
        ));
    }

    // Icon color setting
    $wp_customize->add_setting('footer_icon_color', array(
        'default'   => '#000000',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_icon_color_control', array(
        'label'    => __('Footer Icon Color', 'elmgren'),
        'section'  => 'elmgren_footer_section',
        'settings' => 'footer_icon_color',
    )));

    // Link color setting
    $wp_customize->add_setting('footer_link_color', array(
        'default'   => '#000000',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_link_color_control', array(
        'label'    => __('Footer Link Color', 'elmgren'),
        'section'  => 'elmgren_footer_section',
        'settings' => 'footer_link_color',
    )));

    // Footer text setting
    $wp_customize->add_setting('footer_text', array(
        'default'   => get_bloginfo('name'),
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('footer_text_control', array(
        'label'    => __('Footer Text', 'elmgren'),
        'section'  => 'elmgren_footer_section',
        'settings' => 'footer_text',
        'type'     => 'textarea',
    ));

    // Menu link color setting
    $wp_customize->add_setting('footer_menu_link_color', array(
        'default'   => '#000000',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_menu_link_color_control', array(
        'label'    => __('Footer Menu Link Color', 'elmgren'),
        'section'  => 'elmgren_footer_section',
        'settings' => 'footer_menu_link_color',
    )));
}
add_action('customize_register', 'elmgren_customize_footer');
