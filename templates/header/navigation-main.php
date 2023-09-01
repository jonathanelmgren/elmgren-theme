<?php
if (isset($args['border_colors'])) {
    $border_colors = $args['border_colors'];
}

?>

<div class="<?php $border_colors->the_classes('w-full relative') ?>" style="<?php $border_colors->the_styles() ?>">
    <nav class="z-50 flex <?php elm_the_page_width(true) ?> items-center justify-between py-6" aria-label="Global">
        <?php get_template_part('templates/header/logo'); ?>

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