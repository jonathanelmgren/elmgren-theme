<?php

if (isset($args['footer_colors'])) {
    $footer_colors = $args['footer_colors'];
}

?>

<p class="mt-5 text-center text-xs leading-5 <?php $footer_colors->the_class('footer_text_color') ?>" style="<?php $footer_colors->the_style('footer_text_color') ?>">&copy; <?= date("Y") ?> <?= get_theme_mod('footer_text', 'Elmgren Theme'); ?></p>