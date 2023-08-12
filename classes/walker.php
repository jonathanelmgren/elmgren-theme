<?php
class Elmgren_Walker_Nav_Menu extends Walker_Nav_Menu
{
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0, $class = "text-sm leading-6 hover:text-gray")
    {
        $args = (object) $args;  // Type cast to object

        // Get the color attributes using the setting you'd like (change 'color_setting' to your actual setting name)
        $color_attrs = elm_apply_text_color('header_link_color', $class, '', 'text-gray-900');

        // Extract style and class attributes from $color_attrs to merge with existing attributes
        preg_match('/style="([^"]+)"/', $color_attrs, $style_matches);
        preg_match('/class="([^"]+)"/', $color_attrs, $class_matches);

        $color_style = $style_matches[1] ?? "";
        $color_class = $class_matches[1] ?? "";

        // Combine the color styles and classes with the existing attributes
        $style_attr = $color_style ? ' style="' . esc_attr($color_style) . '"' : "";
        $class_attr = ' class="' . esc_attr($class . ' ' . $color_class) . '"';

        // Construct the attributes string
        $attributes = ' href="' . esc_attr($item->url) . '"' . $class_attr . $style_attr;

        $title = apply_filters('the_title', $item->title, $item->ID);

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

class Elmgren_Walker_Footer_Menu extends Elmgren_Walker_Nav_Menu
{
    function start_el(&$output, $item, $depth = 0, $args = [], $id = 0, $class = "text-sm font-semibold leading-6 text-gray-900")
    {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $output .= $indent . '<div class="pb-6">';

        parent::start_el($output, $item, $depth, $args, 0, "text-sm leading-6 text-gray-600 hover:text-gray-900");
    }

    // Override end_el() function to close custom wrapping div
    function end_el(&$output, $item, $depth = 0, $args = null)
    {
        $output .= "</div>\n";
    }
}
