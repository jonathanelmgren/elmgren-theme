
jQuery(function ($) {
    $('input[data-cart-qty-input]').on('input', function () {
        $(this).siblings('button[type="submit"]').show()
    })
});