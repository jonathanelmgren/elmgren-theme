<?php

function generateCssRule($selector, $properties, $prefix = '')
{
    $selectorWithPrefix = $prefix ? $prefix . ' ' . $selector : $selector;
    return $selectorWithPrefix . ' { ' . implode(' ', $properties) . ' }';
}

function elm_get_dynamic_text_size_css($prefix = '')
{
    // Check if the CSS is cached
    $cached_css = get_transient('elm_dynamic_text_size_css_' . $prefix);
    if ($cached_css) {
        return $cached_css;
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
            ["font-size: {$fontSize}rem;", "color: {$colorCode};","margin:0;","line-height:1.5;","font-weight:inherit;"],
            $prefix
        );
    }

    // Anchor elements
    $cssRules[] = generateCssRule(
        'a:hover',
        ['color: ' . $textColors->get_color_code('elm_a_font_color_hover') . ';'],
        $prefix
    );

    // General elements
    $cssRules[] = generateCssRule(
        'button, input, a.wp-element-button, a.btn, img, textarea, select, fieldset, blockquote',
        ['border-radius: ' . $borderRadius . ';'],
        $prefix
    );

    // Button elements
    $cssRules[] = generateCssRule(
        'button, a.btn, div.wp-block-button__link.wp-element-button',
        [
            'border-color: ' . $textColors->get_color_code('elm_button_primary_border_color') . ';',
            'border-width: ' . $primaryBorderWidth . 'px;',
            'background-color: ' . $textColors->get_color_code('elm_button_primary_bg_color') . ';',
            'color: ' . $textColors->get_color_code('elm_button_primary_text_color') . ';'
        ],
        $prefix
    );
    $cssRules[] = generateCssRule(
        'button.secondary, a.btn.secondary',
        [
            'border-width: ' . $secondaryBorderWidth . 'px;',
            'border-color: ' . $textColors->get_color_code('elm_button_secondary_border_color') . ';',
            'background-color: ' . $textColors->get_color_code('elm_button_secondary_bg_color') . ';',
            'color: ' . $textColors->get_color_code('elm_button_secondary_text_color') . ';'
        ],
        $prefix
    );
    // Hover states for buttons
    $cssRules[] = generateCssRule(
        'button:hover, a.btn:hover',
        [
            'border-color: ' . $textColors->get_color_code('elm_button_primary_border_color_hover') . ';',
            'background-color: ' . $textColors->get_color_code('elm_button_primary_bg_color_hover') . ';',
            'color: ' . $textColors->get_color_code('elm_button_primary_text_color_hover') . ';'
        ],
        $prefix
    );
    $cssRules[] = generateCssRule(
        'button.secondary:hover, a.btn.secondary:hover',
        [
            'border-color: ' . $textColors->get_color_code('elm_button_secondary_border_color_hover') . ';',
            'background-color: ' . $textColors->get_color_code('elm_button_secondary_bg_color_hover') . ';',
            'color: ' . $textColors->get_color_code('elm_button_secondary_text_color_hover') . ';'
        ],
        $prefix
    );

    $final_css = implode(PHP_EOL, $cssRules);

    set_transient('elm_dynamic_text_size_css_' . $prefix, $final_css, 7 * DAY_IN_SECONDS);

    return $final_css;
}

function elm_print_dynamic_text_size_css()
{
    echo '<style type="text/css" id="elm_dynamic_css">' . elm_get_dynamic_text_size_css() . '</style>';
}
add_action('wp_head', 'elm_print_dynamic_text_size_css');

function elm_enqueue_gutenberg_styles()
{
    $prefix = '.editor-styles-wrapper';

    $final_css = elm_get_dynamic_text_size_css($prefix);

    wp_add_inline_style('wp-edit-blocks', $final_css);
}
add_action('enqueue_block_editor_assets', 'elm_enqueue_gutenberg_styles');

function clear_dynamic_text_size_cache()
{
    delete_transient('elm_dynamic_text_size_css_' . '.editor-styles-wrapper');
    delete_transient('elm_dynamic_text_size_css_');
}
add_action('customize_save_after', 'clear_dynamic_text_size_cache');
add_action('customize_preview_init', 'clear_dynamic_text_size_cache');
