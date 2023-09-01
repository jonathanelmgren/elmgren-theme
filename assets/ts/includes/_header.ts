// Mobile menu functinality
(function ($) {
    // Function to toggle the mobile menu's visibility
    function toggleMobileMenu() {
        $('[data-menu="mobile"]').toggleClass('hidden');
    }

    // Bind the toggle function to relevant triggers
    $('[data-menu-toggle="open"], [data-menu-toggle="close"], [data-backdrop]').on("click", toggleMobileMenu);
}(jQuery));

// Dropdown menu functionality
(function ($) {
    $('a[data-menu-item]').on('mouseenter click', function (e) {
        const isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0
        const isMobile = $(this).data('isMobile') == ''
        const hasChildren = $(this).data('hasChildren') === ''

        const submenu = $(this).next('.sub-menu')
        const onText = e.target !== this && $(e.target).hasClass('menu-item-text')

        // If click directly on text on touch device keep default (redirect)
        if (onText && isTouchDevice) return

        if (!isMobile) {
            $('.sub-menu').not(submenu).hide();
        }
        
        if (isTouchDevice && e.type === 'click' && hasChildren) {
            e.preventDefault();
            submenu.toggle();
        } else if (!isTouchDevice) {
            submenu.show();
        }
    });
    $('header').on('mouseleave', function () {
        $('.sub-menu').hide();
    })
}(jQuery));
