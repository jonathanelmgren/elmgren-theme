<?php

require_once __DIR__ . '/default.php';

class Elm_Mega_Menu_Walker_Nav_Menu extends Elm_Walker_Nav_Menu
{
    private $openWrapper = false;  // Flag to track if the div wrapper is open
    private $isFirstItemOfSecondDepth = true;  // Flag to track the first item of the second depth

    public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0): void
    {
        if ($depth == 1 && $this->isFirstItemOfSecondDepth) {
            $output .= '<div class="flex flex-col w-28">';  // Open the div wrapper
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
        $settings = [
            'header_link_color' => ['attr' => 'text', 'fallback' => 'text-gray-600'],
            'header_link_color_hover' => ['attr' => 'text', 'prefix' => 'hover', 'fallback' => 'text-gray-900']
        ];
        $additional_classes = 'items-center gap-x-1';
        if ($this->has_children($item) && $depth === 0) {
            $additional_classes .= ' inline-flex';
        }
        if ($depth === 1) {
            $additional_classes .= ' font-bold mb-2';
        }
        $attrs = elm_get_classes_and_styles($settings, '', '', false, $additional_classes);

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
            $attr = elm_get_classes_and_styles('header_bg_color', 'bg', '', 'transparent', 'min-h-[24rem] flyout-menu mt-[2px] hidden absolute top-full z-10 left-0 py-6 w-full');
            $width = elm_get_page_width(true);
            $output .= '<div ' . $attr . '>';
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
