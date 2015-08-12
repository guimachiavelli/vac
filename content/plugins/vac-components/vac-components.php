<?php

/*
    Plugin Name:  VAC Components
    Plugin URI:   http://vac.com
    Description:  VAC content blocks. Depends on ACF.
    Version:      0.0.0
    Author:       Gui Machiavelli
    Author URI:   http://guimachiavelli.com
*/

require_once 'acf-fields.php';

class VACComponents {
    public static function init() {
        add_action('init', array(__CLASS__, 'register_components'), 99);
    }

    public static function register_components() {
        $post_types = get_post_types();
        $post_types = array_filter($post_types,
                                    array(__CLASS__, 'filter_vac_post_types'));
        VACComponentsFields::main_component($post_types);

    }

    private static function filter_vac_post_types($post_type) {
        return strpos($post_type, 'vac') !== false;
    }

}

VACComponents::init();
