<?php
if (isset($args['header_colors'])) {
    $header_colors = $args['header_colors'];
}

?><div class="lg:hidden hidden" role="dialog" aria-modal="true" data-menu="mobile">
    <div data-backdrop class="fixed inset-0 z-10"></div>
    <div class="<?php $header_colors->the_classes('fixed inset-y-0 right-0 z-50 w-full overflow-y-auto py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-400/10 ') ?>" style="<?php $header_colors->the_styles() ?>">
        <div class="<?php elm_the_page_width(true) ?>">
            <div class="flex items-center justify-between">
                <?= get_logo_or_blog_name(); ?>
                <button data-menu-toggle="close" type="button" class="no-style rounded-md">
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
</div>