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

$footer_colors = new TailwindColor([
    'footer_bg_color' => ['attr' => 'bg', 'fallback' => 'bg-primary-200'],
    'footer_text_color' => ['attr' => 'text', 'fallback' => 'text-gray-600'],
]);
$footer_icon_colors = new TailwindColor([
    'footer_icon_color' => ['attr' => 'text', 'fallback' => 'text-gray-600'],
    'footer_icon_color_hover' => ['attr' => 'text', 'prefix' => 'hover', 'fallback' => 'text-gray-900'],
]);
?>

<footer class="overflow-hidden pt-20 sm:pt-24 pb-4 sm:pb-4 <?php $footer_colors->the_class('footer_bg_color') ?>" style="<?php $footer_colors->the_style('footer_bg_color') ?>">
    <div class="<?php echo elm_get_page_width(true) ?>">
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
            <div class="mt-10 flex justify-center gap-10 flex-wrap">
                <?php
                foreach (['facebook', 'instagram', 'twitter', 'github', 'youtube'] as $social) :
                    if (elm_has_socials($social)) : ?>
                        <a href="<?php echo elm_get_footer_setting($social . '_link'); ?>" class="<?php $footer_icon_colors->the_classes() ?>" style="<?php $footer_icon_colors->the_styles() ?>">
                            <span class="sr-only"><?= ucfirst($social) ?></span>
                            <?php elm_the_inline_svg($social) ?>
                        </a>
                <?php endif;
                endforeach; ?>
            </div>
        <?php endif; ?>

        <p class="mt-5 text-center text-xs leading-5 <?php $footer_colors->the_class('footer_text_color') ?>" style="<?php $footer_colors->the_style('footer_text_color') ?>">&copy; <?= date("Y") ?> <?= get_theme_mod('footer_text', 'Elmgren Theme'); ?></p>
    </div>
</footer>

<?php wp_footer(); ?>

</body>

</html>