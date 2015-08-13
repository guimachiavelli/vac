<?php

/*
    Plugin Name:  VAC Publication Type
    Plugin URI:   http://vac.com
    Description:  VAC custom taxonomy
    Version:      0.0.0
    Author:       Gui Machiavelli
    Author URI:   http://guimachiavelli.com
*/

class VACPublicationType {
    public static function init() {
        add_action('init', array(__CLASS__, 'register_taxonomy'), 1);
    }

    public static function register_taxonomy() {
        register_taxonomy('vac-publication_type', null, array(
            'label' => 'Publication Type',
            'hierarchical' => true
        ));
    }
}

VACPublicationType::init();
