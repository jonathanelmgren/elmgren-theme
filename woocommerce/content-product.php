<?php global $product; ?>
<a href="<?php echo esc_url(get_permalink()); ?>" class="group no-underline text-gray">
    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden xl:aspect-h-8 xl:aspect-w-7">
        <?php echo woocommerce_get_product_thumbnail(); ?>
    </div>
    <h3 class="mt-4 text-lg"><?php the_title(); ?></h3>
    <p class="mt-1 text-xs"><?php echo $product->get_price_html(); ?></p>
</a>