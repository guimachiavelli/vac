<?php

/*
    Plugin Name:  VAC Components
    Plugin URI:   http://vac.com
    Description:  VAC content blocks. Depends on ACF.
    Version:      0.0.0
    Author:       Gui Machiavelli
    Author URI:   http://guimachiavelli.com
*/

class VACComponent {
    var $fields;

    function __construct($config, $left, $right = false) {
        //XXX: need this to be hardcoded because of multiple plugin structure
        //     and ACF not correctly showing relationships on search filter
        $post_types = array(
            'vac-event',
            'vac-artist',
            'vac-collaboration',
            'vac-exhibition',
            'vac-grant',
            'vac-research',
            'vac-publication',
            'vac-school'
        );
        $this->featured_posts[1]['sub_fields'][3]['post_type'] = $post_types;
        $this->hero[1]['sub_fields'][4]['post_type'] = $post_types;

        $this->fields = $this->assemble($config, $left, $right);
    }

    function register() {
        acf_add_local_field_group($this->fields);
    }

    private function assemble($config, $columns) {
        if (!isset($config['id']) || !$columns) {
            return false;
        }

        $component = array (
            'key' => "group_{$config['id']}_component",
            'location' => $this->location($config['location']),
            'position' => $config['position'],
            'title' => $config['id'],
            'style' => 'seamless',
            'fields' => array()
        );

        foreach ($columns as $name => $column) {
            if ($name == 'right' && count($columns) >= 2) {
                $component['fields'][] = $this->right_tab;
            }

            if ($name == 'left' && count($columns) >= 2) {
                $component['fields'][] = $this->left_tab;
            }

            if ($name == 'hero') {
                $component['fields'][] = $this->hero_tab;
            }

             $component['fields'] = $this->add_fields(
                $component['fields'],
                $column,
                $config,
                $name
            );
        }

        return $component;
    }

    private function add_fields($component_fields, $fields, $config, $column) {
        $id = $config['id'];

        if ($fields['type'] == 'group') {
            $fields = $this->assemble_fields($fields, $id, $column);
            $component_fields[] = $fields;
            return $component_fields;
        }

        $modules = get_object_vars($this);

        foreach ($fields['fields'] as $field) {
            $component_field = $modules[$field];
            $component_field['name'] = "{$component_field['name']}_{$column}";
            $component_field['key'] = "{$component_field['key']}_{$id}";

            if (isset($component_field['post_type'])) {
                $component_field['post_type'] = array(
                    $config['post_type']
                );
            }

            if (isset($config['name'])) {
                $component_field['label'] = str_replace('posts', $config['name'], $component_field['label']);
            }

            if (isset($config['name']) && isset($component_field['instructions'])) {
                $component_field['instructions'] = str_replace('posts', $config['name'], $component_field['instructions']);
            }

            $component_fields[] = $component_field;
        }
        return $component_fields;
    }

    private function location($location) {
        return array(array(array(
            'param' => $location[0],
            'operator' => '==',
            'value' => $location[1]
        )));
    }

    private function assemble_fields($group, $id, $column) {
        $modules = get_object_vars($this);

        $fields = array(
            'key' => "field_group_{$id}_{$column}",
            'label' => '',
            'name' => "field_group_{$id}_{$column}",
            'type' => 'flexible_content',
            'instructions' => '',
            'button_label' => 'Add Block',
            'layouts' => array()
        );

        foreach ($group['fields'] as $index => $field) {
            $layout = array(
                'key' => "vac_layout_{$id}_{$field}_{$index}",
                'name' => "vac_layout_{$field}",
                'label' => str_replace('_', ' ', ucfirst($field))
            );

            $subfield = $modules[$field];

            if (isset($modules[$field]['key'])) {
                $subfield['key'] .= "_{$id}";
                $layout['sub_fields'] = array($subfield);
            } else {
                $subfield = array_map(array(__CLASS__, 'update_key'),
                                      $subfield,
                                      array_fill(0,
                                                 count($subfield),
                                                 "{$id}_{$index}")
                                    );
                $layout['sub_fields'] = $subfield;
            }

            $fields['layouts'][] = $layout;
        }

        return $fields;
    }

    private function update_key($field, $id) {
        if (!isset($field['key'])) return $field;

        $field['key'] .= "_{$id}";

        return $field;
    }

    private function has_acf() {
        return function_exists('acf_add_local_field_group');
    }

    private $left_tab = array (
        'key' => 'field_vac_main_component_left_tab',
        'label' => 'Left Column',
        'name' => '',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    );

