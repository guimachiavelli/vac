<?php

class VACTinyMCE {

    public static function init() {
        add_filter('tiny_mce_before_init', array(__CLASS__, 'formats'));
        add_filter('mce_buttons', array(__CLASS__, 'buttons'));
        add_filter('mce_buttons_2', array(__CLASS__, 'buttons_2'));
        add_filter('mce_css', array(__CLASS__, 'styles'));
    }

    public static function formats($settings) {
        $settings['keep_styles'] = false;
        $settings['paste_remove_styles'] = true;
        $settings['paste_remove_spans'] = true;
        $style_formats = array(
            array(
                'title' => 'Text',
                'block' => 'p',
            ),
            array(
                'title' => 'Big text',
                'block' => 'p',
                'classes' => 'text__p text__p--big',
            ),
            array(
                'title' => 'Blue text',
                'selector' => 'span, p, h3',
                'classes' => 'text__p text__p--blue'
            ),
            array(
                'title' => 'Heading',
                'block' => 'h3',
                'classes' => 'text__heading'
            ),
        );

        $settings['style_formats'] = json_encode( $style_formats );
        return $settings;
    }

    public static function styles($url) {
        $url = empty($url) ? '' : $url . ',';
        $url .= trailingslashit(TEMPLATE_URL) . 'admin/tinymce-styles.css';
        return $url;
    }

    public static function buttons($buttons) {
        return array(
            'bold',
            'italic',
            'underline',
            'link',
            'unlink',
            'styleselect',
            'pastetext',
            'removeformat',
        );
    }

    public static function buttons_2() {
        return array();
    }
}

VACTinyMCE::init();
