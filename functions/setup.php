<?php

// Create generic function to include all files in specific folders
function elmgren_include_folder($folder)
{
    // Make sure we have / before and after folder
    $folder = \str_starts_with($folder, '/') ? $folder : '/' . $folder;
    $folder = \str_ends_with($folder, '/') ? $folder : $folder . '/';

    // Get complete folder path
    $folder = get_template_directory() . $folder;

    // Return empty array if not found
    if (!is_dir($folder)) {
        return [];
    }
    $content = scandir($folder, 1);
    if (!$content || !\is_array($content)) {
        return [];
    }

    // Clear folders out to only get files
    $content = array_filter($content, function ($item) use ($folder) {
        return !is_dir($folder . $item);
    });

    foreach ($content as $file) {
        if (\str_ends_with($file, '.php')) {
            require_once $folder . $file;
        }
    }
}

// Register theme supports
function elmgren_setup()
{
    add_theme_support('custom-logo');
    add_theme_support('woocommerce', array(
        'thumbnail_image_width' => 200,
        'gallery_thumbnail_image_width' => 100,
        'single_image_width' => 500,
    ));
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('editor-color-palette',[
        [
            'name' => __('Primary', 'elmgren'),
            'slug' => 'primary',
            'color' => 'var(--color-brand--primary)'
        ],
        [
            'name' => __('Secondary', 'elmgren'),
            'slug' => 'secondary',
            'color' => 'var(--color-brand--secondary)'
        ],
    ]);

    register_nav_menus(array('main-menu' => esc_html__('Main Menu', 'elmgren')));
}
add_action('after_setup_theme', 'elmgren_setup');

// Register styles and scripts
function elmgren_enqueue()
{
    // Should run in header
    wp_enqueue_style('elmgren-style', get_stylesheet_uri());
    wp_enqueue_script('jquery');
    wp_enqueue_style('elmgren_styles', get_template_directory_uri() . '/dist/main.css');
    wp_enqueue_script('elmgren_scripts', get_template_directory_uri() . '/dist/main.js');

    // Should run in footer
    wp_enqueue_script('elmgren_plugins', get_template_directory_uri() . '/dist/plugins.js', ['jquery'], false, true);

    // Add elmgrenApi Javascript object to get nonce for auth with JS
    wp_localize_script('elmgren_scripts', 'wpApiSettingsTest', [
        'rest' => [
            'nonce'     => wp_create_nonce( 'wp_rest' ),
            'is_admin' => is_admin()
        ],
    ]);
}
add_action('wp_enqueue_scripts', 'elmgren_enqueue');

function elmgren_enqueue_admin()
{
    // Should run in header
    wp_enqueue_style('elmgren-style', get_stylesheet_uri());
    wp_enqueue_style('elmgren_styles_admin', get_template_directory_uri() . '/dist/gutenberg.css');
}
add_action('admin_enqueue_scripts', 'elmgren_enqueue_admin');