jQuery($ => {
    const { colors } = tailwindColorPicker || {};

    if (typeof wp === 'undefined' || typeof wp.customize === 'undefined') {
        console.error('wp.customize is not available');
        return;
    }
    if (!colors) return;

    $('.tailwind-color-picker').each(function () {
        const container = $(this);
        const settingId = container.data('settingId')?.replace('_control', '');
        const nameSelect = container.find('.tailwind-color-name');
        const shadeSelect = container.find('.tailwind-color-shade');
        const colorPicker = container.find('.iris-color-picker');

        const getTailwindClass = (val) => {
            const option = shadeSelect.find('option:selected')
            const tailwindColor = colors[nameSelect.val()]?.[option.data('shade')];
            if (val.toLowerCase() === tailwindColor?.toLowerCase()) return `${nameSelect.val()}-${option.data('shade')}`
        }
        const updateCustomizerValue = (val) => {
            const res = { tailwind: getTailwindClass(val), color: val }
            console.log(settingId, res)
            wp.customize(settingId).set(res)
        };
        const updateSelects = (val) => {
            const color = getTailwindClass(val);
            if (!color) {
                nameSelect.val('No preset')
                updateColorShades();
            }
        }
        const updateColorShades = () => {
            const colorName = nameSelect.val();
            const shades = colors[colorName] || {};
            shadeSelect.prop('disabled', false)
            shadeSelect.empty();

            if (Object.keys(shades).length === 0) {
                const option = `<option>Select a preset first</option>`;
                shadeSelect.append(option);
                shadeSelect.prop('disabled', true)
                return
            }

            for (const shade in shades) {
                const color = colors[nameSelect.val()]?.[shade];
                const option = `<option data-shade="${shade}" value="${color}">${shade}</option>`;
                shadeSelect.append(option);
            }

            for (const o of $(shadeSelect).find('option')) {
                const option = $(o)
                const value = $(option).val()
                const duplicate = shadeSelect.find(`option[value="${value}"]`).not(option);

                if (duplicate.length > 0) {
                    if (duplicate.text() === 'DEFAULT' && !option.text().includes('(Default)')) {
                        option.text(`${option.text()} (Default)`)
                        option.attr('data-is-default', 'true')
                        duplicate.remove()
                    } else if (option.text() === 'DEFAULT' && !duplicate.text().includes('(Default)')) {
                        duplicate.text(`${duplicate.text()} (Default)`)
                        duplicate.attr('data-is-default', 'true')
                        option.remove()
                    }
                }
            }

            const defaultOption = shadeSelect.find('option[data-is-default="true"]')
            shadeSelect.val(defaultOption.val()).trigger('change')

            // Trigger shade dropdown change to update the color picker
            shadeSelect.trigger('change');
        };
        updateColorShades()

        $(colorPicker).wpColorPicker({
            change: (e, ui) => {
                updateCustomizerValue(ui.color.toString())
                updateSelects(ui.color.toString())
            },
            clear: () => {
                updateCustomizerValue(undefined)
            }
        });

        $(nameSelect).on('change', function () {
            updateColorShades();
        });

        $(shadeSelect).on('change', function () {
            const colorShade = $(this).val();
            if (colorShade) {
                colorPicker.wpColorPicker('color', colorShade);
            }

        });
    });
});
