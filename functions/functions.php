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


function elm_get_style_or_class_from_color($setting, $attr, $fallback = false)
{
    $colors = defined('TAILWIND_COLORS') ? TAILWIND_COLORS : [];
    $color = get_theme_mod($setting, $fallback);
    $color = strtolower($color);

    foreach ($colors as $mainColor => $shades) {
        foreach ($shades as $shade => $shadeColor) {
            if (strtolower($shadeColor) === $color) {
                if ($shade === 'DEFAULT') {
                    return "{$attr}-{$mainColor}";
                }
                return "{$attr}-{$mainColor}-{$shade}";
            }
        }
    }

    if (preg_match('/^#[a-f0-9]{6}$/i', $color)) {
        return "inline-style";
    }

    return $fallback;
}

function elm_sanitize_attr_string($string)
{
    return trim(preg_replace('/\s+/', ' ', $string));
}

function elm_apply_color_attrs_to_element($setting, $attr, $classes = "", $styles = "", $fallback = false)
{
    $styleOrClass = elm_get_style_or_class_from_color($setting, $attr, $fallback);

    $classes = elm_sanitize_attr_string($classes);
    $styles = elm_sanitize_attr_string($styles);

    if ($styleOrClass === "inline-style") {
        $color = get_theme_mod($setting, $fallback);
        $styles = "background-color: {$color};" . ($styles ? " {$styles}" : "");
    } elseif ($styleOrClass) {
        $classes = "{$styleOrClass}" . ($classes ? " {$classes}" : "");
    }

    return "style=\"{$styles}\" class=\"{$classes}\"";
}

function elm_apply_text_color($setting, $classes = "", $styles = "", $fallback = false)
{
    return elm_apply_color_attrs_to_element($setting, 'text', $classes, $styles, $fallback);
}

function elm_apply_bg_color($setting, $classes = "", $styles = "", $fallback = false)
{
    return elm_apply_color_attrs_to_element($setting, 'bg', $classes, $styles, $fallback);
}
