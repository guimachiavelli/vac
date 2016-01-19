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
    public static $archive_page_title = 'Publications page';
    public static $archive_page_title_russian = 'страница публикаций';
    public static $archive_template = 'publication_archive.php';
    public static $menu_link = 'edit.php?post_type=vac-publication';
    public static $dashicon = 'dashicons-book-alt';
    public static $file = __FILE__;
    public static $class = __CLASS__;
    public static $taxonomies = array('vac-year',
                                      'vac-publication_type');


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
                'fields' => array('text', 'featured_posts', 'archive'),
        )));

        $main_component->add_featured_post_excerpt();

        $main_component->register();
    }
}

VACPublication::init();
