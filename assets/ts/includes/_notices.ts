import { Notice } from "../classes/Notice";

jQuery(function ($) {
    $('.elm-notice').each(function () {
        new Notice(this);
    });
});
