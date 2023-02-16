<?php

// Include the ACF plugin.
include_once(ELMGREN_ACF_PATH . 'acf.php');

// Customize the url setting to fix incorrect asset URLs.
add_filter('acf/settings/url', 'elmgren_acf_settings_url');
function elmgren_acf_settings_url($url)
{
    return ELMGREN_ACF_URL;
}

// Show custom fields menu only if me
function elmgren_show_acf_settings()
{
    $user = wp_get_current_user();
    if ($user->get('user_email') === 'jonathan@elmgren.dev') {
        return true;
    }
    return false;
}
add_filter('acf/settings/show_admin', 'elmgren_show_acf_settings');

// Hide the ACF Updates menu
add_filter('acf/settings/show_updates', '__return_false', 100);

// Load json to child theme
function elmgren_load_acf_json_from_child()
{
    return get_stylesheet_directory() . '/acf-json';
}
add_filter('acf/settings/save_json', 'elmgren_load_acf_json_from_child');

// Save json to child theme
function elmgren_save_acf_json_to_child($paths)
{
    $paths = array(get_template_directory() . '/acf-json');

    if (is_child_theme()) {
        $paths[] = get_stylesheet_directory() . '/acf-json';
    }

    return $paths;
}
add_filter('acf/settings/load_json', 'elmgren_save_acf_json_to_child');
