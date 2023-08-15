<?php

// Add choices for page width usin predefined ELM_WIDTHS
add_filter('acf/load_field/name=page_width', function ($field) {
    if (defined('ELM_PAGE_WIDTHS')) {
        $field['choices'] = array_flip(ELM_PAGE_WIDTHS);
    }
    return $field;
});


// ACF fields for page settings
if (function_exists('acf_add_local_field_group')) :

    acf_add_local_field_group(array(
        'key' => 'group_64db33e46d2ef',
        'title' => 'Page settings',
        'fields' => array(
            array(
                'key' => 'field_64db33e599679',
                'label' => 'Page width',
                'name' => 'page_width',
                'aria-label' => '',
                'type' => 'select',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(),
                'default_value' => false,
                'return_format' => 'value',
                'multiple' => 0,
                'allow_null' => 0,
                'ui' => 0,
                'ajax' => 0,
                'placeholder' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ),
            ),
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
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
