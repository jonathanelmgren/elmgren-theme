<?php

function elm_customize_buttons($wp_customize)
{
    $buttonSettings = ['Primary' => 'primary', 'Secondary' => 'secondary'];

    foreach ($buttonSettings as $label => $type) {
        add_setting_and_control(
            $wp_customize,
            [
                'setting' => "elm_button_{$type}_border_width",
                'settingArgs' => [
                    'default' => '1',
                ],
                'controlArgs' => [
                    'label' => __("$label Button Border Width", 'elmgren'),
                    'section' => 'elm_button_settings',
                    'type' => 'range',
                    'input_attrs' => [
                        'min' => '0',
                        'max' => '10',
                        'step' => '1',
                    ],
                ],
            ]
        );

        add_tailwind_color_picker_control($wp_customize, "elm_button_{$type}_bg_color", "$label Button Background Color", 'elm_button_settings');
        add_tailwind_color_picker_control($wp_customize, "elm_button_{$type}_text_color", "$label Button Text Color", 'elm_button_settings');
        add_tailwind_color_picker_control($wp_customize, "elm_button_{$type}_border_color", "$label Button Border Color", 'elm_button_settings');

        add_tailwind_color_picker_control($wp_customize, "elm_button_{$type}_bg_color_hover", "$label Button Background Color - Hover", 'elm_button_settings');
        add_tailwind_color_picker_control($wp_customize, "elm_button_{$type}_text_color_hover", "$label Button Text Color - Hover", 'elm_button_settings');
        add_tailwind_color_picker_control($wp_customize, "elm_button_{$type}_border_color_hover", "$label Button Border Color - Hover", 'elm_button_settings');
    }
}

function elm_customize_text($wp_customize)
{
    $textSettings = ['H1' => 'h1', 'H2' => 'h2', 'H3' => 'h3', 'H4' => 'h4', 'H5' => 'h5', 'H6' => 'h6', 'Normal' => 'p'];
    $baseSize = 2;

    foreach ($textSettings as $label => $tag) {
        $baseSize *= 0.9;
        add_setting_and_control(
            $wp_customize,
            [
                'setting' => "elm_{$tag}_font_size",
                'settingArgs' => [
                    'default' => $baseSize,
                ],
                'controlArgs' => [
                    'label' => __("$label Font Size", 'elmgren'),
                    'section' => 'elm_text_sizes',
                    'type' => 'range',
                    'input_attrs' => [
                        'min' => '0.5',
                        'max' => '3',
                        'step' => '0.1',
                    ],
                ],
            ]
        );

        add_setting_and_control(
            $wp_customize,
            [
                'setting' => "elm_{$tag}_font_color",
                'settingArgs' => [
                    'sanitize_callback' => 'sanitize_tailwind',
                ],
                'controlArgs' => []
            ]
        );
        add_tailwind_color_picker_control($wp_customize, "elm_{$tag}_font_color", "$label Font Color", 'elm_text_colors');
    }
}

function elm_customizer_general_settings($wp_customize)
{
    $generalSettings = [
        [
            'setting' => 'elm_content_spacing_setting',
            'settingArgs' => [
                'default' => '0',
            ],
            'controlArgs' => [
                'label' => __('Content Spacing', 'elmgren'),
                'description' => 'Set the spacing between content and header/footer',
                'section' => 'elm_general_section',
                'type' => 'range',
                'input_attrs' => [
                    'min' => '0',
                    'max' => '12',
                    'step' => '0.5',
                ],
            ],
        ],
        [
            'setting' => 'elm_border_radius_setting',
            'settingArgs' => [
                'default' => '0px',
            ],
            'controlArgs' => [
                'label' => __('Border radius', 'elmgren'),
                'description' => 'Set the border radius for all elements',
                'section' => 'elm_general_section',
                'type' => 'select',
                'choices'  => [
                    '0px'   => 'None',
                    '2px'     => 'Extra Small (2px)',
                    '4px'  => 'Small (4px)',
                    '8px' => 'Medium (8px)',
                    '12px'  => 'Large (12px)',
                    '16px'     => 'Extra Large (16px)',
                ],
            ],
        ],
        [
            'setting' => 'elm_page_width_setting',
            'settingArgs' => [
                'default' => '0px',
            ],
            'controlArgs' => [
                'label' => __('Page width', 'elmgren'),
                'description' => 'Set the general page width for your website',
                'section' => 'elm_general_section',
                'type' => 'select',
                'choices'  => [
                    'width-narrow'   => 'Narrow',
                    'width-normal'   => 'Normal',
                    'width-wide'     => 'Wide',
                    'width-ultrawide' => 'Ultrawide',
                    'width-full'     => 'Fullwidth',
                ],
            ],
        ],
    ];

    foreach ($generalSettings as $args) {
        add_setting_and_control($wp_customize, $args);
    }

    elm_customize_text($wp_customize);
    elm_customize_buttons($wp_customize);
}

add_action('customize_register', 'elm_customizer_general_settings');
