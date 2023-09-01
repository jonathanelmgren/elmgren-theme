</main>
<?php
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
        <?php get_template_part('templates/footer/footer-nav'); ?>
        <?php get_template_part('templates/footer/footer-socials', null, ['footer_icon_colors' => $footer_icon_colors]); ?>
        <?php get_template_part('templates/footer/footer-copyright', null, ['footer_colors' => $footer_colors]); ?>
    </div>
</footer>
<?php wp_footer(); ?>
</body>

</html>