    private $hero_tab = array (
        'key' => 'field_vac_main_component_hero_tab',
        'label' => 'Hero',
        'name' => '',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    );


    private $right_tab = array(
        'key' => 'field_vac_main_component_right_tab',
        'label' => 'Right Column',
        'name' => '',
        'type' => 'tab',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'placement' => 'top',
        'endpoint' => 0,
    );

    private $slider = array(
        'key' => 'field_vac_block_image_slider',
        'label' => 'Images',
        'name' => 'vac_block_image_slider',
        'type' => 'gallery',
        'instructions' => 'Click on picture to add caption',
        'preview_size' => 'thumbnail',
        'library' => 'uploadedTo',
    );

    private $standfirst = array(
        'key' => 'field_vac_block_standfirst',
        'label' => '',
        'name' => 'vac_block_standfirst',
        'type' => 'wysiwyg',
        'toolbar' => 'full',
        'tabs' => 'visual',
        'media_upload' => 0,
    );

    private $text = array(
        'key' => 'field_vac_block_text',
        'label' => '',
        'name' => 'vac_block_text',
        'type' => 'wysiwyg',
        'toolbar' => 'full',
        'tabs' => 'visual',
        'media_upload' => 1,
    );

    private $accordion = array(
        'key' => 'field_55cb73dbe1d47',
        'label' => '',
        'name' => 'vac_block_accordion',
        'type' => 'repeater',
        'instructions' => '',
        'layout' => 'block',
        'button_label' => 'Add accordion item',
        'sub_fields' => array(
            array (
                'key' => 'field_55cb73ebe1d48',
                'label' => 'Title',
                'name' => 'accordion_item_title',
                'type' => 'text',
            ),
            array (
                'key' => 'field_55cb7413e1d49',
                'label' => 'Type',
                'name' => 'accordion_item_type',
                'type' => 'radio',
                'instructions' => '',
                'choices' => array (
                    'text' => 'Text',
                    'image' => 'Image',
                ),
                'default_value' => 'text',
                'layout' => 'horizontal',
            ),
            array (
                'key' => 'field_55cb7544e1d4a',
                'label' => 'Text',
                'name' => 'accordion_item_text',
                'type' => 'wysiwyg',
                'conditional_logic' => array (
                    array (
                        array (
                            'field' => 'field_55cb7413e1d49',
                            'operator' => '==',
                            'value' => 'text',
                        ),
                    ),
                ),
                'tabs' => 'visual',
                'toolbar' => 'full',
                'media_upload' => 0,
            ),
            array (
                'key' => 'field_55cb7570e1d4b',
                'label' => 'Images',
                'name' => 'accordion_item_image',
                'type' => 'gallery',
                'instructions' => '',
                'conditional_logic' => array (
                    array (
                        array (
                            'field' => 'field_55cb7413e1d49',
                            'operator' => '==',
                            'value' => 'image',
                        ),
                    ),
                ),
                'preview_size' => 'thumbnail',
                'library' => 'uploadedTo',
            ),
            array (
                'key' => 'field_55cb7840f1807',
                'label' => 'Open on load?',
                'name' => 'accordion_open',
                'type' => 'true_false',
                'instructions' => 'Check this box if content should be visible by default',
                'default_value' => 0,
            ),
        )
    );

    private $aside = array (
            'key' => 'field_55cb7d3574408',
            'label' => 'Asides',
            'name' => 'vac_block_aside',
            'type' => 'repeater',
            'instructions' => '',
            'layout' => 'block',
            'button_label' => 'Add aside',
            'sub_fields' => array (
                array (
                    'key' => 'field_55cb7d4774409',
                    'label' => 'Aside paragraph number',
                    'name' => 'aside_paragraph_number',
                    'type' => 'number',
                    'instructions' => 'Insert the paragraph number to which the the aside should be aligned',
                    'default_value' => 1,
                    'min' => 1,
                    'step' => 1,
                ),
                array (
                    'key' => 'field_55cb7dc57440a',
                    'label' => 'Aside image',
                    'name' => 'aside_image',
                    'type' => 'image',
                    'return_format' => 'id',
                    'preview_size' => 'thumbnail',
                    'library' => 'uploadedTo',
                ),
                array (
                    'key' => 'field_55cb7deb7440b',
                    'label' => 'Aside text',
                    'name' => 'aside_text',
                    'type' => 'wysiwyg',
                    'tabs' => 'visual',
                    'toolbar' => 'full',
                    'media_upload' => 0,
                ),
            )
        );

