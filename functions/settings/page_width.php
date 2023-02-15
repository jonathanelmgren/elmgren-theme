<?php



// Add page width options to theme settings and page settings
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

    foreach (ELMGREN_PAGE_WIDTHS as $label => $value) {
        $field['choices'][$value] = $label;
    }
    return $field;
}
add_filter('acf/load_field/name=page_width', 'elmgren_page_width_options');
add_filter('acf/load_field/name=default_page_width', 'elmgren_page_width_options');
