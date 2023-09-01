<?php

class TailwindColorPickerThemeCustomizer extends WP_Customize_Control
{
    use TailwindColorPickerTrait;

    public $type = 'tailwind-color-picker';

    public function __construct($manager, $id, $args = array())
    {
        parent::__construct($manager, $id, $args);
    }

    public function render_content()
    {
        echo $this->label;
        echo $this->generate_picker_html($this->id, $this->value(), 'customizer', $this->id);
    }
}