    private $hero = array(
        array(
            'key' => 'field_55d1cc70d7bb3',
            'label' => 'Hero title',
            'name' => 'vac_hero_title',
            'type' => 'text',
        ),
        array(
            'key' => 'field_55cb73dbe1d47_hero_posts',
            'label' => '',
            'name' => 'vac_block_hero_posts',
            'type' => 'repeater',
            'instructions' => '',
            'layout' => 'block',
            'button_label' => 'Add hero item',
            'sub_fields' => array(
                array (
                    'key' => 'field_55cb73ebe1d48_vac_hero_title',
                    'label' => 'Title',
                    'name' => 'vac_hero_post_title',
                    'type' => 'text',
                ),
                array (
                    'key' => 'field_55cb73ebe1d48_vac_hero_standfirst',
                    'label' => 'Standfirst',
                    'name' => 'vac_hero_post_standfirst',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_key_vac_hero_excerpt',
                    'label' => 'Excerpt',
                    'name' => 'vac_hero_post_excerpt',
                    'type' => 'textarea',
                ),
                array(
                    'key' => 'field_key_vac_hero_image',
                    'label' => 'Image',
                    'name' => 'vac_hero_post_image',
                    'type' => 'image',
                    'return_format' => 'id',
                    'preview_size' => 'thumbnail',
                    'library' => 'uploadedTo',
                ),
                array(
                    'key' => 'field_key_vac_block_home_hero_post',
                    'label' => 'Link',
                    'name' => 'vac_hero_post_link',
                    'type' => 'relationship',
                    'instructions' => 'Start typing to select posts',
                    'max' => 1,
                    'filters' => array(
                        0 => 'search',
                        1 => 'post_type'
                    ),
                    'return_format' => 'id',
                )
            )
        ),
    );

    private $floating_image = array(
        'key' => 'field_vac_floating_image',
        'label' => 'Floating image',
        'name' => 'vac_block_floating_image',
        'type' => 'image',
        'return_format' => 'id',
        'preview_size' => 'thumbnail',
        'library' => 'uploadedTo',
    );

    private $side_gallery = array(
        array(
            'key' => 'field_55d1cc70d7bb3',
            'label' => 'Side images title',
            'name' => 'vac_side_gallery_title',
            'type' => 'text',
        ),
        array(
            'key' => 'field_vac_block_side_gallery',
            'label' => 'Side images',
            'name' => 'vac_side_gallery',
            'type' => 'gallery',
            'instructions' => 'Click on picture to add caption',
            'preview_size' => 'thumbnail',
            'library' => 'uploadedTo',
        )
    );

    private $archive = array(
        'key' => 'field_vac_archive_title',
        'label' => 'Archive title',
        'name' => 'vac_block_archive',
        'type' => 'text',
        'instructions' => 'This block will print out a list of all posts of this type (so all exhibitions in the exhibition archive, etc).'
    );

    private $featured_posts = array(
        array(
            'key' => 'field_featured_post_title',
            'label' => 'Featured posts title',
            'name' => 'vac_featured_posts_title',
            'type' => 'text',
        ),
        array(
            'key' => 'field_55cb73dbe1d47_featured',
            'label' => '',
            'name' => 'vac_block_featured_posts',
            'type' => 'repeater',
            'instructions' => '',
            'layout' => 'block',
            'button_label' => 'Add featured item',
            'sub_fields' => array(
                array (
                    'key' => 'field_55cb73ebe1d48_vac_featured_title',
                    'label' => 'Title',
                    'name' => 'vac_featured_post_title',
                    'type' => 'text',
                ),
                array (
                    'key' => 'field_55cb73ebe1d48_vac_featured_standfirst',
                    'label' => 'Standfirst',
                    'name' => 'vac_featured_post_standfirst',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_key_vac_featured_image',
                    'label' => 'Image',
                    'name' => 'vac_featured_post_image',
                    'type' => 'image',
                    'return_format' => 'id',
                    'preview_size' => 'thumbnail',
                    'library' => 'uploadedTo',
                ),
                array(
                    'key' => 'field_key_vac_block_home_featured_post',
                    'label' => 'Link',
                    'name' => 'vac_featured_post_link',
                    'type' => 'relationship',
                    'instructions' => 'Start typing to select posts',
                    'max' => 1,
                    'filters' => array(
                        0 => 'search',
                        1 => 'post_type'
                    ),
                    'return_format' => 'id',
                )
            )
        )
    );
}
