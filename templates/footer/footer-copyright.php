<?php

if (isset($args['footer_colors'])) {
    $footer_colors = $args['footer_colors'];
}

?>

<p class="text-center text-xs leading-5 <?php $footer_colors->the_class('elm_elm_footer_text_color') ?>" style="<?php $footer_colors->the_style('elm_elm_footer_text_color') ?>">&copy; <?= date("Y") ?> <?= get_theme_mod('elm_footer_text', 'Elmgren Theme'); ?></p>