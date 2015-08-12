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
    public static function activate() {

    }

    public static function init() {
        add_action('init', array(__CLASS__, 'register_post'));
    }

    public static function register_post() {
        register_post_type(
            'vac-exhibition',
            array(
                'label' => 'Exhibitions',
                'public' => true,
                'menu_position' => 5,
                'supports' => array('title'),
				'menu_icon' => 'dashicons-format-image'
            )
        );
    }
}

register_activation_hook(__FILE__, array('VACExhibitions', 'activate'));
VACExhibition::init();
