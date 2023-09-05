import { Notice } from "./classes/Notice";

jQuery(function ($) {
    $('form#add-to-cart').on('submit', function (e) {
        e.preventDefault();

        const submit_btn = $('button[name="add-to-cart"]');

        if (!(this instanceof HTMLFormElement)) {
            return
        }

        const product_id = $('button[name="add-to-cart"]').val();
        const variation_id = submit_btn.attr('variation-id');
        const input = $('input[name="quantity"]').val();

        $.ajax({
            url: wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'add_to_cart'),
            data: {
                action: "add_to_cart",
                product_id: product_id,
                variation_id: variation_id,
                quantity: input || 1
            },
            type: 'POST',
            complete: function (response) {
                new Notice({
                    message: 'Product added to cart',
                    type: 'success',
                    variant: 'toast',
                    settings: {
                        visibility: 'auto-dismiss',
                        interaction: 'clickable'
                    }
                })
            }
        });
    })
});
