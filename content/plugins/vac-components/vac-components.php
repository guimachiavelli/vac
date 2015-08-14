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
        $this->fields = $this->assemble($config, $left, $right);
    }

    function register() {
        acf_add_local_field_group($this->fields);
    }

    private function assemble($config, $left, $right) {
        if (!isset($config['id']) || !$left) {
            return false;
        }

        $component = array (
            'key' => "group_{$config['id']}_component",
            'location' => array(array(array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => $config['post_type']
            ))),
            'position' => $config['position'],
            'title' => $config['id'],
            'style' => 'seamless',
            'fields' => array()
        );

        $component['fields'] = $this->add_fields(
            $component['fields'],
            $left,
            $config['id'],
            'left'
        );

        if ($right) {
            array_unshift($component['fields'], $this->left_tab);
            $component['fields'][] = $this->right_tab;

            $component['fields'] = $this->add_fields(
                $component['fields'],
                $right,
                $config['id'],
                'right'
            );
        }

        return $component;
    }

    private function add_fields($component_fields, $fields, $id, $column) {
        if ($fields['type'] == 'group') {
            $fields = $this->assemble_fields($fields, $id, $column);
            $component_fields[] = $fields;
            return $component_fields;
        }

        $modules = get_class_vars(__CLASS__);
        foreach ($fields['fields'] as $field) {
            $component_field = $modules[$field];
            $component_field['name'] = "{$component_field['name']}_{$column}";
            $component_fields[] = $component_field;
        }
        return $component_fields;
    }

    private function assemble_fields($group, $id, $column) {
        $modules = get_class_vars(__CLASS__);


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
                'key' => "layout_{$id}_{$field}_{$index}",
                'name' => "layout_{$field}",
                'label' => ucfirst($field),
                'sub_fields' => array($modules[$field])
            );

            $fields['layouts'][] = $layout;
        }

        return $fields;
    }

    private function has_acf() {
        return function_exists('acf_add_local_field_group');
    }

    private $left_tab = array (
        'key' => 'field_vac_main_component_left_tab',
        'label' => 'Left Column',
        'name' => '',
        'type' => 'tab',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
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
        'name' => 'image_slider',
        'type' => 'gallery',
        'instructions' => 'Click on picture to add caption',
        'preview_size' => 'thumbnail',
        'library' => 'uploadedTo',
    );

    private $standfirst = array(
        'key' => 'field_vac_block_standfirst',
        'label' => '',
        'name' => 'standfirst',
        'type' => 'wysiwyg',
        'toolbar' => 'basic',
        'tabs' => 'visual',
        'media_upload' => 0,
    );

    private $text = array(
        'key' => 'field_vac_block_text',
        'label' => '',
        'name' => 'text',
        'type' => 'wysiwyg',
        'toolbar' => 'full',
        'tabs' => 'visual',
        'media_upload' => 1,
    );

    private $accordion = array(
        'key' => 'field_55cb73dbe1d47',
        'label' => '',
        'name' => 'accordion',
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
                'toolbar' => 'basic',
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

    private $featured = array(
        'key' => 'vac_side_featured',
        'label' => 'Show on front page?',
        'name' => 'featured',
        'type' => 'true_false',
        'instructions' => 'Check this box if content should be visible in archive pages and/or front page',
        'default_value' => 0,
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
                    'toolbar' => 'basic',
                    'media_upload' => 0,
                ),
            )
        );

    private $floating_image = array(
        'key' => 'field_vac_floating_image',
        'label' => 'Floating image',
        'name' => 'floating_image',
        'type' => 'image',
        'return_format' => 'id',
        'preview_size' => 'thumbnail',
        'library' => 'uploadedTo',
    );

    private $side_gallery = array(
        'key' => 'field_vac_block_side_gallery',
        'label' => 'Side gallery',
        'name' => 'side_gallery',
        'type' => 'gallery',
        'instructions' => 'Click on picture to add caption',
        'preview_size' => 'thumbnail',
        'library' => 'uploadedTo',
    );

}
