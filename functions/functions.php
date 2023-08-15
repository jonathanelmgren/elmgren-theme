<?php

/**
 * Returns the inline SVG content.
 *
 * @param string $filename The filename of the SVG without extension.
 */
function elm_get_inline_svg($filename)
{
    $fullPath = get_template_directory() . '/assets/images/icons/' . $filename . '.svg';

    if (!file_exists($fullPath)) {
        echo '<!-- SVG not found -->';
        return;
    }

    echo file_get_contents($fullPath);
}

/**
 * Returns the logo height.
 *
 * @return string
 */
function elm_get_logo_height()
{
    return get_theme_mod('logo_height_setting', '8');
}

/**
 * Returns the corresponding Tailwind class or inline style for a given color setting.
 *
 * @param string $setting The theme mod setting key.
 * @param string $attr The attribute for which the color is being set, e.g., 'text', 'bg'.
 * @param mixed $fallback The fallback value if the setting is not found.
 *
 * @return string
 */
function elm_get_style_or_class_from_color($setting, $attr, $fallback = false)
{
    $colors = defined('TAILWIND_COLORS') ? TAILWIND_COLORS : [];
    $color = strtolower(get_theme_mod($setting, $fallback));

    foreach ($colors as $mainColor => $shades) {
        foreach ($shades as $shade => $shadeColor) {
            if (strtolower($shadeColor) !== $color) {
                continue;
            }

            if ($shade === 'DEFAULT') {
                return ["tailwind" => "{$attr}-{$mainColor}", "color" => $shadeColor];
            }

            return ["tailwind" => "{$attr}-{$mainColor}-{$shade}", "color" => $shadeColor];
        }
    }

    if (preg_match('/^#[a-f0-9]{6}$/i', $color)) {
        return ["tailwind" => null, "color" => $color];
    }

    return ["tailwind" => $fallback, "color" => null];  // Ensure the fallback is returned if no other conditions are met.
}



/**
 * Sanitizes an attribute string by trimming and removing extra spaces.
 *
 * @param string $string The string to sanitize.
 *
 * @return string
 */
function elm_sanitize_attr_string($string)
{
    return trim(preg_replace('/\s+/', ' ', $string));
}

/**
 * Returns a combined class and style attribute string for given settings.
 *
 * @param mixed $settings The settings for which the classes and styles are being generated.
 * @param string $attr The attribute for which the color is being set.
 * @param string $prefix The prefix for the class.
 * @param mixed $fallback The fallback value.
 * @param string $additional_classes Additional classes to append.
 * @param string $additional_styles Additional styles to append.
 *
 * @return string
 */
function elm_get_classes_and_styles($settings, $attr = 'text', $prefix = "", $fallback = false, $additional_classes = '', $additional_styles = '')
{
    if (is_string($settings)) {
        $settings = [
            $settings => ['attr' => $attr, 'prefix' => $prefix, 'fallback' => $fallback]
        ];
    }

    $combined_classes = [$additional_classes];
    $combined_styles = [$additional_styles];

    foreach ($settings as $setting => $config) {
        $currentAttr = $config['attr'] ?? 'text';
        $currentPrefix = $config['prefix'] ?? "";
        $currentFallback = $config['fallback'] ?? false;

        $styleOrClass = elm_get_style_or_class_from_color($setting, $currentAttr, $currentFallback);

        if ($styleOrClass['tailwind'] || $styleOrClass['color']) {
            if ($styleOrClass['tailwind'] === null && $currentPrefix === "hover") {
                $combined_styles[] = "--hover-color: {$styleOrClass['color']}";
                $combined_classes[] = "custom-hover";
            } elseif ($styleOrClass['tailwind'] === null) {
                // If there's no tailwind class, but there's a color, set the inline style
                $combined_styles[] = get_inline_style($currentAttr, $styleOrClass['color']);
            } else {
                $combined_classes[] = get_class_name($styleOrClass['tailwind'], $currentPrefix);
            }
        }
    }

    return format_attributes($combined_classes, $combined_styles);
}

/**
 * Returns the inline style for a given attribute and color.
 *
 * @param string $attr The attribute.
 * @param string $color The color value.
 *
 * @return string
 */
function get_inline_style($attr, $color)
{
    $tw_attr_to_styles = [
        'text' => 'color',
        'bg' => 'background-color',
    ];

    $style_attr = $tw_attr_to_styles[$attr] ?? 'background-color';

    return "{$style_attr}: {$color};";
}

/**
 * Returns the class name with or without a prefix.
 *
 * @param string $styleOrClass The style or class.
 * @param string $prefix The prefix.
 *
 * @return string
 */
function get_class_name($styleOrClass, $prefix)
{
    return $prefix ? "{$prefix}:{$styleOrClass}" : $styleOrClass;
}

/**
 * Returns the formatted attributes string for classes and styles.
 *
 * @param array $classes The array of classes.
 * @param array $styles The array of styles.
 *
 * @return string
 */
function format_attributes($classes, $styles)
{
    $classes_string = implode(' ', array_filter($classes));
    $styles_string = implode('; ', array_filter($styles));

    return "style=\"$styles_string\" class=\"$classes_string\"";
}

/**
 * Returns the width for the current page and defaults to the theme mod setting.
 *
 * @return string
 */
function elm_get_page_width()
{
    $w = get_field('page_width');
    if (!$w) {
        $w = get_theme_mod('page_width_setting', 'width-normal');
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