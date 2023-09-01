jQuery(function ($) {
    $('.elm-notice').each(function () {
        const variant = $(this).data('variant');
        const visibility = $(this).data('visibility');
        const interaction = $(this).data('interaction');

        switch (variant) {
            case 'top-fixed':
                $(this).insertAfter('header');  // Changed from $('header').append(this);
                $(this).addClass('top-fixed');
                break;
            case 'bottom-fixed':
                $(this).insertBefore('footer');  // Changed from $('footer').prepend(this);
                $(this).addClass('bottom-fixed');
                break;
            case 'top-scroll':
                $(this).insertAfter('header');  // Changed from $('header').append(this);
                $(this).addClass('top-scroll');
                break;
            case 'bottom-scroll':
                $(this).insertBefore('footer');  // Changed from $('footer').prepend(this);
                $(this).addClass('bottom-scroll');
                break;
            case 'inline':
                const target = $(this).data('target');
                let $targetElement = $('#' + target);

                if ($targetElement.length === 0) {
                    $targetElement = $('.' + target);
                }

                if ($targetElement.length !== 0) {
                    $targetElement.append(this);
                } else {
                    return;
                }
                break;
            default:
                return;
        }

        if (visibility === 'auto-dismiss') {
            setTimeout(() => {
                $(this).fadeOut();
            }, 5000); // 5 seconds
        }

        if (interaction === 'clickable') {
            $(this).click(function () {
                $(this).fadeOut();
            });
        }

        $(this).show();
    });
});
