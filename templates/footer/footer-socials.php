<?php

if (isset($args['elm_footer_icon_colors'])) {
    $elm_footer_icon_colors = $args['elm_footer_icon_colors'];
}

?>

<?php if (elm_has_socials()) : ?>
    <div class="flex justify-center gap-10 flex-wrap">
        <?php
        foreach (['facebook', 'instagram', 'twitter', 'github', 'youtube'] as $social) :
            if (elm_has_socials($social)) : ?>
                <a href="<?php echo elm_get_footer_setting($social . '_link'); ?>" class="<?php $elm_footer_icon_colors->the_classes() ?>" style="<?php $elm_footer_icon_colors->the_styles() ?>">
                    <span class="sr-only"><?= ucfirst($social) ?></span>
                    <?php elm_the_inline_svg($social) ?>
                </a>
        <?php endif;
        endforeach; ?>
    </div>
<?php endif; ?>