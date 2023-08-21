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

// Function to display the main menu
function get_main_menu()
{
    wp_nav_menu([
        'theme_location' => 'main-menu',
        'walker' => new Elm_Mega_Menu_Walker_Nav_Menu(),
        'container' => false,
        'items_wrap' => '%3$s',
    ]);
}

$is_absolute = get_theme_mod('header_absolute_position', false);
$is_sticky = get_theme_mod('header_sticky', false);

$header_class = 'w-full';
$header_class .= $is_absolute && $is_sticky ? ' fixed top-0 z-50' : ($is_absolute ? ' absolute' : ($is_sticky ? ' sticky top-0 z-50' : ''));

$header_margin_to_content = (float) get_theme_mod('content_spacing_setting', '0');
$header_margin_to_content = 'margin-bottom: ' . $header_margin_to_content . 'rem;';

$settings = [
    'header_link_color' => ['attr' => 'text', 'fallback' => 'text-gray-600'],
    'header_link_color_hover' => ['attr' => 'text', 'prefix' => 'hover', 'fallback' => 'text-gray-900'],
    'header_bg_color' => ['attr' => 'bg', 'fallback' => 'transparent'],
];
//dd(get_theme_mod('header_bg_color', 'transparent'));

$header_attrs = elm_get_classes_and_styles_from_theme_settings($settings, '', '', '', $header_class, $header_margin_to_content);
$mobile_attrs = elm_get_classes_and_styles_from_theme_settings('header_bg_color', 'bg', '', 'transparent', 'fixed inset-y-0 right-0 z-10 w-full overflow-y-auto px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10');

$border = get_theme_mod('header_border', false);
$border_color = get_theme_mod('header_border_color', 'transparent');
$container_attrs = 'w-full relative';
if ($border) {
    $container_attrs .= ' border-b-2';
}
$container_attrs = elm_get_classes_and_styles_from_theme_settings('header_border_color', 'border', '', '', $container_attrs);
?>

<body <?php body_class('font-primary'); ?>>
    <?php wp_body_open(); ?>
    <header role="banner" <?php echo $header_attrs ?>>
        <div <?php echo $container_attrs ?>>
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
            <div <?php echo $mobile_attrs ?>>
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