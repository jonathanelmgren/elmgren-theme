<?php

function getButtonColors()
{
    $styles = ['primary', 'secondary'];
    $attrs = ['text', 'bg', 'border'];
    $states = ['hover'];

    $colorSettings = [];

    foreach ($styles as $style) {
        foreach ($attrs as $attr) {
            $key = "elm_button_{$style}_{$attr}_color";
            $fallback = "{$attr}-{$style}-500";
            $colorSettings[$key] = ['attr' => $attr, 'fallback' => $fallback];

            // Include hover states
            foreach ($states as $state) {
                $hoverKey = "{$key}_{$state}";
                $colorSettings[$hoverKey] = ['attr' => $attr, 'fallback' => $fallback, 'prefix' => $state];
            }
        }
    }

    return $colorSettings;
}

function getTailwindColors($textElements)
{
    $colorSettings = getButtonColors();
    $colorSettings['elm_a_font_color_hover'] = ['attr' => 'text', 'fallback' => 'primary-500', 'prefix' => 'hover'];

    foreach ($textElements as $textElement) {
        $colorSettings['elm_' . $textElement . '_font_color'] = ['attr' => 'text', 'fallback' => 'gray-600'];
    }

    return $textColors = new TailwindColor($colorSettings);
}

function generateRootCssVariable($variable, $value)
{
    $value = empty($value) ? 'inherit' : $value;
    return "--{$variable}: {$value};";
}

function generateRootCssVariables()
{
    $cache = get_transient('elm_dynamic_theme_variables');
    if ($cache) {
        return $cache;
    }

    $variables = [];

    $textElements = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'a'];
    $colors = getTailwindColors($textElements);

    $variables[] = generateRootCssVariable('elm_all_border_radius', get_theme_mod('elm_border_radius_setting'));
    $variables[] = generateRootCssVariable('elm_button_primary_border_width', get_theme_mod('elm_button_primary_border_width') . 'px');
    $variables[] = generateRootCssVariable('elm_button_secondary_border_width', get_theme_mod('elm_button_secondary_border_width') . 'px');
    $variables[] = generateRootCssVariable('elm_a_font_color_hover', $colors->get_color_code('elm_a_font_color_hover'));

    // Button colors
    foreach (getButtonColors() as $buttonColorKey => $val) {
        $variables[] = generateRootCssVariable($buttonColorKey, $colors->get_color_code($buttonColorKey));
    }

    // Text sizes
    foreach ($textElements as $textElement) {
        if ($textElement !== 'a') {
            $variables[] = generateRootCssVariable('elm_' . $textElement . '_font_size', get_theme_mod('elm_' . $textElement . '_font_size') . 'rem');
        }
    }

    // Text colors
    foreach ($textElements as $textElement) {
        $variables[] = generateRootCssVariable('elm_' . $textElement . '_font_color', $colors->get_color_code('elm_' . $textElement . '_font_color'));
    }

    $variables = implode(PHP_EOL, $variables);
    $variables = ':root {' . $variables . '}';

    set_transient('elm_dynamic_theme_variables', $variables, 60 * 60 * 24);

    return $variables;
}

function elm_print_dynamic_text_size_css()
{
    echo '<style>' . generateRootCssVariables() . '</style>';
}
add_action('wp_head', 'elm_print_dynamic_text_size_css');

function elm_enqueue_gutenberg_styles()
{
    wp_add_inline_style('wp-edit-blocks', generateRootCssVariables());
}
add_action('enqueue_block_editor_assets', 'elm_enqueue_gutenberg_styles');

function clear_dynamic_text_size_cache()
{
    delete_transient('elm_dynamic_theme_variables');
}
add_action('customize_save_after', 'clear_dynamic_text_size_cache');
add_action('customize_preview_init', 'clear_dynamic_text_size_cache');
