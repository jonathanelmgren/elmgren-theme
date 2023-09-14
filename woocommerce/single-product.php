<?php
get_header();
?>


<?php
woocommerce_breadcrumb();
?>
<div class="flex flex-col-reverse gap-y-5 lg:grid lg:grid-cols-2 lg:gap-x-8">
    <div class="flex flex-col gap-4">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl"><?php the_title() ?></h1>

        <section aria-labelledby="information-heading">
            <h2 id="information-heading" class="sr-only"><?php _e('Product information', 'elmgren') ?></h2>

            <div class="flex items-center gap-4">
                <?php wc_get_template('single-product/price.php') ?>
                <?php wc_get_template('single-product/rating.php') ?>
            </div>

            <div class="mt-4">
                <?php the_content(); ?>
            </div>
        </section>
        <?php wc_get_template('single-product/add-to-cart/add-to-cart.php') ?>
    </div>
    <?php wc_get_template('single-product/product-image.php') ?>
</div>

<?php
get_footer();
