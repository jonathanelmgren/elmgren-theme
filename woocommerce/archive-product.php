<?php
get_header();
?>

<div>
  <h2 class="sr-only">Products</h2>

  <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
    <?php
    if (have_posts()) :
      while (have_posts()) : the_post();
        global $product;
    ?>
        <a href="<?php echo esc_url(get_the_permalink()); ?>" class="group no-underline text-gray">
          <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden xl:aspect-h-8 xl:aspect-w-7">
            <?php echo woocommerce_get_product_thumbnail(); // Product Image 
            ?>
          </div>
          <h3 class="mt-4 text-lg"><?php the_title(); ?></h3>
          <p class="mt-1 text-xs"><?php echo $product->get_price_html(); ?></p>
        </a>
    <?php
      endwhile;
    endif;
    ?>
  </div>
</div>

<?php
get_footer();
