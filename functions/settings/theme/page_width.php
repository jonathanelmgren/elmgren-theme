<?php

// Register page width options to theme settings and page settings
function elmgren_page_width_options($field)
{
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


function elmgren_get_page_width()
{
    $w = get_field('page_width');
    if (!$w) {
        $w = get_field('default_page_width', 'options');
    }

    // Map of custom widths to the new Tailwind classes
    $tailwind_classes = [
        'width-narrow' => 'mx-[1rem] sm:mx-[6%] md:mx-[12%] lg:mx-[18%] xl:mx-[24%] 2xl:mx-[30%]',
        'width-normal' => 'mx-[1rem] sm:mx-[5%] md:mx-[10%] lg:mx-[15%] xl:mx-[20%] 2xl:mx-[25%]',
        'width-wide' => 'mx-[1rem] sm:mx-[4%] md:mx-[8%] lg:mx-[12%] xl:mx-[16%] 2xl:mx-[20%]',
        'width-ultrawide' => 'mx-[0.8rem] sm:mx-[2%] md:mx-[4%] lg:mx-[6%] xl:mx-[8%] 2xl:mx-[10%]',
        'width-full' => 'm-0'
    ];

    echo $tailwind_classes[$w] ?? '';  // Return the corresponding Tailwind class or an empty string
}
