<?php

function elm_get_inline_svg($filename)
{
    // Define SVG path
    $svg_path = get_template_directory() . '/assets/images/icons/' . $filename . '.svg';
    // Check if the SVG file exists
    if (file_exists($svg_path)) {
        // Fetch and return the content of the SVG
        echo file_get_contents($svg_path);
    } else {
        // Return a warning (or nothing) if the SVG is not found
        echo '<!-- SVG not found -->';
    }
}

function elm_get_logo_height()
{
    return get_theme_mod('logo_height_setting', '8');
}


function elm_get_tailwind_color_from_setting($setting, $fallback = false)
{
    $colors = defined('TAILWIND_COLORS') ? TAILWIND_COLORS : [];
    $color = get_theme_mod($setting, $fallback = false);

    $color = strtolower($color);

    foreach ($colors as $mainColor => $shades) {
        foreach ($shades as $shade => $shadeColor) {
            if (strtolower($shadeColor) === $color) {
                if ($shade === 'DEFAULT') {
                    return $mainColor;
                }
                return "{$mainColor}-{$shade}";
            }
        }
    }

    if (preg_match('/^#[a-f0-9]{6}$/i', $color)) {
        return "[$color]";
    }

    return $color;
}
