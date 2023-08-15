<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width" />
    <?php wp_head(); ?>
</head>

<?php
// Function to display either the logo or the blog name
function get_logo_or_blog_name($link_class = '-m-1.5 p-1.5', $img_class = 'w-auto')
{
    $home_url = home_url();
    $blog_name = get_bloginfo('name');
    $logo_url = esc_url(wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full'));
    if (has_custom_logo()) {
        return '<a href="' . $home_url . '" class="' . $link_class . '">
                    <span class="sr-only">' . $blog_name . '</span>
                    <img style="height: ' . elm_get_logo_height() . 'rem" class="' . $img_class . '" src="' . $logo_url . '" alt="logo of ' . esc_attr($blog_name) . '">
                </a>';
    } else {
        return '<a href="' . $home_url . '" class="' . $link_class . '">' . $blog_name . '</a>';
    }
}

// Function to display the main menu
function get_main_menu()
{
    wp_nav_menu([
        'theme_location' => 'main-menu',
        'walker' => new Elm_Header_Walker_Nav_Menu(),
        'container' => false,
        'items_wrap' => '%3$s',
    ]);
}

$is_absolute = get_theme_mod('header_absolute_position', false);
$is_sticky = get_theme_mod('header_sticky', false);

$header_class = 'w-full';
$header_class .= $is_absolute && $is_sticky ? ' fixed top-0 z-50' : ($is_absolute ? ' absolute' : ($is_sticky ? ' sticky top-0 z-50' : ''));

$header_attrs = elm_get_classes_and_styles('header_bg_color', 'bg', '', 'transparent', $header_class);

?>

<body <?php body_class('font-primary'); ?>>
    <?php wp_body_open(); ?>
    <header role="banner" <?php echo $header_attrs ?>>
        <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
                <?= get_logo_or_blog_name(); ?>
            </div>
            <div class="flex lg:hidden">
                <button type="button" data-menu-toggle="open" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
                    <span class="sr-only"><?php _e('Open main menu', 'elmgren') ?></span>
                    <?php echo elm_get_inline_svg('hamburger_open') ?>
                </button>
            </div>
            <div class="hidden lg:flex lg:gap-x-12">
                <?php get_main_menu(); ?>
            </div>
        </nav>
        <!-- Mobile menu -->
        <div class="lg:hidden hidden" role="dialog" aria-modal="true" data-menu="mobile">
            <div data-backdrop class="fixed inset-0 z-10"></div>
            <div class="fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                <div class="flex items-center justify-between">
                    <?= get_logo_or_blog_name(); ?>
                    <button data-menu-toggle="close" type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                        <span class="sr-only"><?php _e('Close menu', 'elmgren') ?></span>
                        <?php elm_get_inline_svg('hamburger_close') ?>
                    </button>
                </div>
                <div class="mt-6 flow-root">
                    <div class="-my-6 divide-y divide-gray-500/10">
                        <div class="gap-2 py-6">
                            <?php get_main_menu(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main id="content" role="main" class='<?= elm_get_page_width() ?>'>