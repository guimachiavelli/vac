<?php

/*
    Plugin Name:  VAC Exhibition
    Plugin URI:   http://vac.com
    Description:  VAC content type plugin
    Version:      0.0.0
    Author:       Gui Machiavelli
    Author URI:   http://guimachiavelli.com
*/

class VACExhibition {
    public static $post_type = 'vac-exhibition';
    public static $post_name = 'exhibitions';
    public static $post_name_russian = 'vystavka';
    public static $archive_page = 'exhibitions';
    public static $archive_page_title = 'Exhibitions Page';
    public static $archive_page_title_russian = 'Vystavka';
    public static $archive_template = 'exhibition_archive.php';
    public static $menu_link = 'edit.php?post_type=vac-exhibition';

    public static function activate() {
        $english = VACHelpers::add_page(
            self::$archive_page_title,
            self::$post_name,
            self::$archive_template,
            'en'
        );

        $russian = VACHelpers::add_page(
            self::$archive_page_title_russian,
            self::$post_name_russian,
            self::$archive_template,
            'ru'
        );

        VACHelpers::link_translations(array(
            'en' => $english,
            'ru' => $russian
        ));
    }

    public static function deactivate() {
        VACHelpers::delete_page(self::$archive_page_title);
        VACHelpers::delete_page(self::$archive_page_title_russian);
    }

    public static function init() {
        register_activation_hook(__FILE__, array(__CLASS__, 'activate'));
        register_deactivation_hook(__FILE__, array(__CLASS__, 'deactivate'));
        add_action('init', array(__CLASS__, 'register_post'));
        add_action('init', array(__CLASS__, 'register_post_fields'));
        add_action('init', array(__CLASS__, 'register_archive_fields'));
        add_action('admin_menu', array(__CLASS__, 'add_archive_menu'));
        add_filter('custom_menu_order', array(__CLASS__, 'exhibition_menu_order'));
    }

    public static function add_archive_menu() {
 		$page = get_page_by_title(self::$archive_page_title);
        if (!$page) {
            return;
        }

        add_submenu_page(
            self::$menu_link,
            'Exhibitions page',
            'Exhibitions page',
            'edit_pages',
            "post.php?post={$page->ID}&action=edit"
        );
    }

    public static function exhibition_menu_order($menu) {
        global $submenu;

        $new_menu = array();
        $old_menu = $submenu[self::$menu_link];

        if (!isset($old_menu[17])) {
            return;
        }

        $new_menu[5] = $old_menu[5];
        $new_menu[6] = $old_menu[17];
        $new_menu[10] = $old_menu[10];
        $new_menu[15] = $old_menu[15];
        $new_menu[16] = $old_menu[16];

        $submenu[self::$menu_link] = $new_menu;
    }

    public static function register_post() {
        register_post_type(
            'vac-exhibition',
            array(
                'label' => 'Exhibitions',
                'public' => true,
                'menu_position' => 5,
                'supports' => array('title'),
                'menu_icon' => 'dashicons-format-image',
                'taxonomies' => array('vac-year', 'vac-city'),
                'rewrite' => array(
                    'slug' => 'exhibition'
                )
            )
        );
    }

    public static function register_post_fields() {
        $main_component = new VACComponent(array(
            'id' => str_replace('-', '_', self::$post_type),
            'location' => array('post_type', self::$post_type),
            'position' => 'normal'
        ), array(
            'left' => array(
                'type' => 'group',
                'fields' => array('slider', 'standfirst', 'text', 'accordion'),
            ),
            'right' => array(
                'type' => 'single',
                'fields' => array('aside'),
            )
        ));
        $main_component->register();
    }

    public static function register_archive_fields() {
        $main_component = new VACComponent(array(
            'id' => str_replace('-', '_', self::$post_type) . '_archive',
            'location' => array('page_template', self::$archive_template),
            'position' => 'normal',
            'post_type' => self::$post_type,
            'name' => self::$post_name
        ), array(
            'single' => array(
                'type' => 'single',
                'fields' => array('text', 'featured_title', 'featured_posts'),
        )));
        $main_component->register();
    }
}

VACExhibition::init();
