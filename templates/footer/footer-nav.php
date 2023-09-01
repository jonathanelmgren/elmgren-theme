<?php if (has_nav_menu('footer-menu')) : ?>
    <nav class="-mb-6 columns-2 sm:flex sm:justify-center sm:gap-12" aria-label="Footer">
        <?php wp_nav_menu([
            'theme_location' => 'footer-menu',
            'walker' => new Elm_Footer_Walker_Nav_Menu(),
            'container' => false,
            'items_wrap' => '%3$s',
        ]); ?>
    </nav>
<?php endif; ?>