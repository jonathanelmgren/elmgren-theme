<?php

function elm_customize_footer($wp_customize)
{
    // Social links
    $socials = array('facebook', 'instagram', 'youtube', 'github', 'twitter');
    foreach ($socials as $social) {
        $wp_customize->add_setting('footer_' . $social . '_link', array(
            'default'   => '',
            'transport' => 'refresh',
        ));
        $wp_customize->add_control('footer_' . $social . '_link_control', array(
            'label'    => ucfirst($social) . ' Link',
            'section'  => 'elm_footer_links_section',
            'settings' => 'footer_' . $social . '_link',
            'type'     => 'url',
        ));
    }

    // Background & Text colors
    $wp_customize->add_setting('footer_bg_color', array(
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_tailwind'
    ));
    $wp_customize->add_setting('footer_icon_color', array(
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_tailwind'

    ));
    $wp_customize->add_setting('footer_icon_color_hover', array(
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_tailwind'
    ));
    $wp_customize->add_setting('footer_menu_link_color', array(
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_tailwind'
    ));
    $wp_customize->add_setting('footer_menu_link_color_hover', array(
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_tailwind'
    ));
    $wp_customize->add_setting('footer_text_color', array(
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_tailwind'
    ));

    $wp_customize->add_control(new TailwindColorPickerThemeCustomizer($wp_customize, 'footer_bg_color_control', array(
        'label'    => __('Footer Background Color', 'elmgren'),
        'section'  => 'elm_footer_colors_section',
        'settings' => 'footer_bg_color',
    )));
    $wp_customize->add_control(new TailwindColorPickerThemeCustomizer($wp_customize, 'footer_icon_color_control', array(
        'label'    => __('Footer Icon Color', 'elmgren'),
        'section'  => 'elm_footer_colors_section',
        'settings' => 'footer_icon_color',
    )));
    $wp_customize->add_control(new TailwindColorPickerThemeCustomizer($wp_customize, 'footer_icon_color_hover_control', array(
        'label'    => __('Footer Icon Color - Hover', 'elmgren'),
        'section'  => 'elm_footer_colors_section',
        'settings' => 'footer_icon_color_hover',
    )));
    $wp_customize->add_control(new TailwindColorPickerThemeCustomizer($wp_customize, 'footer_menu_link_color_control', array(
        'label'    => __('Footer Menu Link Color', 'elmgren'),
        'section'  => 'elm_footer_colors_section',
        'settings' => 'footer_menu_link_color',
    )));
    $wp_customize->add_control(new TailwindColorPickerThemeCustomizer($wp_customize, 'footer_menu_link_color_hover_control', array(
        'label'    => __('Footer Menu Link Color - Hover', 'elmgren'),
        'section'  => 'elm_footer_colors_section',
        'settings' => 'footer_menu_link_color_hover',
    )));
    $wp_customize->add_control(new TailwindColorPickerThemeCustomizer($wp_customize, 'footer_text_color_control', array(
        'label'    => __('Footer Text Color', 'elmgren'),
        'section'  => 'elm_footer_colors_section',
        'settings' => 'footer_text_color',
    )));

    // Text settings
    $wp_customize->add_setting('footer_text', array(
        'default'   => get_bloginfo('name'),
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('footer_text_control', array(
        'label'    => __('Footer Text', 'elmgren'),
        'section'    => 'elm_footer_text_section',
        'settings' => 'footer_text',
        'type'     => 'textarea',
    ));
}
add_action('customize_register', 'elm_customize_footer');
