<?php

class Elm_Notice
{
    public static function init()
    {
        add_action('init', [__CLASS__, 'start_session']);
    }

    public static function start_session()
    {
        if (!session_id()) {
            session_start();
        }
    }

    public static function add($message, $type = 'success', $variant = 'top-fixed', $settings = [])
    {
        // Define default settings and merge with provided settings
        $default_settings = [
            'visibility' => 'persistent',  // Options: 'auto-dismiss', 'persistent'
            'interaction' => 'static'        // Options: 'static', 'clickable'
        ];

        $settings = array_merge($default_settings, $settings);
        $target = isset($settings['target']) ? $settings['target'] : '';

        $_SESSION['elm_notices'][] = [
            'message' => $message,
            'type' => $type,
            'variant' => $variant,
            'settings' => $settings,
            'target' => $target
        ];
    }


    public static function display()
    {
        if (!empty($_SESSION['elm_notices'])) {
            foreach ($_SESSION['elm_notices'] as $notice) {
                $data_attributes = 'data-variant="' . esc_attr($notice['variant']) . '"';
                $data_attributes .= ' data-visibility="' . esc_attr($notice['settings']['visibility']) . '"';
                $data_attributes .= ' data-interaction="' . esc_attr($notice['settings']['interaction']) . '"';

                if ($notice['variant'] === 'inline' && !empty($notice['target'])) {
                    $data_attributes .= ' data-target="' . esc_attr($notice['target']) . '"';
                }

                // Position is defined with jQuery
                echo '<div class="notice ' . esc_attr($notice['type']) . '" ' . $data_attributes . '>' . esc_html($notice['message']) . '</div>';
            }
            unset($_SESSION['elm_notices']);  // Clear notices after displaying
        }
    }
}

$notices = Elm_Notice::init();
