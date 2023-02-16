<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width" />
    <meta name="description" content="">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <header style="<?php echo elmgren_get_header_absolute() ?>" id="header" role="banner" class='header'>
        <div class='logo'>
            <?php
            if (has_custom_logo()) {
                the_custom_logo();
            } else {
            ?>
                <a href="<?php echo home_url(); ?>"><?php echo get_bloginfo('name'); ?></a>
            <?php
            }
            ?>
        </div>
        <div class='menu-items'>
            <div>
                <div id='mobile-menu-toggler'>
                    <?php get_template_part('assets/images/icons/inline/inline', 'hamburger.svg');  ?>
                </div>
                <div id='overlay'></div>
                <nav id='nav'>
                    <div id='close-mobile-menu'>×</div>
                    <?php wp_nav_menu(['theme_location' => 'main-menu']); ?>
                </nav>
            </div>
            <?php if (elmgren_has_woo()) : ?>
                <a aria-label="Cart" class="menu-cart" href="<?php echo wc_get_cart_url() ?>">
                    <?php get_template_part('assets/images/icons/inline/inline', 'shoppingcart.svg');  ?>
                    <?php $count =  WC()->cart->get_cart_contents_count();
                    if ($count > 0) {
                    ?>
                        <div class="menu-cart--count"><?php echo $count ?></div>
                    <?php
                    }
                    ?>
                </a>
            <?php endif; ?>
        </div>
    </header>