import React from 'react'

wp.domReady(() => {
    const buttonSizes = [
        { name: 'small', label: 'Small' },
        { name: 'medium', label: 'Medium' },
        { name: 'large', label: 'Large' }
    ];

    wp.hooks.addFilter(
        'editor.BlockEdit',
        'elm/core/button',
        (BlockEdit) => {
            return (props: any) => {
                if (props.name !== 'core/button') {
                    return <BlockEdit {...props} />;
                }

                let existingClasses = props.attributes.className || "";

                // Set default to medium if no size is set
                if (!existingClasses.split(' ').some((className: string) => className.startsWith('is-size-'))) {
                    existingClasses = `${existingClasses} is-size-medium`.trim();
                    props.setAttributes({ className: existingClasses });
                }

                const selectedSize = existingClasses.split(' ').find((className: string) => className.startsWith('is-size-'));

                const updateClassName = (newSize: string) => {
                    const newClasses = existingClasses
                        .split(' ')
                        .filter((className: string) => !className.startsWith('is-size-'))
                        .join(' ');

                    props.setAttributes({
                        className: `${newClasses} ${newSize}`.trim(),
                    });
                };

                return (
                    <wp.element.Fragment>
                        <BlockEdit {...props} />
                        <wp.blockEditor.InspectorControls>
                            <wp.components.PanelBody title="Button Size">
                                <wp.components.SelectControl
                                    label="Select size"
                                    value={selectedSize}
                                    options={buttonSizes.map((size) => ({
                                        value: `is-size-${size.name}`,
                                        label: size.label
                                    }))}
                                    onChange={updateClassName}
                                />
                            </wp.components.PanelBody>
                        </wp.blockEditor.InspectorControls>
                    </wp.element.Fragment>
                );
            };
        }
    );
});
