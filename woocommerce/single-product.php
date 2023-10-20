<?php
get_header();
woocommerce_breadcrumb();
?>

<div class="flex flex-col-reverse gap-y-5 lg:grid lg:grid-cols-2 lg:gap-x-8">
    <?php
    while (have_posts()) : the_post();
        do_action('woocommerce_before_single_product');
        wc_get_template_part('content', 'single-product');
        do_action('woocommerce_after_single_product');
    endwhile;
    ?>
</div>

<?php
get_footer();
?>
