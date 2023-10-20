<?php

if (function_exists('acf_add_local_field_group')) :

    acf_add_local_field_group(array(
        'key' => 'group_seo_settings',
        'title' => 'SEO Settings',
        'fields' => array(
            array(
                'key' => 'field_seo_meta_title',
                'label' => 'Meta Title',
                'name' => 'meta_title',
                'type' => 'text',
                'instructions' => 'Enter the meta title for this page. Limit to 60 characters.',
                'required' => 0,
                'maxlength' => 60,
            ),
            array(
                'key' => 'field_seo_meta_description',
                'label' => 'Meta Description',
                'name' => 'meta_description',
                'type' => 'textarea',
                'instructions' => 'Enter the meta description for this page. Limit to 160 characters.',
                'required' => 0,
                'maxlength' => 160,
            ),
            array(
                'key' => 'field_seo_canonical_url',
                'label' => 'Canonical URL',
                'name' => 'canonical_url',
                'type' => 'url',
                'instructions' => 'Enter the canonical URL for this page.',
                'required' => 0,
            ),
            array(
                'key' => 'field_seo_robots_meta',
                'label' => 'Robots Meta',
                'name' => 'robots_meta',
                'type' => 'select',
                'instructions' => 'Choose how search engines should treat this page.',
                'required' => 0,
                'choices' => array(
                    'index, follow' => 'Index, Follow',
                    'noindex, follow' => 'Noindex, Follow',
                    'index, nofollow' => 'Index, Nofollow',
                    'noindex, nofollow' => 'Noindex, Nofollow',
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                ),
            ),
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ),
            ),
        ),
    ));

endif;
