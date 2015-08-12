<?php

class VACComponentsFields {

    private static function has_acf() {
        return function_exists('acf_add_local_field_group');
    }

    public static function main_component($post_types) {
        if (!self::has_acf()) {
            return;
        }

        acf_add_local_field_group(array (
            'key' => 'group_vac_main_component',
            'title' => 'Content',
            'fields' => array (
                self::$left_tab,
                array (
                    'key' => 'field_vac_main_component_left_column',
                    'label' => '',
                    'name' => 'vac_main_component_left_column',
                    'type' => 'flexible_content',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'button_label' => 'Add Block',
                    'min' => '',
                    'max' => '',
                    'layouts' => array (
                        array(
                            'key' => 'vac_main_component_block_images',
                            'name' => 'vac_block_images',
                            'label' => 'Image block',
                            'sub_fields' => array (
                                self::$slider
                            )
                        ),
                        array(
                            'key' => 'vac_main_component_standfirst',
                            'name' => 'vac_block_standfirst',
                            'label' => 'Standfirst',
                            'sub_fields' => array (
                                self::$standfirst
                            )
                        ),
                        array(
                            'key' => 'vac_main_component_text',
                            'name' => 'vac_block_text',
                            'label' => 'Text block',
                            'sub_fields' => array (
                                self::$text
                            )
                        ),
                        array(
                            'key' => 'vac_main_component_accordion',
                            'name' => 'vac_block_accordion',
                            'label' => 'Accordion block',
                            'sub_fields' => array (
                                self::$accordion
                            )
                        )
                    ),
                ),
                self::$right_tab,
                self::$aside
            ),
            'location' => array_values(
                array_map(array(__CLASS__, 'locations'), $post_types)
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'seamless',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => false,
        ));
    }

    private static function locations($post_type) {
        return array(array(
            'param' => 'post_type',
            'operator' => '==',
            'value' => $post_type
        ));
    }

    private static $left_tab = array (
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

    private static $right_tab = array(
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

    private static $slider = array (
        'key' => 'field_vac_block_image_slider',
        'label' => 'Images',
        'name' => 'image_slider',
        'type' => 'gallery',
        'instructions' => 'Click on picture to add caption',
        'preview_size' => 'thumbnail',
        'library' => 'uploadedTo',
    );

    private static $standfirst = array(
        'key' => 'field_vac_block_standfirst',
        'label' => '',
        'name' => 'standfirst',
        'type' => 'wysiwyg',
        'toolbar' => 'basic',
        'tabs' => 'visual',
        'media_upload' => 0,
    );

    private static $text = array(
        'key' => 'field_vac_block_text',
        'label' => '',
        'name' => 'text',
        'type' => 'wysiwyg',
        'toolbar' => 'full',
        'tabs' => 'visual',
        'media_upload' => 1,
    );

    private static $accordion = array(
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
        ),
    );

    private static $aside = array (
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
            ),
        );



}


