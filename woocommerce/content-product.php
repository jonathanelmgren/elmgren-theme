<?php global $product; ?>
<a href="<?php echo esc_url(get_permalink()); ?>" class="group no-underline text-gray">
    <div class="elm-product-image">
        <?php echo woocommerce_get_product_thumbnail(); ?>
    </div>
    <h3 class="elm-product-title mt-4 text-lg"><?php the_title(); ?></h3>
    <p class="elm-product-price mt-1 text-xs"><?php echo $product->get_price_html(); ?></p>
</a>