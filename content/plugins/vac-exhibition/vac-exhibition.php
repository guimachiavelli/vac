<?php

/*
    Plugin Name:  VAC Exhibition
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

class VACExhibition extends VACSection {
    public static $post_type = 'vac-exhibition';
    public static $post_label = 'Exhibitions';
    public static $post_slug = 'exhibition';
    public static $post_name = 'exhibitions';
    public static $post_name_russian = 'vystavki';
    public static $archive_page = 'exhibitions';
    public static $archive_page_title = 'Exhibitions archive';
    public static $archive_page_title_russian = 'Архив выставок';
    public static $archive_template = 'exhibition_archive.php';
    public static $menu_link = 'edit.php?post_type=vac-exhibition';
    public static $dashicon = 'dashicons-format-image';
    public static $file = __FILE__;
    public static $class = __CLASS__;
    public static $taxonomies = array('vac-year', 'vac-city');
}

VACExhibition::init();
