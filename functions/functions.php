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
    $post_id = $post instanceof WP_Post ? $post->ID : null;  // Get the ID of the current page/post
    if ($post_id) {
        $w = get_field('page_width', $post_id);
    }
    if ($force_default || !$w) {
        $w = get_theme_mod('page_width_setting', 'width-normal');
    }

    return $w;  // Return the corresponding Tailwind class or an empty string
}

function add_elm_notice_from_acf($post_id = false, $field_name_prefix = '')
{
    // Adding the prefix if there is one
    $field_name_prefix = $field_name_prefix ? $field_name_prefix . '_' : '';
    // Get the settings from ACF
    $notice_type = get_field($field_name_prefix . 'notice_type', $post_id);
    //dd(get_field($field_name_prefix . 'notice_type'));
    $notice_variant = get_field($field_name_prefix . 'notice_variant', $post_id);
    $submission_text = get_field($field_name_prefix . 'submission_text', $post_id);
    $target = get_field($field_name_prefix . 'target', $post_id);

    // Check if required fields are filled
    if (!$notice_type || !$notice_variant || !$submission_text) {
        return;
    }

    // Create settings array
    $settings = [];

    // Add target if variant is inline
    if ($notice_variant === 'inline' && $target) {
        $settings['target'] = $target;
    }
    dd($submission_text);
    // Add the notice
    Elm_Notice::add($submission_text, $notice_type, $notice_variant, $settings);
}
