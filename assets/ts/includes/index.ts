const $ = jQuery

export const capitalize = (str: string) => str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();

export const getActiveAttributes = () => {
    const attrs: Record<string, string> = {}
    $('button[data-attr-button].active').each(function () {
        const attr = $(this).closest('div[data-product-attribute]').data('productAttribute')
        const value = $(this).children(`input[name="attribute_${attr}"]`).val()

        if (typeof attr !== 'string' || typeof value !== 'string') {
            return
        }

        attrs[`attribute_${attr}`] = value
    })
    return attrs
}