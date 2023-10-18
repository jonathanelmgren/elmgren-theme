<?php

function elm_customize_notice($wp_customize)
{
    $attrs = ['bg', 'border', 'text'];

    add_setting_and_control(
        $wp_customize,
        [
            'setting' => "elm_notice_bg_width",
            'settingArgs' => [
                'default' => 'width-full',
            ],
            'controlArgs' => [
                'label'    => __("Notice width", 'elmgren'),
                'section' => 'elm_notice_position_section',
                'type' => 'select',
                'choices' => defined('ELM_PAGE_WIDTHS_REVERSE') ? ELM_PAGE_WIDTHS_REVERSE : [],
            ],
        ]
    );
    add_setting_and_control(
        $wp_customize,
        [
            'setting' => "elm_notice_content_width",
            'settingArgs' => [
                'default' => elm_get_page_width(true),
            ],
            'controlArgs' => [
                'label'    => __("Notice content width", 'elmgren'),
                'section' => 'elm_notice_position_section',
                'type' => 'select',
                'choices' => defined('ELM_PAGE_WIDTHS_REVERSE') ? ELM_PAGE_WIDTHS_REVERSE : [],
            ],
        ]
    );
    add_setting_and_control(
        $wp_customize,
        [
            'setting' => "elm_notice_text_align",
            'settingArgs' => [
                'default' => 'text-center',
            ],
            'controlArgs' => [
                'label'    => __("Text align", 'elmgren'),
                'section' => 'elm_notice_position_section',
                'type' => 'radio',
                'choices' => [
                    'text-left' => 'Left',
                    'text-center' => 'Center',
                    'text-right' => 'Right',
                ],
            ],
        ]
    );

    // Colors
    foreach (Elm_Notice::STATUSES as $status) {
        foreach ($attrs as $attr) {
            $capitalize = ucfirst($status);
            add_tailwind_color_picker_control($wp_customize, "notice_{$status}_{$attr}", __("{$capitalize} {$attr}", 'elmgren'), "elm_notice_{$status}_section");
        }
    }
}
add_action('customize_register', 'elm_customize_notice');
