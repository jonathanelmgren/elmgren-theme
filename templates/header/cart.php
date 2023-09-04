    <?php
    if (!elm_is_woocommerce_activated()) {
        return;
    }
    $qty = WC()->cart->get_cart_contents_count();

    $colors = new TailwindColor([
        'elm_woo_cart_bg_color' => ['attr' => 'text'],
    ]);
    $box_colors = new TailwindColor([
        'elm_woo_cart_qty_bg_color' => ['attr' => 'bg'],
        'elm_woo_cart_text_color' => ['attr' => 'text'],
    ]);
    $classname = "absolute -right-1 -top-1 rounded-full w-4 h-4 top text-xs grid justify-center content-center";

    ?>
    <a href="#" role="button" <?php $colors->the_attrs('relative flex bg-transparent') ?>>
        <?php elm_the_inline_svg('cart') ?>
        <?php if ($qty > 0) : ?>
            <span <?php $box_colors->the_attrs($classname) ?>><?php echo $qty ?>
            </span>
        <?php endif; ?>
    </a>