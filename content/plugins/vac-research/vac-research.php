<?php

/*
    Plugin Name:  VAC Research
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

class VACResearch extends VACSection {
    public static $post_type = 'vac-research';
    public static $post_label = 'Research';
    public static $post_slug = 'research';
    public static $post_name = 'researches';
    public static $post_name_russian = 'issledovaniya';
    public static $archive_page = 'researches';
    public static $archive_page_title = 'Research page';
    public static $archive_page_title_russian = 'Исследования страница';
    public static $archive_template = 'research_archive.php';
    public static $menu_link = 'edit.php?post_type=vac-research';
    public static $dashicon = 'dashicons-welcome-learn-more';
    public static $file = __FILE__;
    public static $class = __CLASS__;
}

VACResearch::init();
