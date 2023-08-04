<?php

function elmgren_get_color_setting(string $setting): mixed
{
    $options = get_field('colors', 'options');
    if (is_array($options) && array_key_exists($setting, $options)) {
        return $options[$setting];
    }
    return null;
}

function elmgren_build_css($post_id)
{
    // Check if it's the correct post type (customize this to your needs)
    if ($post_id !== 'options') {
        return;
    }

    // Check if Node.js is installed and can run commands
    $nodeVersion = shell_exec('node -v');
    if ($nodeVersion === null) {
        // Handle the error (Node.js is not installed or cannot run commands)
        return;
    }

    // Check if npm is installed and can run commands
    $npmVersion = shell_exec('npm -v');
    if ($npmVersion === null) {
        // Handle the error (npm is not installed or cannot run commands)
        return;
    }

    // Run npm install
    $theme_directory = get_template_directory();
    $variables_path = $theme_directory . '/' . 'assets/scss/base/_variables.scss';

    // Define the names of your colors and their corresponding ACF fields.
    $colors = array(
        '--color-brand--primary' => 'color_picker_field_primary',
        '--color-brand--secondary' => 'color_picker_field_secondary',
    );

    // Load the SCSS file content.
    $scss_content = file_get_contents($variables_path);

    // For each color...
    foreach ($colors as $color_name => $acf_field) {
        // Fetch the value from the corresponding ACF field.
        $color_value = elmgren_get_color_setting($acf_field);

        // Replace the color definition in the SCSS file content.
        $pattern = '/(@include defineColor\(' . preg_quote($color_name, '/') . ', )#([0-9a-fA-F]{3,6})/';
        $replacement = '${1}' . $color_value;
        $scss_content = preg_replace($pattern, $replacement, $scss_content);
    }

    // Save the modified SCSS file content.
    file_put_contents($variables_path, $scss_content);

    shell_exec("cd $theme_directory && npm install");

    // Run the build command
    shell_exec("cd $theme_directory && npm run build");
}

// Use the ACF action hook
add_action('acf/save_post', 'elmgren_build_css', 20);
