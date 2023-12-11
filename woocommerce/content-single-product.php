<div class="flex flex-col gap-4" id="product-<?php the_ID(); ?>">
    <div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:gap-4">
            <h1><?php the_title(); ?></h1>
            <?php wc_get_template('single-product/rating.php'); ?>
        </div>
    </div>

    <?php do_action('designique_single_product_before_content'); ?>
    
    <section aria-labelledby="information-heading">
        <h2 id="information-heading" class="sr-only"><?php esc_html_e('Product information', 'elmgren'); ?></h2>
        <?php the_content(); ?>
    </section>

    <?php do_action('designique_single_product_after_content'); ?>

    <?php wc_get_template('single-product/add-to-cart/add-to-cart.php'); ?>
</div>

<?php wc_get_template('single-product/product-image.php'); ?>