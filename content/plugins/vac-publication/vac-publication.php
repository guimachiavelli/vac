<?php

/*
    Plugin Name:  VAC Publication
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

class VACPublication extends VACSection {
    public static $post_type = 'vac-publication';
    public static $post_label = 'Publications';
    public static $post_slug = 'publication';
    public static $post_name = 'publications';
    public static $post_name_russian = 'publikatsiy';
    public static $archive_page = 'publications';
    public static $archive_page_title = 'Publications archive';
    public static $archive_page_title_russian = 'архив публикаций';
    public static $archive_template = 'publication_archive.php';
    public static $menu_link = 'edit.php?post_type=vac-publication';
    public static $dashicon = 'dashicons-book-alt';
    public static $file = __FILE__;
    public static $class = __CLASS__;
    public static $taxonomies = array('vac-year',
                                      'vac-city',
                                      'vac-publication_type');


    public static function menu_order() {
        global $submenu;

        $new_menu = array();
        $old_menu = $submenu[static::$menu_link];


        if (!isset($old_menu[18])) {
            return;
        }

        $new_menu[5] = $old_menu[5];
        $new_menu[6] = $old_menu[18];
        $new_menu[10] = $old_menu[10];
        $new_menu[15] = $old_menu[15];
        $new_menu[16] = $old_menu[16];
        $new_menu[17] = $old_menu[17];

        $submenu[static::$menu_link] = $new_menu;
    }
}

VACPublication::init();
