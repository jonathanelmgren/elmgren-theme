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

$is_absolute = get_theme_mod('header_absolute_position', false);
$is_sticky = get_theme_mod('header_sticky', false);
$border = get_theme_mod('header_border', false);
$header_margin_to_content = (float) get_theme_mod('content_spacing_setting', '0');
$border_color = new TailwindColor('header_border_color');
$header_color = new TailwindColor('header_bg_color');
$header_link_color = new TailwindColor('header_link_color');
$header_link_color_hover = new TailwindColor('header_link_color_hover');


$mobile_header_class = 'fixed inset-y-0 right-0 z-10 w-full overflow-y-auto px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10';
$mobile_header_class .= ' ' . $header_color->get_class('bg');
$mobile_header_class .= ' ' . $header_link_color->get_class('text');
$mobile_header_class .= ' ' . $header_link_color_hover->get_class('text', 'hover');

$mobile_header_styles = '';
$mobile_header_styles .= $header_color->get_style('background-color');
$mobile_header_styles .= $header_link_color->get_style('color');
$mobile_header_styles .= $header_link_color_hover->get_style('color', 'hover');

$header_class = 'w-full';
$header_class .= $is_absolute && $is_sticky ? ' fixed top-0 z-50' : ($is_absolute ? ' absolute' : ($is_sticky ? ' sticky top-0 z-50' : ''));
$header_class .= ' ' . $header_color->get_class('bg');

$header_styles = '';
$header_styles .= $header_color->get_style('background-color');
$header_styles .= 'margin-bottom: ' . $header_margin_to_content . 'rem;';

$container_class = 'w-full relative';
$container_class .= $border ? ' border-b-2 ' . $border_color->get_class('border') : '';

$container_styles = $border ? $border_color->get_style('border-color') : '';
?>

<body <?php body_class('font-primary'); ?>>
    <?php wp_body_open(); ?>
    <header role="banner" style="<?php echo $header_styles ?>" class="<?php echo $header_class ?>">
        <div class="<?php echo $container_class ?>" style="<?php echo $container_styles ?>">
            <nav class="z-50 flex <?php elm_the_page_width(true) ?> items-center justify-between py-6" aria-label="Global">
                <div class="flex lg:flex-1">
                    <?= get_logo_or_blog_name(); ?>
                </div>
                <div class="flex lg:hidden">
                    <button type="button" data-menu-toggle="open" class="btn--no-style inline-flex items-center justify-center rounded-md">
                        <span class="sr-only"><?php _e('Open main menu', 'elmgren') ?></span>
                        <?php echo elm_the_inline_svg('hamburger_open') ?>
                    </button>
                </div>
                <div class="hidden lg:flex lg:gap-x-12">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'main-menu',
                        'walker' => new Elm_Mega_Menu_Walker_Nav_Menu(),
                        'container' => false,
                        'items_wrap' => '%3$s',
                    ]);
                    ?>
                </div>
            </nav>
        </div>
        <!-- Mobile menu -->
        <div class="lg:hidden hidden" role="dialog" aria-modal="true" data-menu="mobile">
            <div data-backdrop class="fixed inset-0 z-10"></div>
            <div class="<?php echo $mobile_header_class ?>" style="<?php echo $mobile_header_styles ?>">
                <div class="flex items-center justify-between">
                    <?= get_logo_or_blog_name(); ?>
                    <button data-menu-toggle="close" type="button" class="btn--no-style rounded-md">
                        <span class="sr-only"><?php _e('Close menu', 'elmgren') ?></span>
                        <?php elm_the_inline_svg('hamburger_close') ?>
                    </button>
                </div>
                <div class="mt-6 flow-root">
                    <div class="-my-6 divide-y divide-gray-500/10">
                        <div class="mt-8 py-6 flex flex-col gap-2">
                            <?php
                            wp_nav_menu([
                                'theme_location' => 'main-menu',
                                'walker' => new Elm_Mobile_Walker_Nav_Menu(),
                                'container' => false,
                                'items_wrap' => '%3$s',
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main id="content" role="main" class='<?= elm_the_page_width() ?>'>