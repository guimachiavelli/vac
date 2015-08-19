<?php

/*
    Plugin Name:  VAC Section
    Plugin URI:   http://vac.com
    Description:  VAC content type plugin. Depends on VACComponent.
    Version:      0.0.0
    Author:       Gui Machiavelli
    Author URI:   http://guimachiavelli.com
*/

class VACSection {
    public static $post_type;
    public static $post_label;
    public static $post_slug;
    public static $post_name;
    public static $post_name_russian;
    public static $archive_page;
    public static $archive_page_title;
    public static $archive_page_title_russian;
    public static $archive_template;
    public static $menu_link;
    private static $dashicon;
    public static $file;
    public static $class;
    public static $taxonomies = array('vac-year', 'vac-city');

    public static function init() {
        register_activation_hook(static::$file, array(static::$class, 'activate'));
        register_deactivation_hook(static::$file, array(static::$class, 'deactivate'));
        add_action('init', array(static::$class, 'register_post'));
        add_action('init', array(static::$class, 'register_post_fields'));
        add_action('init', array(static::$class, 'register_archive_fields'));
        add_action('admin_menu', array(static::$class, 'add_archive_menu'));
        add_filter('custom_menu_order', array(static::$class, 'menu_order'));
    }

    public static function activate() {
        $english = VACHelpers::add_page(
            static::$archive_page_title,
            static::$post_name,
            static::$archive_template,
            'en'
        );

        $russian = VACHelpers::add_page(
            static::$archive_page_title_russian,
            static::$post_name_russian,
            static::$archive_template,
            'ru'
        );

        VACHelpers::link_translations(array(
            'en' => $english,
            'ru' => $russian
        ));
    }

    public static function deactivate() {
        VACHelpers::delete_page(static::$archive_page_title);
        VACHelpers::delete_page(static::$archive_page_title_russian);
    }

    public static function register_post() {
        register_post_type(
            static::$post_type,
            array(
                'label' => static::$post_label,
                'public' => true,
                'menu_position' => 5,
                'supports' => array('title'),
                'menu_icon' => static::$dashicon,
                'taxonomies' => static::$taxonomies,
                'rewrite' => array(
                    'slug' => static::$post_slug
                )
            )
        );
    }


    public static function add_archive_menu() {
        $page = get_page_by_title(static::$archive_page_title);
        if (!$page) {
            return;
        }

        add_submenu_page(
            static::$menu_link,
            static::$archive_page_title,
            static::$archive_page_title,
            'edit_pages',
            "post.php?post={$page->ID}&action=edit"
        );
    }

    public static function menu_order($menu) {
        global $submenu;

        $new_menu = array();
        $old_menu = $submenu[static::$menu_link];

        if (!isset($old_menu[17])) {
            return;
        }

        $new_menu[5] = $old_menu[5];
        $new_menu[6] = $old_menu[17];
        $new_menu[10] = $old_menu[10];
        $new_menu[15] = $old_menu[15];
        $new_menu[16] = $old_menu[16];

        $submenu[static::$menu_link] = $new_menu;
    }


    public static function register_post_fields() {
        $main_component = new VACComponent(array(
            'id' => str_replace('-', '_', static::$post_type),
            'location' => array('post_type', static::$post_type),
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
        $main_component->register();
    }
}
