<?php

function elm_customize_notice($wp_customize)
{
    $attrs = ['bg', 'border', 'text'];

    // Position & Sizing
    $wp_customize->add_setting('notice_bg_width', [
        'default' => 'width-full'
    ]);
    $wp_customize->add_setting('notice_content_width', [
        'default' => elm_get_page_width(true)
    ]);
    $wp_customize->add_setting('notice_text_align', array(
        'default' => 'text-center'
    ));

    $wp_customize->add_control('notice_bg_width_control', array(
        'type' => 'select',
        'choices' => defined('ELM_PAGE_WIDTHS_REVERSE') ? ELM_PAGE_WIDTHS_REVERSE : [],
        'label'    => __("Notice width", 'elmgren'),
        'section'  => 'elm_notice_position_section',
        'settings' => 'notice_bg_width',
    ));
    $wp_customize->add_control('notice_content_width_control', array(
        'type' => 'select',
        'choices' => defined('ELM_PAGE_WIDTHS_REVERSE') ? ELM_PAGE_WIDTHS_REVERSE : [],
        'label'    => __("Notice content width", 'elmgren'),
        'section'  => 'elm_notice_position_section',
        'settings' => 'notice_content_width',
    ));
    $wp_customize->add_control('notice_text_align_control', array(
        'type' => 'radio',
        'choices' => [
            'text-left' => 'Left',
            'text-center' => 'Center',
            'text-right' => 'Right',
        ],
        'label'    => __("Text align", 'elmgren'),
        'section'  => 'elm_notice_position_section',
        'settings' => 'notice_text_align',
    ));

    // Colors
    foreach (Elm_Notice::STATUSES as $status) {
        foreach ($attrs as $attr) {
            $capitalize = ucfirst($status);
            $wp_customize->add_setting("notice_{$status}_{$attr}", array(
                'transport' => 'refresh',
                'sanitize_callback' => 'sanitize_tailwind'
            ));
            $wp_customize->add_control(new TailwindColorPickerThemeCustomizer($wp_customize, "notice_{$status}_{$attr}_control", array(
                'label'    => __("{$capitalize} {$attr}", 'elmgren'),
                'section'  => "elm_notice_{$status}_section",
                'settings' => "notice_{$status}_{$attr}",
            )));
        }
    }
}
add_action('customize_register', 'elm_customize_notice');
