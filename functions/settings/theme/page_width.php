<?php

// Register page width options to theme settings and page settings
function elmgren_page_width_options($field)
{
    $widths = [
        'Narrow' => 'width-narrow',
        'Normal' => 'width-normal',
        'Wide' => 'width-wide',
        'Ultrawide' => 'width-ultrawide',
        'Fullwidth' => 'width-full',
    ];

    $field['required'] = false;
    $field['choices'] = [];

    if ($field['name'] === 'page_width') {
        $field['default_value'] = get_field('default_page_width', 'options');
    }

    foreach ($widths as $label => $value) {
        $field['choices'][$value] = $label;
    }
    return $field;
}
add_filter('acf/load_field/name=page_width', 'elmgren_page_width_options');
add_filter('acf/load_field/name=default_page_width', 'elmgren_page_width_options');


function elmgren_get_page_width()
{
    $w = get_field('page_width');
    if (!$w) {
        $w = get_field('default_page_width', 'options');
    }
    echo $w;
}