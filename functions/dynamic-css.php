<?php

function generateCssRule($selector, $properties)
{
    return $selector . ' { ' . implode(' ', $properties) . ' }';
}

function generate_dynamic_text_size_css()
{
    // Check if the CSS is cached
    $cached_css = get_transient('dynamic_text_size_css');
    if ($cached_css) {
        echo $cached_css;
        return;
    }

    $textElements = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'a'];
    $colorSettings = [
        'elm_a_font_color_hover' => ['attr' => 'text', 'fallback' => 'text-primary-500', 'prefix' => 'hover'],
        'elm_button_primary_bg_color' => ['attr' => 'bg', 'fallback' => 'bg-primary-500'],
        'elm_button_secondary_bg_color' => ['attr' => 'bg', 'fallback' => 'bg-secondary-500'],
        'elm_button_primary_text_color' => ['attr' => 'text', 'fallback' => 'text-primary-500'],
        'elm_button_secondary_text_color' => ['attr' => 'text', 'fallback' => 'text-secondary-500'],
        'elm_button_primary_border_color' => ['attr' => 'border', 'fallback' => 'text-primary-500'],
        'elm_button_secondary_border_color' => ['attr' => 'border', 'fallback' => 'text-primary-500'],
        'elm_button_primary_bg_color_hover' => ['prefix' => 'hover', 'attr' => 'bg', 'fallback' => 'bg-primary-500'],
        'elm_button_secondary_bg_color_hover' => ['prefix' => 'hover', 'attr' => 'bg', 'fallback' => 'bg-secondary-500'],
        'elm_button_primary_text_color_hover' => ['prefix' => 'hover', 'attr' => 'text', 'fallback' => 'text-primary-500'],
        'elm_button_secondary_text_color_hover' => ['prefix' => 'hover', 'attr' => 'text', 'fallback' => 'text-secondary-500'],
        'elm_button_primary_border_color_hover' => ['prefix' => 'hover', 'attr' => 'border', 'fallback' => 'text-primary-500'],
        'elm_button_secondary_border_color_hover' => ['prefix' => 'hover', 'attr' => 'border', 'fallback' => 'text-primary-500'],
    ];

    foreach ($textElements as $textElement) {
        $colorSettings['elm_' . $textElement . '_font_color'] = ['attr' => 'text', 'fallback' => 'text-gray-600'];
    }

    $borderRadius = get_theme_mod('elm_border_radius_setting', '0px');
    $primaryBorderWidth = get_theme_mod('elm_button_primary_border_width', '0');
    $secondaryBorderWidth = get_theme_mod('elm_button_secondary_border_width', '0');

    $textColors = new TailwindColor($colorSettings);

    $cssRules = [];

    // Text elements
    foreach ($textElements as $textElement) {
        $fontSize = get_theme_mod('elm_' . $textElement . '_font_size', '1.5');
        $colorCode = $textColors->get_color_code('elm_' . $textElement . '_font_color');

        $cssRules[] = generateCssRule(
            $textElement,
            ["font-size: {$fontSize}rem;", "color: {$colorCode};"]
        );
    }

    // Anchor elements
    $cssRules[] = generateCssRule('a:hover', ['color: ' . $textColors->get_color_code('elm_a_font_color_hover') . ';']);

    // General elements
    $cssRules[] = generateCssRule('button, input, a.wp-element-button, a.btn, img, textarea, select, fieldset, blockquote', ['border-radius: ' . $borderRadius . ';']);

    // Button elements
    $cssRules[] = generateCssRule(
        'button, a.btn',
        [
            'border-color: ' . $textColors->get_color_code('elm_button_primary_border_color') . ';',
            'border-width: ' . $primaryBorderWidth . 'px;',
            'background-color: ' . $textColors->get_color_code('elm_button_primary_bg_color') . ';',
            'color: ' . $textColors->get_color_code('elm_button_primary_text_color') . ';'
        ]
    );
    $cssRules[] = generateCssRule(
        'button.secondary, a.btn.secondary',
        [
            'border-width: ' . $secondaryBorderWidth . 'px;',
            'border-color: ' . $textColors->get_color_code('elm_button_secondary_border_color') . ';',
            'background-color: ' . $textColors->get_color_code('elm_button_secondary_bg_color') . ';',
            'color: ' . $textColors->get_color_code('elm_button_secondary_text_color') . ';'
        ]
    );
    // Hover states for buttons
    $cssRules[] = generateCssRule(
        'button:hover, a.btn:hover',
        [
            'border-color: ' . $textColors->get_color_code('elm_button_primary_border_color_hover') . ';',
            'background-color: ' . $textColors->get_color_code('elm_button_primary_bg_color_hover') . ';',
            'color: ' . $textColors->get_color_code('elm_button_primary_text_color_hover') . ';'
        ]
    );
    $cssRules[] = generateCssRule(
        'button.secondary:hover, a.btn.secondary:hover',
        [
            'border-color: ' . $textColors->get_color_code('elm_button_secondary_border_color_hover') . ';',
            'background-color: ' . $textColors->get_color_code('elm_button_secondary_bg_color_hover') . ';',
            'color: ' . $textColors->get_color_code('elm_button_secondary_text_color_hover') . ';'
        ]
    );

    $final_css = '<style type="text/css">' . implode(PHP_EOL, $cssRules) . '</style>';

    set_transient('dynamic_text_size_css', $final_css, 7 * DAY_IN_SECONDS);

    echo $final_css;
}
add_action('wp_head', 'generate_dynamic_text_size_css');

function clear_dynamic_text_size_cache()
{
    delete_transient('dynamic_text_size_css');
}
add_action('customize_save_after', 'clear_dynamic_text_size_cache');
add_action('customize_preview_init', 'clear_dynamic_text_size_cache');
