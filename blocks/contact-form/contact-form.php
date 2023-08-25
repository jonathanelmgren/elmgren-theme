<?php
$base_colors = new TailwindColor([
    'text_color' => ['attr' => 'text'],
    'placeholder_color' => ['attr' => 'text', 'prefix' => 'placeholder'],
]);

$button_colors = new TailwindColor([
    'button_text_color' => ['attr' => 'text'],
    'button_background_color' => ['attr' => 'bg'],
    'button_background_hover_color' => ['attr' => 'bg', 'prefix' => 'hover'],
]);
$input_class = $base_colors->get_classes('block w-full rounded-md border-0 px-3.5 py-2 shadow-sm ring-1 ring-inset focus:ring-2 focus:ring-inset  sm:text-sm sm:leading-6');
$label_class = 'block text-sm font-semibold leading-6 ' . $base_colors->get_class('text_color');
?>

<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
    <?php wp_nonce_field('contact_form_action', 'contact_form_nonce'); ?>
    <input type="hidden" name="action" value="contact_form_submission">
    <input type="hidden" name="send-to" value="<?php the_field('send_to') ?>">
    <div class="mx-auto max-w-xl lg:mr-0 lg:max-w-lg">
        <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
            <!-- First name -->
            <div>
                <label for="first-name" class="<?php echo $label_class ?>" style="<?php $base_colors->the_style('text_color') ?>">First name</label>
                <div class="mt-2.5">
                    <input type="text" name="first-name" id="first-name" autocomplete="given-name" class="<?php echo $input_class ?>" style="<?php $base_colors->the_styles() ?>">
                </div>
            </div>

            <!-- Last name -->
            <div>
                <label for="last-name" class="<?php echo $label_class ?>" style="<?php $base_colors->the_style('text_color') ?>">Last name</label>
                <div class="mt-2.5">
                    <input type="text" name="last-name" id="last-name" autocomplete="family-name" class="<?php echo $input_class ?>" style="<?php $base_colors->the_styles() ?>">
                </div>
            </div>

            <!-- Email -->
            <div class="sm:col-span-2">
                <label for="email" class="<?php echo $label_class ?>" style="<?php $base_colors->the_style('text_color') ?>">Email</label>
                <div class="mt-2.5">
                    <input type="email" name="email" id="email" autocomplete="email" class="<?php echo $input_class ?>" style="<?php $base_colors->the_styles() ?>">
                </div>
            </div>

            <!-- Phone number -->
            <div class="sm:col-span-2">
                <label for="phone-number" class="<?php echo $label_class ?>" style="<?php $base_colors->the_style('text_color') ?>">Phone number</label>
                <div class="mt-2.5">
                    <input type="tel" name="phone-number" id="phone-number" autocomplete="tel" class="<?php echo $input_class ?>" style="<?php $base_colors->the_styles() ?>">
                </div>
            </div>

            <!-- Message -->
            <div class="sm:col-span-2">
                <label for="message" class="<?php echo $label_class ?>" style="<?php $base_colors->the_style('text_color') ?>">Message</label>
                <div class="mt-2.5">
                    <textarea name="message" id="message" rows="4" class="<?php echo $input_class ?>" style="<?php $base_colors->the_styles() ?>"></textarea>
                </div>
            </div>
        </div>
        <div class="mt-8 flex justify-end">
            <button type="submit" style="<?php $button_colors->the_styles() ?>" class="<?php $button_colors->the_classes('rounded-md px-3.5 py-2.5 text-center text-sm font-semibold shadow-sm  focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2') ?>">Send message</button>
        </div>
    </div>
</form>