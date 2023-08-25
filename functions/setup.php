<?php

// Register theme supports
function elm_setup()
{

    $palette = [];

    foreach (TAILWIND_COLORS as $colorName => $shades) {
        foreach ($shades as $shade => $value) {
            // Prepare a human-readable name
            $humanReadableShade = strtoupper($shade) === 'DEFAULT' ? 'Default' : $shade;
            $humanReadableName = ucfirst($colorName) . ' ' . $humanReadableShade;

            // Add to the palette array
            $palette[] = [
                'name'  => __($humanReadableName, 'elmgren'),
                'slug'  => $colorName . '-' . $shade,
                'color' => 'var(--color-' . $colorName . '-' . $shade . ')'
            ];
        }
    }

    add_theme_support('custom-logo');
    add_theme_support('woocommerce', array(
        'thumbnail_image_width' => 200,
        'gallery_thumbnail_image_width' => 100,
        'single_image_width' => 500,
    ));
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('editor-color-palette', $palette);

    register_nav_menus(array(
        'main-menu' => esc_html__('Main Menu', 'elmgren'),
        'footer-menu' => esc_html__('Footer Menu', 'elmgren'),
    ));
}
add_action('after_setup_theme', 'elm_setup');

function generate_color_palette_styles() {
    $palette = get_theme_support('editor-color-palette')[0];
    
    if (!$palette) return;

    echo '<style type="text/css" id="dynamic-color-palette-styles">';
    foreach ($palette as $color) {
        $slug = strtolower($color['slug']);
        echo ".has-{$slug}-color { color: {$color['color']}; }";
        echo ".has-{$slug}-background-color { background-color: {$color['color']}; }";
    }
    echo '</style>';
}

add_action('wp_head', 'generate_color_palette_styles');

// Register styles and scripts
function elm_enqueue_styles_and_scripts()
{
    $dist_path = get_template_directory() . '/dist/';

    // Enqueue styles.
    foreach (glob($dist_path . 'css/*.css') as $file) {
        $handle = 'elm-' . basename($file, '.css');
        $file_url = get_template_directory_uri() . '/dist/css/' . basename($file);
        wp_enqueue_style($handle, $file_url);
    }

    // Enqueue scripts.
    foreach (glob($dist_path . 'js/*.js') as $file) {
        $handle = 'elm-' . basename($file, '.js');
        $file_url = get_template_directory_uri() . '/dist/js/' . basename($file);
        wp_enqueue_script($handle, $file_url, array('jquery'), null, true);
    }

    wp_localize_script('elm-main', 'themeSettings', array(
        'colors' => defined('TAILWIND_COLORS') ? TAILWIND_COLORS : [],
    ));
}
add_action('wp_enqueue_scripts', 'elm_enqueue_styles_and_scripts');
add_action('enqueue_block_editor_assets', 'elm_enqueue_styles_and_scripts');

// Create generic function to include all files in specific folders

if (!function_exists('elm_include_folder')) {
    function elm_include_folder($folder)
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
            if (\str_ends_with($file, '.php') && !\str_starts_with($file, '_')) {
                require_once $folder . $file;
            }
        }

        // Clear folders out to only get folders
        $content = scandir($folder, 1);
        $content = array_filter($content, function ($item) use ($folder) {
            return is_dir($folder . $item) && !in_array($item, ['.', '..']);
        });

        foreach ($content as $subfolder) {
            elm_include_folder(trim(str_replace(get_template_directory(), '', $folder), '/') . '/' . $subfolder);
        }
    }
}

// Register blocks
function register_acf_blocks()
{
    $blocks = array_diff(scandir(get_template_directory() . '/blocks/', 1), array('..', '.'));

    foreach ($blocks as $block) {
        $dir = get_template_directory() . '/blocks/' . $block;
        $file = $dir . '/settings.php';
        if (file_exists($file)) {
            require_once $file;
        }
        register_block_type($dir);
    }
}
add_action('init', 'register_acf_blocks');

// Use mailhog if in docker container
function elm_use_mailhog(PHPMailer\PHPMailer\PHPMailer $phpmailer)
{
    $phpmailer->Host = 'mailhog';
    $phpmailer->Port = 1025;
    $phpmailer->IsSMTP();
}
if (is_file("/.dockerenv")) {
    add_action('phpmailer_init', 'elm_use_mailhog');
}
