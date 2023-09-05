import { NoticeStatusType, NoticeVariantType, Notice_Variant } from "../types";

const $ = jQuery

interface New_Notice {
    message: string, type: NoticeStatusType, variant: NoticeVariantType, settings?: Record<string, string>, target?: string
}

export class Notice {
    constructor(notice: HTMLElement | New_Notice) {
        if (notice instanceof HTMLElement) {
            this.showNotice(notice);
        } else {
            this.addNotice(notice)
        }
    }

    addNotice(notice: New_Notice) {
        const defaultSettings = {
            visibility: 'auto-dismiss',
            interaction: 'clickable'
        };
        const { message, type, variant, settings = defaultSettings, target } = notice;

        if (variant === Notice_Variant.INLINE && !target) {
            console.error('Inline notice must have a target');
            return;
        }

        $.post('/wp-json/elm-notice/v1/add', {
            message,
            type,
            variant,
            settings,
        }).done(response => {
            const nativeElement = $(response).first();
            this.showNotice(nativeElement as any);
        });
    }

    showNotice(notice: HTMLElement) {
        const variant = $(notice).data('variant');
        const visibility = $(notice).data('visibility');
        const interaction = $(notice).data('interaction');
        switch (variant) {
            case 'top-fixed':
                $(notice).insertAfter('header');  // Changed from $('header').append(notice);
                break;
            case 'bottom-fixed':
                $(notice).insertBefore('footer');  // Changed from $('footer').prepend(notice);
                break;
            case 'top-scroll':
                $(notice).insertAfter('header');  // Changed from $('header').append(notice);
                break;
            case 'bottom-scroll':
                $(notice).insertBefore('footer');  // Changed from $('footer').prepend(notice);
                break;
            case 'toast':
                $(notice).insertAfter('header');
                break;
            case 'inline':
                const target = $(notice).data('target');
                let $targetElement = $('#' + target);

                if ($targetElement.length === 0) {
                    $targetElement = $('.' + target);
                }

                if ($targetElement.length !== 0) {
                    $targetElement.append(notice);
                } else {
                    return;
                }
                break;
            default:
                return;
        }

        if (visibility === 'auto-dismiss') {
            setTimeout(() => {
                $(notice).fadeOut();
            }, 5000); // 5 seconds
        }

        if (interaction === 'clickable') {
            $(notice).click(function () {
                $(notice).fadeOut();
            });
        }

        $(notice).show();
    }
}