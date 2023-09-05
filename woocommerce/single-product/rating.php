<?php

/**
 * Show the product rating
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/rating.php.
 */

defined('ABSPATH') || exit;

global $product;

if (!wc_review_ratings_enabled()) {
	return;
}

$rating_count = (int) $product->get_rating_count();
$average      = (float) $product->get_average_rating();
if ($rating_count > 0) : ?>

	<div class="border-l border-gray-300 self-stretch w-1">

	</div>
	<div class="flex items-center">
		<?php for ($i = 1; $i <= 5; $i++) : ?>
			<?php if ($i <= intval($average)) : ?>
				<svg class="text-yellow-400 h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
					<path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
				</svg>
			<?php elseif ($i - 0.5 <= $average) : ?>
				<svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" aria-hidden="true">
					<!-- Clip paths -->
					<defs>
						<clipPath id="leftClip">
							<rect x="0" y="0" width="10" height="20" />
						</clipPath>
						<clipPath id="rightClip">
							<rect x="10" y="0" width="10" height="20" />
						</clipPath>
					</defs>

					<!-- Left half in yellow -->
					<path clip-path="url(#leftClip)" class='text-yellow-400' fill="currentColor" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" />

					<!-- Right half in gray -->
					<path clip-path="url(#rightClip)" class='text-gray-300' fill="currentColor" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" />
				</svg>

			<?php else : ?>
				<svg class="text-gray-300 h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
					<path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
				</svg>
			<?php endif; ?>
		<?php endfor; ?>
		<p class="sr-only"><?php echo esc_html($average); ?> <?php _e('out of 5 stars', 'elmgren') ?></p>
		<p class="ml-2 text-sm text-gray-500"><?php echo esc_html($rating_count); ?> <?php _e('reviews', 'elmgren') ?></p>
	</div>

<?php endif; ?>