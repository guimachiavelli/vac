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
    public static $archive_page_title = 'Curatorial Summer Schools archive';
    public static $archive_page_title_russian = 'Летняя школа кураторов';
    public static $archive_template = 'school_archive.php';
    public static $menu_link = 'edit.php?post_type=vac-school';
    public static $dashicon = 'dashicons-store';
    public static $file = __FILE__;
    public static $class = __CLASS__;
    public static $taxonomies = array('vac-year');
}

VACSchool::init();
