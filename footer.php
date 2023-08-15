</main>
<?php

function elm_get_footer_setting(string $setting): mixed
{
    // Fetch setting from Theme Customizer
    $value = get_theme_mod('footer_' . $setting);
    if (!empty($value)) {
        return $value;
    }
    return null;
}

function elm_has_socials(?string $social = null): bool
{
    $socials = array('facebook_link', 'instagram_link', 'youtube_link', 'github_link', 'twitter_link');

    // If a specific social is provided
    if ($social) {
        return (bool) elm_get_footer_setting($social . '_link');
    }

    // Check if any social link is set
    foreach ($socials as $social_link) {
        if (elm_get_footer_setting($social_link)) {
            return true;
        }
    }
    return false;
}

?>

<footer class="mx-auto max-w-7xl overflow-hidden px-6 pt-20 sm:pt-24 pb-4 sm:pb-4 lg:px-8">
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

    <?php if (elm_has_socials()) : ?>
        <?php
        $attrs = elm_get_classes_and_styles(
            [
                'footer_icon_color' => ['attr' => 'text', 'fallback' => 'text-gray-600'],
                'footer_icon_color_hover' => ['attr' => 'text', 'prefix' => 'hover', 'fallback' => 'text-gray-900'],
            ]
        );
        ?>
        <div class="mt-10 flex justify-center gap-10 flex-wrap">
            <?php
            foreach (['facebook', 'instagram', 'twitter', 'github', 'youtube'] as $social) :
                if (elm_has_socials($social)) : ?>
                    <a href="<?php echo elm_get_footer_setting($social . '_link'); ?>" <?php echo $attrs ?>>
                        <span class="sr-only"><?= ucfirst($social) ?></span>
                        <?php elm_get_inline_svg($social) ?>
                    </a>
            <?php endif;
            endforeach; ?>
        </div>
    <?php endif; ?>

    <p <?php echo elm_get_classes_and_styles('footer_text_color', 'text', '', 'text-gray-500', 'mt-5 text-center text-xs leading-5') ?>>&copy; <?= date("Y") ?> <?= get_theme_mod('footer_text', 'Elmgren Theme'); ?></p>
</footer>

<?php wp_footer(); ?>

</body>

</html>