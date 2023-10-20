<?php

/**
 * Show the product rating
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

global $product;

if (!wc_review_ratings_enabled()) {
	return;
}

$rating_count = (int)$product->get_rating_count();
$average_rating = (float)$product->get_average_rating();

if ($rating_count <= 0) {
	return;
}
?>

<div class="border-l border-gray-300 self-stretch w-1"></div>
<div class="flex items-center">
	<?php for ($i = 1; $i <= 5; $i++) : ?>
		<?php
		$isFullStar = $i <= intval($average_rating);
		$isHalfStar = !$isFullStar && ($i - 0.5 <= $average_rating);
		$starClass = $isFullStar ? 'text-yellow-400' : ($isHalfStar ? 'text-yellow-400' : 'text-gray-300');
		?>

		<svg class="h-5 w-5 flex-shrink-0 <?php echo $starClass; ?>" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
			<path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
		</svg>
	<?php endfor; ?>

	<p class="sr-only">
		<?php echo esc_html($average_rating); ?>
		<?php _e('out of 5 stars', 'elmgren'); ?>
	</p>
	<p class="ml-2 text-sm text-gray-500">
		<?php echo esc_html($rating_count); ?>
		<?php _e('reviews', 'elmgren'); ?>
	</p>
</div>