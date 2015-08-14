<?php

/*
    Plugin Name:  VAC Exhibition
    Plugin URI:   http://vac.com
    Description:  VAC content type plugin
    Version:      0.0.0
    Author:       Gui Machiavelli
    Author URI:   http://guimachiavelli.com
*/

class VACExhibition {
    public static $post_type = 'vac-exhibition';

    public static function activate() {

    }

    public static function init() {
        add_action('init', array(__CLASS__, 'register_post'));
        add_action('init', array(__CLASS__, 'register_fields'));
    }

    public static function register_post() {
        register_post_type(
            'vac-exhibition',
            array(
                'label' => 'Exhibitions',
                'public' => true,
                'menu_position' => 5,
                'supports' => array('title'),
                'menu_icon' => 'dashicons-format-image',
                'taxonomies' => array('vac-year', 'vac-city')
            )
        );
    }

    public static function register_fields() {
        $main_component = new VACComponent(array(
            'id' => str_replace('-', '_', self::$post_type),
            'post_type' => self::$post_type,
            'position' => 'normal'
        ), array(
            'type' => 'group',
            'fields' => array('slider', 'standfirst', 'text', 'accordion')
        ), array(
            'type' => 'single',
            'fields' => array('aside', 'text')
        ));
        $main_component->register();

        $sidebar_component = new VACComponent(array(
            'id' => str_replace('-', '_', self::$post_type) . '_side',
            'post_type' => self::$post_type,
            'position' => 'side'
        ), array(
            'type' => 'single',
            'fields' => array('featured')
        ));

        $sidebar_component->register();
    }
}

register_activation_hook(__FILE__, array('VACExhibitions', 'activate'));
VACExhibition::init();