<?php

/*
    Plugin Name:  VAC Grant
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

class VACGrant extends VACSection {
    public static $post_type = 'vac-grant';
    public static $post_label = 'Grants';
    public static $post_slug = 'grant';
    public static $post_name = 'grants';
    public static $post_name_russian = 'stipendiya';
    public static $archive_page = 'grants';
    public static $archive_page_title = 'Grants page';
    public static $archive_page_title_russian = 'Стипендия страница';
    public static $archive_template = 'grant_archive.php';
    public static $menu_link = 'edit.php?post_type=vac-grant';
    public static $dashicon = 'dashicons-awards';
    public static $file = __FILE__;
    public static $class = __CLASS__;
    public static $taxonomies = array('vac-year', 'vac-city');
}

VACGrant::init();
