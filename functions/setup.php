<?php

// Register theme supports
function elm_setup()
{
    add_theme_support('custom-logo');
    add_theme_support('woocommerce');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_post_type_support('page', 'excerpt');
    //add_theme_support('editor-styles');

    register_nav_menus(array(
        'main-menu' => esc_html__('Main Menu', 'elmgren'),
        'footer-menu' => esc_html__('Footer Menu', 'elmgren'),
    ));
}
add_action('after_setup_theme', 'elm_setup');

// Register public styles and scripts
function elm_enqueue_styles_and_scripts()
{
    // Scripts
    wp_enqueue_script('jquery');
    wp_enqueue_script('elm-main-js', JS_PATH . 'main.js', ['jquery'], false, true);

    if (elm_is_woocommerce_activated() && is_product()) {
        global $product;
        if (is_string($product)) {
            $product = wc_get_product(get_the_ID());
        }
        if ($product instanceof WC_Product && $product->is_type('variable')) {
            wp_enqueue_script('elm-single-product-variable-js', JS_PATH . 'single-product-variable.js', ['jquery'], false, true);
        }
    }

    if (elm_is_woocommerce_activated() && is_cart()) {
        wp_enqueue_script('elm-cart-js', JS_PATH . 'cart.js', ['jquery'], false, true);
    }

    if (elm_is_woocommerce_activated() && is_checkout()) {
        wp_enqueue_script('elm-checkout-js', JS_PATH . 'checkout.js', ['jquery'], false, true);
    }

    if (is_admin()) {
        wp_enqueue_script('elm-gutenberg-js', JS_PATH . 'gutenberg.js', ['jquery'], false, true);
        wp_enqueue_script('elm-gutenberg-react-js', JS_PATH . 'gutenberg-settings.tsx.js', ['wp-blocks', 'wp-dom-ready', 'wp-edit-post'], false, true);
    }

    // Styles
    wp_enqueue_style('elm-main-css', CSS_PATH . 'main.css');
}
add_action('wp_enqueue_scripts', 'elm_enqueue_styles_and_scripts', 10);
add_action('enqueue_block_editor_assets', 'elm_enqueue_styles_and_scripts', 10);

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
function elm_dequeue_woocommerce_block_styles()
{
    if (!class_exists('woocommerce')) {
        return;
    }
    global $wp_styles;

    foreach ($wp_styles->queue as $style_handle) {
        $src = $wp_styles->registered[$style_handle]->src;
        // Here we check if the handle name contains 'build/', which seems to be consistent in your list.
        if (strpos($src, 'woocommerce') !== false) {
            wp_dequeue_style($style_handle);
        }
    }

    wp_dequeue_style('select2');
    wp_deregister_style('select2');

    wp_dequeue_script('selectWoo');
    wp_deregister_script('selectWoo');
}
add_action('wp_enqueue_scripts', 'elm_dequeue_woocommerce_block_styles', 100);

function elm_register_button_block_styles()
{
    register_block_style(
        'core/button',
        array(
            'name'         => 'primary',
            'label'        => __('Primary', 'text-domain'),
            'isDefault'    => true,
        )
    );

    register_block_style(
        'core/button',
        array(
            'name'         => 'secondary',
            'label'        => __('Secondary', 'text-domain'),
        )
    );
}
add_action('init', 'elm_register_button_block_styles');

function elm_add_class_to_list_block($block_content, $block)
{

    if ('core/button' === $block['blockName']) {
        $block_content = new WP_HTML_Tag_Processor($block_content);
        $block_content->next_tag('a');
        $block_content->add_class('btn');
        if (str_contains($block_content, 'is-style-secondary')) {
            $block_content->add_class('secondary');
        } else {
            $block_content->add_class('primary');
        }
        $block_content->get_updated_html();
    }

    return $block_content;
}
add_filter('render_block', 'elm_add_class_to_list_block', 10, 2);

function elm_remove_default_button_styles($args, $name)
{
    if ($name !== 'core/button') {
        return $args;
    }

    if (isset($args['styles'])) {
        $new_styles = array_filter($args['styles'], function ($style) {
            return !in_array($style['name'], array('fill', 'outline'));
        });
        $args['styles'] = array_values($new_styles);
    }

    return $args;
}

add_filter('register_block_type_args', 'elm_remove_default_button_styles', 10, 2);

function elm_deregister_button_block_editor_styles()
{
    wp_deregister_style('wp-block-buttons');
    wp_deregister_style('wp-block-button');
    wp_dequeue_style('global-styles-inline-css');
    wp_deregister_style('global-styles-inline-css');
}
add_filter('should_load_separate_core_block_assets', '__return_true');
add_filter('styles_inline_size_limit', '__return_zero');
add_action('enqueue_block_editor_assets', 'elm_deregister_button_block_editor_styles', 100);
