<?php

function elm_customize_footer($wp_customize)
{
    // Social links
    $socials = array('facebook', 'instagram', 'youtube', 'github', 'twitter');
    foreach ($socials as $social) {
        add_setting_and_control(
            $wp_customize,
            [
                'setting' => 'elm_footer_' . $social . '_link',
                'settingsArgs' => [
                    'default' => get_bloginfo('name'),
                ],
                'controlArgs' => [
                    'label' => __(ucfirst($social) . ' Link', 'elmgren'),
                    'section' => 'elm_footer_links_section',
                    'type' => 'url',
                ]
            ]
        );
    }

    add_tailwind_color_picker_control($wp_customize, "elm_footer_bg_color", "Footer Background color", 'elm_footer_colors_section');
    add_tailwind_color_picker_control($wp_customize, "elm_elm_footer_text_color", "Footer copyright text color", 'elm_footer_colors_section');
    add_tailwind_color_picker_control_with_hover($wp_customize, "elm_footer_icon_color", "Footer Icon color", 'elm_footer_colors_section');
    add_tailwind_color_picker_control_with_hover($wp_customize, "elm_footer_menu_link_color", "Footer Menu links color", 'elm_footer_colors_section');

    add_setting_and_control(
        $wp_customize,
        [
            'setting' => 'elm_footer_text',
            'settingsArgs' => [
                'default' => get_bloginfo('name'),
            ],
            'controlArgs' => [
                'label' => __('Footer Text', 'elmgren'),
                'section' => 'elm_footer_text_section',
                'type' => 'textarea',
            ]
        ]
    );
}
add_action('customize_register', 'elm_customize_footer');
