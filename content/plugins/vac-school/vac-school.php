<?php

/*
    Plugin Name:  VAC School
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

class VACSchool extends VACSection {
    public static $post_type = 'vac-school';
    public static $post_label = 'Curatorial Summer Schools';
    public static $post_slug = 'school';
    public static $post_name = 'schools';
    public static $post_name_russian = 'shkoly';
    public static $archive_page = 'schools';
    public static $archive_page_title = 'Curatorial Summer Schools page';
    public static $archive_page_title_russian = 'Летняя школа кураторов';
    public static $archive_template = 'school_archive.php';
    public static $menu_link = 'edit.php?post_type=vac-school';
    public static $dashicon = 'dashicons-store';
    public static $file = __FILE__;
    public static $class = __CLASS__;
    public static $taxonomies = array('vac-year');

    public static function register_archive_fields() {
        $main_component = new VACComponent(array(
            'id' => str_replace('-', '_', static::$post_type) . '_archive',
            'location' => array('page_template', static::$archive_template),
            'position' => 'normal',
            'post_type' => static::$post_type,
            'name' => static::$post_name
        ), array(
            'single' => array(
                'type' => 'group',
                'fields' => array('text', 'schools', 'talks_and_lectures'),
        )));

        $main_component->register();
    }

    public static function menu_order($menu) {
        global $submenu;

        $new_menu = array();
        $old_menu = $submenu[static::$menu_link];


        $new_menu[5] = $old_menu[5];
        $new_menu[6] = $old_menu[16];
        $new_menu[10] = $old_menu[10];
        $new_menu[15] = $old_menu[15];

        $submenu[static::$menu_link] = $new_menu;
    }


}



VACSchool::init();
