<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width" />
    <?php wp_head(); ?>
    <?php get_template_part('templates/header/meta'); ?>
</head>

<?php
$is_absolute = get_theme_mod('header_absolute_position', false);
$is_sticky = get_theme_mod('header_sticky', false);
$border = get_theme_mod('header_border', false);
$header_margin_to_content = (float) get_theme_mod('content_spacing_setting', '0');

$header_colors = new TailwindColor([
    'header_bg_color' => ['attr' => 'bg', 'fallback' => 'transparent'],
]);

$border_colors = new TailwindColor([
    'header_border_color' => ['attr' => 'border', 'fallback' => 'transparent', 'active' => $border, 'extra_attrs' => 'border-b-2'],
]);

$sticky_absolute_class = $is_absolute && $is_sticky ? ' fixed top-0 z-50 ' : ($is_absolute ? ' absolute ' : ($is_sticky ? ' sticky top-0 z-50 ' : ''));
?>

<body <?php body_class('font-primary'); ?>>
    <?php wp_body_open(); ?>
    <header role="banner" style="<?php $header_colors->the_styles('margin-bottom: ' . $header_margin_to_content . 'rem;') ?>" class="<?php $header_colors->the_classes('w-full' . $sticky_absolute_class) ?>">
        <?php get_template_part('templates/header/navigation-main', null, ['border_colors' => $border_colors,]); ?>
        <?php get_template_part('templates/header/navigation-mobile', null, ['header_colors' => $header_colors]); ?>
    </header>
    <main id="content" role="main" class='<?= elm_the_page_width() ?>'>