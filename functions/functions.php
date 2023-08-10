<?php

function get_custom_logo_url()
{
    $custom_logo_id = get_theme_mod('custom_logo');
    $image = wp_get_attachment_image_src($custom_logo_id, 'full');
    return $image[0];
}

function get_inline_svg($filename)
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
