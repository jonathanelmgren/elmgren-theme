<?php

// Add colors to block editor color picker
function tailwind_color_picker_setup()
{
    $palette = [];

    foreach (TAILWIND_COLORS as $colorName => $shades) {
        foreach ($shades as $shade => $value) {
            // Prepare a human-readable name
            $humanReadableShade = strtoupper($shade) === 'DEFAULT' ? 'Default' : $shade;
            $humanReadableName = ucfirst($colorName) . ' ' . $humanReadableShade;

            // Add to the palette array
            $palette[] = [
                'name'  => __($humanReadableName, 'elmgren'),
                'slug'  => $colorName . '-' . $shade,
                'color' => 'var(--color-' . $colorName . '-' . $shade . ')'
            ];
        }
    }
    add_theme_support('editor-color-palette', $palette);
}
add_action('after_setup_theme', 'tailwind_color_picker_setup');

// Generate css variables to use in the block editor
function tailwind_generate_color_palette_styles()
{
    $palette = get_theme_support('editor-color-palette')[0];

    if (!$palette) return;


    echo '<style type="text/css" id="dynamic-color-palette-styles">';
    // Output the CSS variables
    echo ':root {';
    foreach (TAILWIND_COLORS as $colorName => $shades) {
        foreach ($shades as $shade => $value) {
            echo "--color-{$colorName}-{$shade}: {$value};";
        }
    }
    echo '}';
    foreach ($palette as $color) {
        $slug = strtolower($color['slug']);
        echo ".has-{$slug}-color { color: {$color['color']}; }";
        echo ".has-{$slug}-background-color { background-color: {$color['color']}; }";
    }
    echo '</style>';
}
add_action('wp_head', 'tailwind_generate_color_palette_styles');
add_action('admin_head', 'tailwind_generate_color_palette_styles');
