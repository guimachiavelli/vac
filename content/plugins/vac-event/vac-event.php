<?php

/*
    Plugin Name:  VAC Event
    Plugin URI:   http://vac.com
    Description:  VAC content type plugin. Depends on VACComponent.
    Version:      0.0.0
    Author:       Gui Machiavelli
    Author URI:   http://guimachiavelli.com
*/

if (!class_exists('VACSection')) {
    $section_class = __FILE__;
    $section_class = dirname($section_class);
    $section_class = dirname($section_class);
    $section_class .= '/vac-section/vac-section.php';
    require_once($section_class);
}

class VACEvent extends VACSection {
    public static $post_type = 'vac-event';
    public static $post_label = 'Events';
    public static $post_slug = 'event';
    public static $post_name = 'events';
    public static $dashicon = 'dashicons-calendar-alt';
    public static $taxonomies = array('vac-year', 'vac-city');
    public static $file = __FILE__;
    public static $class = __CLASS__;

    public static function init() {
        register_activation_hook(static::$file, array(static::$class, 'activate'));
        register_deactivation_hook(static::$file, array(static::$class, 'deactivate'));
        add_action('init', array(static::$class, 'register_post'));
        add_action('init', array(static::$class, 'register_post_fields'));
    }

    public static function activate() {}

    public static function deactivate() {}
}

VACEvent::init();
