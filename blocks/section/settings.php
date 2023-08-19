<?php

if (function_exists('acf_add_local_field_group')) :

    acf_add_local_field_group(array(
        'key' => 'group_64df84d60af8c',
        'title' => 'Section',
        'fields' => array(
            array(
                'key' => 'field_64df84d68a583',
                'label' => 'Full Width',
                'name' => 'full_width',
                'aria-label' => '',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'message' => 'Display section full width',
                'default_value' => 0,
                'ui' => 0,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),
            array(
                'key' => 'field_64df84d68a585',
                'label' => 'Background Color',
                'name' => 'background_color',
                'type' => 'color_picker',
                'instructions' => 'Choose a background color for the section.',
                'default_value' => '',
            ),
            array(
                'key' => 'field_64df84d68a586',
                'label' => 'Background Image',
                'name' => 'background_image',
                'type' => 'image',
                'instructions' => 'Choose a background image for the section.',
                'return_format' => 'url',
            ),
            array(
                'key' => 'field_64df84d68a587',
                'label' => 'Background Image Opacity',
                'name' => 'background_image_opacity',
                'type' => 'range',
                'instructions' => 'Adjust the opacity of the background image.',
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default_value' => 1,
            ),

        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'elm/section',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));

endif;
