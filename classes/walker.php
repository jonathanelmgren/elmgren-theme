<?php
class Elmgren_Walker_Nav_Menu extends Walker_Nav_Menu
{
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0, $class = "text-sm leading-6 text-gray-900 hover:text-gray")
    {
        $args = (object) $args;  // Type cast to object

        $attributes = ' href="' . esc_attr($item->url) . '" class="' . $class . '"';

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
