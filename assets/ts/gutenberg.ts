// Add width class to editor-styles-wrapper
jQuery(($) => {
    const addClassToWrapper = (className: string) => {
        // Check if the wrapper exists now and add the class
        const wrapper = $('.editor-styles-wrapper'); // Replace with the actual wrapper class or ID
        if (wrapper.length) {
            wrapper.addClass(className);
        }
    };

    if (typeof acf !== 'undefined') {
        const field = acf.getField('field_64db33e599679')

        addClassToWrapper(field.val())

        const observer = new MutationObserver((mutationsList) => {
            for (const mutation of mutationsList) {
                if (mutation.type === 'childList') {
                    // Run the function every time a child node is added or removed
                    addClassToWrapper(field.val());
                }
            }
        });

        field.$el.on('change', function (e) {
            addClassToWrapper(field.val());
        });
        observer.observe(document.body, { attributes: false, childList: true, subtree: true });
    }
});
