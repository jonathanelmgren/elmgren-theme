<?php
if (!defined('ABSPATH')) {
	exit;
}

if (empty($breadcrumb)) {
	return;
}

echo '<nav class="mb-4" aria-label="Breadcrumb">';  // wrap_before in Tailwind

foreach ($breadcrumb as $key => $crumb) {
	echoBreadcrumbItem($crumb, $key, count($breadcrumb));
}

echo '</nav>';  // wrap_after in Tailwind