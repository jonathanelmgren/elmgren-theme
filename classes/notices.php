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

    public static function add($message, $type = 'success')
    {
        $_SESSION['elm_notices'][] = ['message' => $message, 'type' => $type];
    }

    public static function display()
    {
        if (!empty($_SESSION['elm_notices'])) {
            foreach ($_SESSION['elm_notices'] as $notice) {
                echo '<div class="notice ' . esc_attr($notice['type']) . '">' . esc_html($notice['message']) . '</div>';
            }
            unset($_SESSION['elm_notices']);  // Clear notices after displaying
        }
    }
}

$notices = Elm_Notice::init();
