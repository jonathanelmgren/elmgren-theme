// Mobile menu functinality
(function ($) {
    // Function to toggle the mobile menu's visibility
    function toggleMobileMenu() {
        $('[data-menu="mobile"]').toggleClass('hidden');
    }

    // Bind the toggle function to relevant triggers
    $('[data-menu-toggle="open"], [data-menu-toggle="close"], [data-backdrop]').on("click", toggleMobileMenu);
}(jQuery));

// Mega menu
(function ($) {
    $('[data-menu-item]').on('mouseenter', function () {
        $('.flyout-menu').addClass('hidden');
        if ($(this).has('[data-has-children]')) {
            $(this).next('.flyout-menu').addClass('block').removeClass('hidden');
        }
    });
    $('header').on('mouseleave', function () {
        $('.flyout-menu').removeClass('block');
        $('.flyout-menu').addClass('hidden');
    })
}(jQuery));