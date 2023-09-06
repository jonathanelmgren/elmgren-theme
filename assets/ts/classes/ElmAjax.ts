import { Notice } from "./Notice";

const $ = jQuery

export class ElmAjax {
    constructor(action: string, data: Record<string, any>) {
        const ajaxData = { action, ...data }

        $.ajax({
            url: elmAjax.url,
            data: ajaxData,
            type: 'POST',
            error: function (response) {
                new Notice({
                    message: 'Something went wrong. Please try again.',
                    type: 'error',
                    variant: 'toast'
                })
            },
            success: function (response) {
                if (typeof response?.notice === 'string') {
                    new Notice(response.notice)
                }
            }
        });
    }
}