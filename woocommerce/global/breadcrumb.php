<?php
if (!defined('ABSPATH')) {
	exit;
}

if (!empty($breadcrumb)) {

	echo '<nav aria-label="Breadcrumb" class="text-sm">'; //wrap_before in Tailwind

	foreach ($breadcrumb as $key => $crumb) {

		echo '<span class="inline-block">'; // before in Tailwind

		if (!empty($crumb[1]) && sizeof($breadcrumb) !== $key + 1) {
			echo '<a href="' . esc_url($crumb[1]) . '" class="text-gray-800 hover:underline">' . esc_html($crumb[0]) . '</a>';
		} else {
			echo '<span class="text-gray-500">' . esc_html($crumb[0]) . '</span>';
		}

		echo '</span>'; // after in Tailwind

		if (sizeof($breadcrumb) !== $key + 1) {
			echo '<span class="mx-2 text-gray-400">/</span>'; //delimiter in Tailwind
		}
	}

	echo '</nav>'; // wrap_after in Tailwind

}
