
jQuery(function ($) {
    $('input[data-cart-qty-input]').on('input', function () {
        $(this).siblings('button[type="submit"]').toggleClass('hidden block')
    })
});
jQuery(function ($) {
    $('[data-shipping-calculator-button]').on('click', function () {
        const form = $('[data-shipping-calculator]');
        if (form.is(':visible')) {
            form.slideUp(250)
        } else {
            form.slideDown(250)
        }
    })
});