import { getActiveAttributes } from "./includes";

jQuery(function ($) {
    const submit_btn = $('button[name="add-to-cart"]');
    const attribute_length = $('div[data-product-attribute]').length;
    const productImage = $('img[data-product-image]')
    const variantPriceContainer = $('div[data-product-variant-price]')
    const parentId = submit_btn.val()


    let selectedAttributes: Record<string, string> = {};

    $('div[data-product-attribute] button').on('click', function () {
        const input = $(this).find('input')
        $(`input[name="${$(input).attr('name')}"]`).prop('checked', false)
        input.prop('checked', true)
        selectedAttributes = {}

        if ($(this).hasClass('active')) {
            $(this).removeClass('active')
        } else {
            $(this).addClass('active').siblings().removeClass('active')
        }

        selectedAttributes = getActiveAttributes()

        if (productVariations.availableVariations) {
            // Find the matching variation
            const matchingVariation = productVariations.availableVariations.find((variation: any) => {
                // First, check if all selected attributes match exactly or are wildcards
                const allAttributesMatch = Object.keys(selectedAttributes).every(attr => {
                    return variation.attributes[attr] === '' || selectedAttributes[attr] === variation.attributes[attr];
                });

                if (allAttributesMatch) {
                    // Then, filter out wildcards and check if the remaining attributes match
                    const nonWildcardAttrs = Object.keys(variation.attributes).filter(attr => variation.attributes[attr] !== '');
                    const nonWildcardMatch = nonWildcardAttrs.every(attr => selectedAttributes[attr] === variation.attributes[attr]);

                    return nonWildcardMatch;
                }

                return false;
            });
            const qtyInput = $('[data-add-to-cart-container] .quantity input')
            if (matchingVariation && Object.keys(selectedAttributes).length === attribute_length) {
                const { image, variation_id, price_html } = matchingVariation
                const { src, alt } = image
                productImage.attr('src', src)
                productImage.attr('alt', alt)

                variantPriceContainer.html(price_html)

                submit_btn.prop('disabled', false);
                qtyInput.removeClass('disabled')
                submit_btn.val(variation_id)
            } else {
                qtyInput.addClass('disabled')
                submit_btn.prop('disabled', true);
                submit_btn.val(parentId || '')
            }
        }

    });
});