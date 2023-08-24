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

    return file_get_contents($fullPath);
}
function elm_the_inline_svg($filename)
{
    echo elm_get_inline_svg($filename);
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
 * Echoes the width for the current page and defaults to the theme mod setting.
 *
 * @return null
 */
function elm_the_page_width($force_default = false)
{
    echo elm_get_page_width($force_default);
}

function elm_get_page_width($force_default = false)
{
    global $post;  // Access the global $post object
    $post_id = $post->ID;  // Get the ID of the current page/post
    $w = get_field('page_width', $post_id);
    if ($force_default || !$w) {
        $w = get_theme_mod('page_width_setting', 'width-normal');
    }

    return $w;  // Return the corresponding Tailwind class or an empty string
}
