<?php

class VACNav {
    public static $location = 'primary-menu';
    public static $description = 'Menu';

    public static function init() {
        add_action('init', array(__CLASS__, 'register'));
    }

    public static function register() {
        register_nav_menu(self::$location, self::$description);

        if (!wp_get_nav_menu_object(self::$description)) {
            self::setup();
        }
    }

    private static function setup() {
        $menu_id = wp_create_nav_menu(self::$description);
        $locations = get_theme_mod('nav_menu_locations');
        $locations['main-nav'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }

    public static function language() {
        if (!function_exists('pll_the_languages')) {
            return;
        }

        return pll_the_languages(array('raw' => true));
    }
}

VACNav::init();
