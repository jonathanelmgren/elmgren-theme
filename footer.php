</main>

<footer class="mx-auto max-w-7xl overflow-hidden px-6 pt-20 sm:pt-24 pb-4 sm:pb-4 lg:px-8">

    <?php if (has_nav_menu('footer-menu')) : ?>
        <nav class="-mb-6 columns-2 sm:flex sm:justify-center sm:gap-12" aria-label="Footer">
            <?php wp_nav_menu([
                'theme_location' => 'footer-menu',
                'walker' => new Elmgren_Walker_Footer_Menu(),
                'container' => false,
                'items_wrap' => '%3$s',
            ]); ?>
        </nav>
    <?php endif; ?>

    <?php if (elmgren_has_socials()) : ?>
        <div class="mt-10 flex justify-center gap-10 flex-wrap">
            <?php
            foreach (['facebook', 'instagram', 'twitter', 'github', 'youtube'] as $social) :
                if (elmgren_has_socials($social)) : ?>
                    <a href="<?= elmgren_the_footer_setting($social); ?>" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only"><?= ucfirst($social) ?></span>
                        <?php get_inline_svg($social) ?>
                    </a>
            <?php endif;
            endforeach; ?>
        </div>
    <?php endif; ?>

    <p class="mt-5 text-center text-xs leading-5 text-gray-500">&copy; <?= date("Y") ?> <?= get_bloginfo('name'); ?></p>
</footer>

<?php wp_footer(); ?>

</body>

</html>