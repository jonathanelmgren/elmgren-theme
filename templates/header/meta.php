<?php
// Meta title
$meta_title = get_field('meta_title');
if (empty($meta_title)) {
    $meta_title = get_the_title() . ' | ' . get_bloginfo('name');
}
?>
<title><?php echo esc_attr($meta_title); ?></title>

<?php
// Meta description
$meta_description = get_field('meta_description');
if (empty($meta_description)) {
    $meta_description = get_bloginfo('description');
}
?>
<meta name="description" content="<?php echo esc_attr($meta_description); ?>" />

<?php
// Canonical URL
$canonical_url = get_field('canonical_url');
if (!empty($canonical_url)) {
    echo '<link rel="canonical" href="' . esc_url($canonical_url) . '" />';
}
?>

<?php
// Robots Meta
$robots_meta = get_field('robots_meta');
if (!empty($robots_meta)) {
    echo '<meta name="robots" content="' . esc_attr($robots_meta) . '" />';
}
?>