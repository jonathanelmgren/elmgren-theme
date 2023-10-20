
jQuery(function ($) {
    $('input[data-cart-qty-input]').on('input', function () {
        $(this).siblings('button[type="submit"]').toggleClass('hidden block')
    })
});
jQuery(function ($) {
    $('[data-shipping-calculator-button]').on('click', function () {
        $('[data-shipping-calculator]').toggleClass('hidden flex')
    })
});