<?php

require_once __DIR__ . '/class-elm-base-walker.php';

class Elm_Mega_Menu_Walker_Nav_Menu extends Elm_Walker_Nav_Menu
{
    private $openWrapper = false;  // Flag to track if the div wrapper is open
    private $isFirstItemOfSecondDepth = true;  // Flag to track the first item of the second depth

    public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0): void
    {
        if ($depth == 1 && $this->isFirstItemOfSecondDepth) {
            $output .= '<div class="flex flex-col grow shrink basis-0 flex-wrap">';  // Open the div wrapper
            $this->openWrapper = true;  // Set the flag
            $this->isFirstItemOfSecondDepth = false;  // Reset the flag
        }

        $args = $this->initialize_args($args);
        $indent = str_repeat("	", $depth);
        $attributes = $this->get_combined_attributes($item, $depth, $args);

        $arrow_down = $this->has_children($item) && $depth === 0 ? elm_get_inline_svg('arrow_down') : '';

        $item_output = $this->generate_item_output($item, $attributes, $args, $arrow_down);
        $output .= $indent . apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    public function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output)
    {
        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);

        $id_field = $this->db_fields['id'];
        $id       = $element->$id_field;

        if ($depth == 1 && !$this->has_children && empty($children_elements[$id]) && $this->openWrapper) {
            $output .= '</div>';  // Close the div wrapper
            $this->openWrapper = false;  // Reset the flag
            $this->isFirstItemOfSecondDepth = true;
        }
    }

    protected function get_combined_attributes($item, $depth, $args): string
    {
        $header_link_colors = new TailwindColor([
            'header_link_color' => ['attr' => 'text', 'fallback' => 'text-gray-600'],
            'header_link_color_hover' => ['attr' => 'text', 'prefix' => 'hover', 'fallback' => 'text-gray-900']
        ]);

        $class = 'class="items-center gap-x-1';
        if ($this->has_children($item) && $depth === 0) {
            $class .= ' inline-flex';
        }

        if ($depth === 1) {
            $class .= ' font-bold mb-2';
        }
        $class .= ' ' . $header_link_colors->get_classes();
        $class .= '"';


        $styles = 'style="' . $header_link_colors->get_styles() . '"';

        $attrs = $class . ' ' . $styles;

        if ($this->has_children($item)) {
            $attrs .= ' data-has-children';  // Append the class if the item has children
        }
        if ($depth === 0) {
            $attrs .= ' data-menu-item';  // Append the class if the item has children
        }

        return $attrs;
    }

    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        if ($depth === 0) { // This checks if we're at the top level
            $has_border = get_theme_mod('header_border', false);
            $header_bg_color = new TailwindColor(['header_bg_color' => ['attr' => 'bg', 'fallback' => 'transparent']]);
            $width = elm_get_page_width(true);

            $class = 'min-h-[24rem] sub-menu  absolute top-full z-10 left-0 py-6 w-full';
            $class .= ' ' . $header_bg_color->get_classes();
            $class .= $has_border ? ' mt-[2px]' : '';

            $output .= '<div class="' . $class . '" style="display:none;' . $header_bg_color->get_styles() . '">';
            $output .= '<div class="gap-8 flex align-start ' . $width . '">';
        }
    }

    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        if ($depth === 0) {
            $output .= '</div></div>';
        }
    }
}
