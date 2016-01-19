<?php

/*
    Plugin Name:  VAC Collaboration
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

class VACCollaboration extends VACSection {
    public static $post_type = 'vac-collaboration';
    public static $post_label = 'Collaborations';
    public static $post_slug = 'collaboration';
    public static $post_name = 'collaborations';
    public static $post_name_russian = 'sotrudnichestvo';
    public static $archive_page = 'collaborations';
    public static $archive_page_title = 'Collaborations page';
    public static $archive_page_title_russian = 'Сотрудничество страница';
    public static $archive_template = 'collaboration_archive.php';
    public static $menu_link = 'edit.php?post_type=vac-collaboration';
    public static $dashicon = 'dashicons-groups';
    public static $file = __FILE__;
    public static $class = __CLASS__;
    public static $taxonomies = array('vac-year', 'vac-city');
}

VACCollaboration::init();
