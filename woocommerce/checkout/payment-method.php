<?php

if (!defined('ABSPATH')) {
	exit;
}

// Determine the classes based on chosen state
$activeClass = $gateway->chosen ? 'active' : '';
?>

<label data-payment-method class="relative cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none border-gray-300 <?= $activeClass ?>">
	<input type="radio" 
	       name="payment_method" 
	       value="<?= esc_attr($gateway->id); ?>" 
	       class="sr-only" 
	       <?= checked($gateway->chosen, true); ?>
	>

	<span class="flex flex-1">
		<span class="flex flex-col">
			<?php if ($gateway->get_icon()) : ?>
				<span class="block text-sm font-medium text-gray-400"><?= $gateway->get_icon(); ?></span>
			<?php else : ?>
				<span class="block text-sm font-medium text-gray-400"><?= $gateway->get_title(); ?></span>
			<?php endif; ?>

			<?php if ($gateway->get_description()) : ?>
				<span class="mt-1 flex items-center text-sm text-gray-500"><?= $gateway->get_description(); ?></span>
			<?php endif; ?>
		</span>
	</span>

	<svg class="h-5 w-5 text-indigo-600 absolute hidden top-2 right-2 <?= $activeClass ?>" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
		<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
	</svg>
</label>
