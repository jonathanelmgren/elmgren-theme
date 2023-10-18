<?php

class Elm_JSON_Response
{
    public function __construct(string $message, bool $success = true, int $code = 200, array $noticeSettings = [])
    {
        wp_send_json(array('message' => $message, 'code' => $code, 'success' => $success, 'notice' => count($noticeSettings) > 0 ? Elm_Notice::generate_html($noticeSettings) : null));
    }
}
