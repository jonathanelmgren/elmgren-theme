<?php

function handle_contact_form_submission()
{
    // Verify nonce for security
    if (!isset($_POST['contact_form_nonce']) || !wp_verify_nonce($_POST['contact_form_nonce'], 'contact_form_action')) {
        wp_die('Nonce validation failed');
    }

    // Sanitize fields
    $first_name = sanitize_text_field($_POST['first-name']);
    $last_name = sanitize_text_field($_POST['last-name']);
    $email = sanitize_email($_POST['email']);
    $phone_number = sanitize_text_field($_POST['phone-number']); // This assumes it's just numbers and basic characters
    $message = sanitize_textarea_field($_POST['message']);

    // Prepare the email
    $to = $_POST['send-to']; // Replace with the desired email recipient
    $subject = "New form submission from $first_name $last_name";
    $headers = array('Content-Type: text/html; charset=UTF-8', "From: $first_name $last_name <$email>");

    $email_content = "
        <strong>First Name:</strong> $first_name<br>
        <strong>Last Name:</strong> $last_name<br>
        <strong>Email:</strong> $email<br>
        <strong>Phone Number:</strong> $phone_number<br>
        <strong>Message:</strong><br>$message";

    // Send the email
    if (wp_mail($to, $subject, $email_content, $headers)) {
        Elm_Notice::add('Your message was sent successfully!', 'success', 'inline', ['target' => '#contact-form-notices']);
        // Redirect to a thank you page after sending
        wp_redirect($_SERVER['HTTP_REFERER'] . '#contact-form');
    } else {
        // Handle mail sending failure
        wp_die('There was an error sending the email. Please try again later.');
    }
    exit;
}
add_action('admin_post_contact_form_submission', 'handle_contact_form_submission');
add_action('admin_post_nopriv_contact_form_submission', 'handle_contact_form_submission');

if (function_exists('acf_add_local_field_group')) :

    acf_add_local_field_group(array(
        'key' => 'group_64e8f596da9fb',
        'title' => 'Contact Form',
        'fields' => array(
            array(
                'key' => 'field_64e8f64a49962',
                'label' => 'Send To',
                'name' => 'send_to',
                'aria-label' => '',
                'type' => 'email',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => get_bloginfo('admin_email'),
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array(
                'key' => 'field_64e8f5974995b',
                'label' => 'Text color',
                'name' => 'text_color',
                'aria-label' => '',
                'type' => 'tailwind_color_picker',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
            ),
            array(
                'key' => 'field_64e8f5ab4995c',
                'label' => 'Placeholder color',
                'name' => 'placeholder_color',
                'aria-label' => '',
                'type' => 'tailwind_color_picker',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
            ),
            array(
                'key' => 'field_64e8f5ba4995d',
                'label' => 'Button Text Color',
                'name' => 'button_text_color',
                'aria-label' => '',
                'type' => 'tailwind_color_picker',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
            ),
            array(
                'key' => 'field_64e8f5d04995e',
                'label' => 'Button Background Color',
                'name' => 'button_background_color',
                'aria-label' => '',
                'type' => 'tailwind_color_picker',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
            ),
            array(
                'key' => 'field_64e8f5d04995133',
                'label' => 'Button Background Hover Color',
                'name' => 'button_background_hover_color',
                'aria-label' => '',
                'type' => 'tailwind_color_picker',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
            ),
            array(
                'key' => 'field_64e8f62949961',
                'label' => 'Button Focus Color',
                'name' => 'button_focus_color',
                'aria-label' => '',
                'type' => 'tailwind_color_picker',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'elm/contact-form',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));

endif;
