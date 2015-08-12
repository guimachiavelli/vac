<?php

/*
    Plugin Name:  VAC Publication
    Plugin URI:   http://vac.com
    Description:  VAC content type plugin
    Version:      0.0.0
    Author:       Gui Machiavelli
    Author URI:   http://guimachiavelli.com
*/

class VACPublication {
    public static function init() {
        add_action('init', array(__CLASS__, 'register_post'));
    }

    public static function register_post() {
        register_post_type(
            'publication',
            array(
                'label' => 'Publications',
                'public' => true,
                'menu_position' => 5,
                'supports' => array('title'),
				'menu_icon' => 'dashicons-book-alt'
            )
        );
    }
}
