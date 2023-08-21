import { capitalize } from ".";

interface ThemeSettings {
    colors?: {
        [key: string]: {
            [key: string]: string;
        };
    };
}

declare const themeSettings: ThemeSettings;

const NOT_PRESET = 'not-preset';
const DEFAULT_VALUE = 'DEFAULT';

function setDropdownsBasedOnColorPicker(picker: JQuery, valueDropdown: JQuery, keyDropdown: JQuery, colors: Record<string, Record<string, string>>) {
    const colorValue = picker.iris('option', 'color');
    const selectedValue = typeof colorValue === 'string' ? colorValue.toLowerCase() : undefined;

    let foundPreset = false;
    for (const [colorKey, shades] of Object.entries(colors)) {
        for (const [shadeKey, shadeValue] of Object.entries(shades)) {
            if (shadeValue.toLowerCase() === selectedValue) {
                keyDropdown.val(colorKey);
                updateValueDropdown(colorKey, valueDropdown, colors);
                valueDropdown.val(shadeValue.toLowerCase());
                foundPreset = true;
                break;
            }
        }
        if (foundPreset) break;
    }

    if (!foundPreset) {
        keyDropdown.val(NOT_PRESET);
        valueDropdown.val(valueDropdown.find(`option:contains(${DEFAULT_VALUE})`).val() as string);
        valueDropdown.hide();
    } else {
        valueDropdown.show();
    }
}

function updateValueDropdown(selectedKey: string, valueDropdown: JQuery, colors: Record<string, Record<string, string>>) {
    valueDropdown.empty();
    let defaultColorValue: string | null = null;

    if (colors[selectedKey]) {
        Object.entries(colors[selectedKey]).forEach(([key, value]) => {
            if (key === DEFAULT_VALUE) {
                defaultColorValue = value.toLowerCase();
            } else {
                valueDropdown.append(`<option value="${value.toLowerCase()}">${key.charAt(0).toUpperCase() + key.slice(1)}</option>`);
            }
        });
    }

    // Check if option with DEFAULT value already exists
    const existingOption = valueDropdown.find(`option[value="${defaultColorValue}"]`);
    if (existingOption.length) {
        existingOption.text(`${existingOption.text()} (Default)`);
    } else if (defaultColorValue) {
        valueDropdown.append(`<option value="${defaultColorValue}">${capitalize(DEFAULT_VALUE)}</option>`);
    }

}

jQuery(function ($) {
    const colors = themeSettings?.colors;
    if (!colors) return;
    if (typeof acf === 'undefined') return;
    acf.addAction('append_field/type=color_picker', function ({ $el }: acf.Field) {
        const container = $($el);
        const colorPicker = container.find('input.wp-color-picker');

        console.log(colorPicker)

        const keyDropdown = $('<select></select>').appendTo(container);
        keyDropdown.append(`<option value=${NOT_PRESET}>No preset</option>`);
        Object.keys(colors).forEach(colorKey => {
            keyDropdown.append(`<option value="${colorKey}">${colorKey.charAt(0).toUpperCase() + colorKey.slice(1)}</option>`);
        });

        const valueDropdown = $('<select></select>').appendTo(container);

        setDropdownsBasedOnColorPicker(colorPicker, valueDropdown, keyDropdown, colors);

        keyDropdown.on('change', function () {
            const selectedKey = $(this).val() as string;
            if (selectedKey === NOT_PRESET) {
                valueDropdown.hide();
                colorPicker.iris('option', 'color', '');  // Reset color picker if needed
            } else {
                updateValueDropdown(selectedKey, valueDropdown, colors);
                const defaultShadeValue = valueDropdown.find(`option:contains(Default)`).first().val()
                if (defaultShadeValue) {
                    valueDropdown.val(defaultShadeValue).trigger('change');
                }
                colorPicker.iris('option', 'color', defaultShadeValue).trigger('input');
                valueDropdown.show();
            }
        });


        valueDropdown.on('change', function () {
            const selectedValue = $(this).val() as string;
            colorPicker.iris('option', 'color', selectedValue);
        });

        colorPicker.on('irischange', function () {
            setDropdownsBasedOnColorPicker($(this), valueDropdown, keyDropdown, colors);
        });
    });
});




jQuery(function ($) {
    const colors = themeSettings?.colors;
    function findCorrespondingClassControl($liElement: JQuery<HTMLElement>) {
        // Extract the base setting name from the current control's ID
        const baseSettingName = $liElement.attr('id')?.replace('customize-control-', '').replace('_control', '');

        return baseSettingName + '_class'
    }
    function getTailwindClassForColor(color: string): string {
        for (const className in colors) {
            for (const shade in colors[className]) {
                if (colors[className][shade].toLowerCase() === color.toLowerCase()) {
                    return `${className}-${shade}`;
                }
            }
        }
        return "";
    }
    if (colors) {
        $('.customize-control-color').each(function () {
            const container = $(this);
            const colorPicker = container.find('.color-picker-hex');
            const tailwindInput = findCorrespondingClassControl(container)

            const keyDropdown = $('<select></select>').appendTo(container);
            keyDropdown.append(`<option value=${NOT_PRESET}>No preset</option>`);
            Object.keys(colors).forEach(colorKey => {
                keyDropdown.append(`<option value="${colorKey}">${colorKey.charAt(0).toUpperCase() + colorKey.slice(1)}</option>`);
            });

            const valueDropdown = $('<select></select>').appendTo(container);

            setDropdownsBasedOnColorPicker(colorPicker, valueDropdown, keyDropdown, colors);

            keyDropdown.on('change', function () {
                const selectedKey = $(this).val() as string;
                if (selectedKey === NOT_PRESET) {
                    valueDropdown.hide();
                    colorPicker.iris('option', 'color', '');  // Reset color picker if needed
                } else {
                    updateValueDropdown(selectedKey, valueDropdown, colors);
                    const defaultShadeValue = valueDropdown.find(`option:contains(Default)`).first().val()
                    if (defaultShadeValue) {
                        valueDropdown.val(defaultShadeValue).trigger('change');
                    }
                    colorPicker.iris('option', 'color', defaultShadeValue).trigger('input');
                    valueDropdown.show();
                }
            });

            valueDropdown.on('change', function () {
                const selectedValue = $(this).val() as string;
                colorPicker.iris('option', 'color', selectedValue);
            });

            colorPicker.on('irischange', function () {
                const tailwindClass = getTailwindClassForColor(colorPicker.iris('color'));
                console.log(tailwindClass)
                wp.customize(tailwindInput).set(tailwindClass);
                setDropdownsBasedOnColorPicker($(this), valueDropdown, keyDropdown, colors);
            });
        });
    }
});
