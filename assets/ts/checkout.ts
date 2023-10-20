jQuery(($) => {
    $(document).on('click', '[data-payment-method]', function () {
        // Deselect all boxes visually
        $('[data-payment-method]').removeClass('active');
        $('[data-payment-method] svg').removeClass('active');
        $('[data-payment-method] input[type="radio"]').prop('checked', false);

        // Select the clicked box visually
        $(this).addClass('active');
        $(this).find('svg').addClass('active');
        $(this).find('input[type="radio"]').prop('checked', true);
    });
});

jQuery(($) => {
    $('#ship-to-different-address-checkbox').on('click', function () {
        $('[data-shipping-form]').toggleClass('hidden block');
    });
});
