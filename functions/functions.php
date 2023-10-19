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
        $w = get_theme_mod('elm_page_width_setting', 'width-normal');
    }

    return $w;  // Return the corresponding Tailwind class or an empty string
}

// Function to display either the logo or the blog name
function get_logo_or_blog_name($link_class = 'no-underline', $img_class = 'w-auto')
{
    $logo_height = get_theme_mod('logo_height_setting', '8');
    $home_url = home_url();
    $blog_name = get_bloginfo('name');
    $logo_url = esc_url(wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full'));
    if (has_custom_logo()) {
        return '<a href="' . $home_url . '" class="' . $link_class . '">
                    <span class="sr-only">' . $blog_name . '</span>
                    <img style="height: ' . $logo_height . 'rem" class="' . $img_class . '" src="' . $logo_url . '" alt="logo of ' . esc_attr($blog_name) . '">
                </a>';
    } else {
        return '<a href="' . $home_url . '" class="' . $link_class . '">' . $blog_name . '</a>';
    }
}

function elm_get_footer_setting(string $setting): mixed
{
    // Fetch setting from Theme Customizer
    $value = get_theme_mod('elm_footer_' . $setting);
    if (!empty($value)) {
        return $value;
    }
    return null;
}

function elm_has_socials(?string $social = null): bool
{
    $socials = array('facebook_link', 'instagram_link', 'youtube_link', 'github_link', 'twitter_link');

    // If a specific social is provided
    if ($social) {
        return (bool) elm_get_footer_setting($social . '_link');
    }

    // Check if any social link is set
    foreach ($socials as $social_link) {
        if (elm_get_footer_setting($social_link)) {
            return true;
        }
    }
    return false;
}

function elm_is_woocommerce_activated()
{
    return class_exists('WooCommerce') ? true : false;
}
