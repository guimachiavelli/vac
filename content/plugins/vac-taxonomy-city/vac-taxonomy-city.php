<?php

/*
    Plugin Name:  VAC City
    Plugin URI:   http://vac.com
    Description:  VAC custom taxonomy
    Version:      0.0.0
    Author:       Gui Machiavelli
    Author URI:   http://guimachiavelli.com
*/

class VACCity {
    public static function init() {
        add_action('init', array(__CLASS__, 'register_taxonomy'), 1);
    }

    public static function register_taxonomy() {
        register_taxonomy('vac-city', null, array(
            'label' => 'City',
            'hierarchical' => true
        ));
    }
}

VACCity::init();
