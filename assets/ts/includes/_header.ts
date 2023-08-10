(function ($) {
    // Function to toggle the mobile menu's visibility
    function toggleMobileMenu() {
        $('[data-menu="mobile"]').toggleClass('hidden');
    }

    // Bind the toggle function to relevant triggers
    $('[data-menu-toggle="open"], [data-menu-toggle="close"], [data-backdrop]').on("click", toggleMobileMenu);
}(jQuery));
