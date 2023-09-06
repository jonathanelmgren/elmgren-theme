jQuery(function ($) {
    const submit_btn = $('button[name="add-to-cart"]');
    const attribute_length = $('div[data-product-attribute]').length;
    const productImage = $('img[data-product-image]')
    const addToCartContainer = $('div[data-add-to-cart-container]')
    const variantPriceContainer = $('div[data-product-variant-price]')

    let selectedAttributes: Record<string, string> = {};

    $('div[data-product-attribute] button').on('click', function () {
        selectedAttributes = {}

        if ($(this).hasClass('active')) {
            $(this).removeClass('active')
        } else {
            $(this).addClass('active').siblings().removeClass('active')
        }

        $('button[data-attr-button].active').each(function () {
            const attr = $(this).closest('div[data-product-attribute]').data('productAttribute')
            const value = $(this).children(`input[name="${attr}"]`).val()

            if (typeof attr !== 'string' || typeof value !== 'string') {
                return
            }

            selectedAttributes[`attribute_${attr}`] = value
        })

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
            if (matchingVariation && Object.keys(selectedAttributes).length === attribute_length) {
                const { image, variation_id, price_html } = matchingVariation
                const { src, alt } = image
                productImage.attr('src', src)
                productImage.attr('alt', alt)

                variantPriceContainer.html(price_html)

                submit_btn.prop('disabled', false);
                submit_btn.attr('variation-id', variation_id)
            } else {
                submit_btn.prop('disabled', true);
                submit_btn.removeAttr('variation-id')
            }
        }

    });
});