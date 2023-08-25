jQuery($ => {
    const { colors } = tailwindColorPicker || {};

    const init = (container) => {
        const setting = container.data('setting')
        const settingId = container.data('settingId')?.replace('_control', '');
        const nameSelect = container.find('.tailwind-color-name');
        const shadeSelect = container.find('.tailwind-color-shade');
        const colorPicker = container.find('.iris-color-picker');
        const valueInput = container.find('#tailwind-color-picker-value');

        const getTailwindClass = (val) => {
            const option = shadeSelect.find('option:selected')
            const tailwindColor = colors[nameSelect.val()]?.[option.data('shade')];
            if (val.toLowerCase() === tailwindColor?.toLowerCase()) return `${nameSelect.val()}-${option.data('shade')}`
        }
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
                const value = ui.color.toString();
                valueInput.val(value).trigger('change')
                if (setting === 'customizer') {
                    wp.customize(settingId).set(value)
                }
                updateSelects(value)
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
    }

    if (!colors) return;

    // Init customizer
    if (typeof wp.customize !== 'undefined') {
        $('.tailwind-color-picker[data-setting="customizer"]').each(function () { init($(this)) });
    }

    // Init ACF
    if (typeof acf !== 'undefined') {
        acf.add_action('append_field/type=tailwind_color_picker', function (e) { init($(e).find('.tailwind-color-picker[data-setting="acf"]')) });
    }
});
