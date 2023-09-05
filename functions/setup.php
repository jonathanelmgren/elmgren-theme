<?php

// Register theme supports
function elm_setup()
{
    add_theme_support('custom-logo');
    add_theme_support('woocommerce');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_post_type_support('page', 'excerpt');

    register_nav_menus(array(
        'main-menu' => esc_html__('Main Menu', 'elmgren'),
        'footer-menu' => esc_html__('Footer Menu', 'elmgren'),
    ));
}
add_action('after_setup_theme', 'elm_setup');

// Register public styles and scripts
function elm_enqueue_styles_and_scripts()
{
    $dist_path = get_template_directory_uri() . '/dist/';
    $css_path = $dist_path . 'css/';
    $js_path = $dist_path . 'js/';

    // Scripts
    wp_enqueue_script('jquery');
    wp_enqueue_script('elm-main-js', $js_path . 'main.js', ['jquery'], false, true);

    if (is_product()) {
        global $product;
        if (is_string($product)) {
            $product = wc_get_product(get_the_ID());
        }
        if ($product instanceof WC_Product && $product->is_type('variable')) {
            wp_enqueue_script('elm-single-product-variable-js', $js_path . 'single-product-variable.js', ['jquery'], false, true);
        }
        wp_enqueue_script('elm-add-to-cart-ajax-js', $js_path . 'add-to-cart-ajax.js', ['jquery'], false, true);
    }

    // Styles
    wp_enqueue_style('elm-main-css', $css_path . 'main.css');
}
add_action('wp_enqueue_scripts', 'elm_enqueue_styles_and_scripts');

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
function elm_register_acf_blocks()
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
add_action('init', 'elm_register_acf_blocks');

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

// Disable woocommerce styles
add_filter('woocommerce_enqueue_styles', '__return_empty_array');
