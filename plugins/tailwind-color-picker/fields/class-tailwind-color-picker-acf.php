<?php

class TailwindColorPickerACF extends acf_field
{
    use TailwindColorPickerTrait;

    function __construct()
    {
        $this->name = 'tailwind_color_picker';
        $this->label = __('Tailwind Color Picker', 'text-domain');
        $this->category = 'basic';
        $this->defaults = array(
            'default_value' => ''
        );

        parent::__construct();
    }

    function render_field($field)
    {
        echo $this->generate_picker_html($field['name'], $field['value'], 'acf', $field['key']);
    }

    function format_value($value, $post_id, $field)
    {
        return $value;
    }

    function validate_value($valid, $value, $field, $input)
    {
        return $valid;
    }

    function update_value($value, $post_id, $field)
    {
        $value = $this->sanitize($value);
        return $value;
    }

    function input_admin_enqueue_scripts()
    {
        // Enqueue the assets for the color picker
        $this->enqueue_assets();
    }
}
