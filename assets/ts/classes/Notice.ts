import { NoticeStatusType, NoticeVariantType, Notice_Variant } from "../types";

const $ = jQuery

interface New_Notice {
    message: string, type: NoticeStatusType, variant: NoticeVariantType, settings?: Record<string, string>, target?: string
}

export class Notice {
    constructor(notice: HTMLElement | New_Notice | string) {
        if (notice instanceof HTMLElement || typeof notice === 'string') {
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
            const nativeElement = $(response).first().get(0);
            if (nativeElement instanceof HTMLElement) {
                this.showNotice(nativeElement);
            }
        });
    }

    showNotice(notice: HTMLElement | string) {
        let nativeElement: HTMLElement;

        if (typeof notice === 'string') {
            nativeElement = $(notice)[0];
        } else {
            nativeElement = notice;
        }

        const variant = $(nativeElement).data('variant');
        const visibility = $(nativeElement).data('visibility');
        const interaction = $(nativeElement).data('interaction');
        switch (variant) {
            case 'top-fixed':
                $(nativeElement).insertAfter('header');
                break;
            case 'bottom-fixed':
                $(nativeElement).insertBefore('footer');
                break;
            case 'top-scroll':
                $(nativeElement).insertAfter('header');
                break;
            case 'bottom-scroll':
                $(nativeElement).insertBefore('footer');
                break;
            case 'toast':
                $(nativeElement).insertAfter('header');
                break;
            case 'inline':
                const target = $(nativeElement).data('target');
                let $targetElement = $('#' + target);

                if ($targetElement.length === 0) {
                    $targetElement = $('.' + target);
                }

                if ($targetElement.length !== 0) {
                    $targetElement.append(nativeElement);
                } else {
                    return;
                }
                break;
            default:
                return;
        }

        if (visibility === 'auto-dismiss') {
            setTimeout(() => {
                $(nativeElement).fadeOut();
            }, 5000); // 5 seconds
        }

        if (interaction === 'clickable') {
            $(nativeElement).click(function () {
                $(nativeElement).fadeOut();
            });
        }

        $(nativeElement).removeClass('hidden');
    }
}