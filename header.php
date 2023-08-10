<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width" />
    <meta name="description" content="">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <header style="<?php echo elmgren_get_header_absolute() ?>" class="bg-white" role="banner">
        <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="<?php echo home_url(); ?>" class="-m-1.5 p-1.5">
                    <?php if (has_custom_logo()) : ?>
                        <span class="sr-only"><?php echo get_bloginfo('name'); ?></span>
                        <img style="height: <?php echo get_logo_height() ?>rem" class="w-auto" src="<?php echo esc_url(wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full')); ?>" alt="logo of <?php echo esc_attr(get_bloginfo('name')); ?>">
                    <?php else : ?>
                        <?php echo get_bloginfo('name'); ?>
                    <?php endif; ?>
                </a>
            </div>
            <div class="flex lg:hidden">
                <button type="button" data-menu-toggle="open" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
                    <span class="sr-only"><?php _e('Open main menu', 'elmgren') ?></span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
            <div class="hidden lg:flex lg:gap-x-12">
                <?php wp_nav_menu([
                    'theme_location' => 'main-menu',
                    'walker' => new Elmgren_Walker_Nav_Menu(),
                    'container' => false,
                    'items_wrap' => '%3$s',
                ]); ?>
            </div>
        </nav>
        <!-- Mobile menu, show/hide based on menu open state. -->
        <div class="lg:hidden hidden" role="dialog" aria-modal="true" data-menu="mobile">
            <!-- Background backdrop, show/hide based on slide-over state. -->
            <div data-backdrop class="fixed inset-0 z-10"></div>
            <div class="fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                <div class="flex items-center justify-between">
                    <a href="<?php echo home_url(); ?>" class="-m-1.5 p-1.5">
                        <?php if (has_custom_logo()) : ?>
                            <span class="sr-only"><?php echo get_bloginfo('name'); ?></span>
                            <img style="height: <?php echo get_logo_height() ?>rem" class="w-auto" src="<?php echo esc_url(wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full')); ?>" alt="logo of <?php echo esc_attr(get_bloginfo('name')); ?>">
                        <?php else : ?>
                            <?php echo get_bloginfo('name'); ?>
                        <?php endif; ?>
                    </a>
                    <button data-menu-toggle="close" type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                        <span class="sr-only"><?php _e('Close menu', 'elmgren') ?></span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mt-6 flow-root">
                    <div class="-my-6 divide-y divide-gray-500/10">
                        <div class="space-y-2 py-6">
                            <?php wp_nav_menu([
                                'theme_location' => 'main-menu',
                                'walker' => new Elmgren_Walker_Nav_Menu(),
                                'container' => false,
                                'items_wrap' => '%3$s',
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main id="content" role="main" class='<?php elmgren_get_page_width() ?>'>