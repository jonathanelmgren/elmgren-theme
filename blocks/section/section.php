<?php
$is_fullwidth = get_field('full_width');
$background_image = get_field('background_image');
$background_color = get_field('background_color');
$background_image_opacity = get_field('background_image_opacity');

$background_color = new TailwindColor([
    'background_color' => ['attr' => 'bg']
]);

if ($is_fullwidth) {
    $width = elm_get_page_width();
}

// Generate style attribute based on ACF fields
$pseudo_element_styles = '';
if ($background_image) {
    $pseudo_element_styles .= "content: ''; position: absolute; top: 0; right: 0; bottom: 0; left: 0; background-image: url('{$background_image}'); opacity: {$background_image_opacity}; z-index: 0;";
}

?>
<section class="<?php $background_color->the_classes('relative ' . ($is_fullwidth ? ' full-' . $width : '')) ?>" style="<?php $background_color->the_styles() ?>">
    <?php if ($background_image) : ?>
        <div class="absolute inset-0" style="<?php echo $pseudo_element_styles; ?>"></div>
    <?php endif; ?>
    <div class='<?php echo $width ?> z-10 relative'>
        <InnerBlocks />
    </div>
</section>