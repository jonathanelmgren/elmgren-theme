<?php

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
    add_theme_support('editor-color-palette', [
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

    register_nav_menus(array(
        'main-menu' => esc_html__('Main Menu', 'elmgren'),
        'footer-menu' => esc_html__('Footer Menu', 'elmgren'),
    ));
}
add_action('after_setup_theme', 'elmgren_setup');

// Register styles and scripts
function elm_enqueue_styles_and_scripts()
{
    $dist_path = get_template_directory() . '/dist/';

    // Enqueue styles.
    foreach (glob($dist_path . 'css/*.css') as $file) {
        $file_url = get_template_directory_uri() . '/dist/css/' . basename($file);
        wp_enqueue_style(basename($file), $file_url);
    }

    // Enqueue scripts.
    foreach (glob($dist_path . 'js/*.js') as $file) {
        $file_url = get_template_directory_uri() . '/dist/js/' . basename($file);
        wp_enqueue_script(basename($file), $file_url, array(), null, true);
    }

    // Enqueue jQuery
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'elm_enqueue_styles_and_scripts');
add_action('enqueue_block_editor_assets', 'elm_enqueue_styles_and_scripts');

// Create generic function to include all files in specific folders
if (!function_exists('elmgren_include_folder')) {
    function elmgren_include_folder($folder)
    {
        // Make sure we have forwardslash before and after folder
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
}
