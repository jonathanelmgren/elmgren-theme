<?php

function elm_notice_acf_field(string $id_prefix = '')
{
    $id_prefix = $id_prefix ? $id_prefix . '_' : '';

    $variant_field_key = 'field_' . $id_prefix . '321hoa989g21';

    return [
        'key' => 'field_' . $id_prefix . '321hoa989g22',
        'label' => 'Elm Notice Settings',
        'name' => $id_prefix . 'elm_notice_settings',
        'type' => 'group',
        'instructions' => 'Configure the Elm Notice options.',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => [
            'width' => '',
            'class' => '',
            'id' => '',
        ],
        'layout' => 'block',
        'sub_fields' => [
            [
                'key' => $variant_field_key,
                'label' => 'Notice Variant',
                'name' => $id_prefix . 'notice_variant',
                'type' => 'select',
                'instructions' => 'Select the variant of the notice.',
                'required' => 0,
                'conditional_logic' => 0,
                'choices' => array_combine(Elm_Notice::VARIANTS, Elm_Notice::VARIANTS),
                'default_value' => 'top-fixed',
            ],
            [
                'key' => 'field_' . $id_prefix . '321hoa989g23',
                'label' => 'Notice Type',
                'name' => $id_prefix . 'notice_type',
                'type' => 'select',
                'instructions' => 'Select the type of the notice.',
                'required' => 0,
                'conditional_logic' => 0,
                'choices' => array_combine(Elm_Notice::STATUSES, Elm_Notice::STATUSES),
                'default_value' => 'success',
            ],
            [
                'key' => 'field_' . $id_prefix . '321hoa989g24',
                'label' => 'Submission Text',
                'name' => $id_prefix . 'submission_text',
                'type' => 'text',
                'instructions' => 'Enter the text to be shown in the notice.',
                'required' => 0,
                'conditional_logic' => 0,
                'default_value' => 'Default text for notice.',
            ],
            [
                'key' => 'field_' . $id_prefix . '321hoa989g25234',
                'label' => 'Target',
                'name' => $id_prefix . 'target',
                'type' => 'text',
                'instructions' => 'Enter the target element for inline notice.',
                'required' => 0,
                'conditional_logic' => [
                    [
                        [
                            'field' => $variant_field_key,
                            'operator' => '==',
                            'value' => 'inline',
                        ],
                    ],
                ],
                'default_value' => '',
            ],
        ],
    ];
}
