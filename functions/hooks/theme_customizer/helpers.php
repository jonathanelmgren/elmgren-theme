<?php

function add_setting_and_control($wp_customize, $args, $controlClass = null)
{
    $defaultSettingArgs = [
        'transport' => 'refresh'
    ];
    $args['settingArgs'] = array_merge($defaultSettingArgs, $args['settingArgs'] ?? []);

    $wp_customize->add_setting($args['setting'], $args['settingArgs']);

    $controlArgs = [
        'label' => $args['controlArgs']['label'] ?? '',
        'section' => $args['controlArgs']['section'] ?? '',
        'settings' => $args['setting'],
        'type' => $args['controlArgs']['type'] ?? 'text',
        'input_attrs' => $args['controlArgs']['input_attrs'] ?? [],
        'choices' => $args['controlArgs']['choices'] ?? [],
    ];

    if ($controlClass) {
        $wp_customize->add_control(new $controlClass($wp_customize, $args['setting'] . "_control", $controlArgs));
    } else {
        $wp_customize->add_control($args['setting'] . "_control", $controlArgs);
    }
}

function add_tailwind_color_picker_control($wp_customize, $settingId, $label, $section, $default = null)
{
    add_setting_and_control(
        $wp_customize,
        [
            'setting' => $settingId,
            'settingArgs' => [
                'sanitize_callback' => 'sanitize_tailwind',
                'default' => $default
            ],
            'controlArgs' => [
                'label' => __($label, 'elmgren'),
                'section' => $section,
            ],
        ],
        TailwindColorPickerThemeCustomizer::class  // Provide the class name as an argument
    );
}

function add_tailwind_color_picker_control_with_hover($wp_customize, $settingId, $label, $section)
{
    add_setting_and_control(
        $wp_customize,
        [
            'setting' => $settingId,
            'settingArgs' => [
                'sanitize_callback' => 'sanitize_tailwind',
            ],
            'controlArgs' => [
                'label' => __($label, 'elmgren'),
                'section' => $section,
            ],
        ],
        TailwindColorPickerThemeCustomizer::class  // Provide the class name as an argument
    );
    add_setting_and_control(
        $wp_customize,
        [
            'setting' => $settingId . '_hover',
            'settingArgs' => [
                'sanitize_callback' => 'sanitize_tailwind',
            ],
            'controlArgs' => [
                'label' => __($label . ' - Hover', 'elmgren'),
                'section' => $section,
            ],
        ],
        TailwindColorPickerThemeCustomizer::class  // Provide the class name as an argument
    );
}
