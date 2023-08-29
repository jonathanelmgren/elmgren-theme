jQuery(function ($) {
    $('.notice').each(function () {
        const variant = $(this).data('variant');
        const visibility = $(this).data('visibility');
        const interaction = $(this).data('interaction');

        switch (variant) {
            case 'top-fixed':
                $('header').append(this);
                $(this).addClass('top-fixed');
                break;
            case 'bottom-fixed':
                $('footer').prepend(this);
                $(this).addClass('bottom-fixed');
                break;
            case 'top-scroll':
                $('header').append(this);
                $(this).addClass('top-scroll');
                break;
            case 'bottom-scroll':
                $('footer').prepend(this);
                $(this).addClass('bottom-scroll');
                break;
            case 'inline':
                const target = $(this).data('target');
                $(target).append(this);
                break;
            default:
                // Default behavior
                break;
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
