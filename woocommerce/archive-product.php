<?php
get_header();
?>

<h1 class="sr-only">Products</h1>

<?php
do_action('woocommerce_before_main_content');
?>

<div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
  <?php

  if (have_posts()) :
    while (have_posts()) : the_post();
      do_action('woocommerce_shop_loop');

      wc_get_template_part('content', 'product');
    endwhile;
  endif;

  do_action('woocommerce_after_shop_loop');
  ?>
</div>

<?php
do_action('woocommerce_after_main_content');
get_footer();
?>