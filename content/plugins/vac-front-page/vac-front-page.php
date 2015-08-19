<?php

/*
    Plugin Name:  VAC Front page
    Plugin URI:   http://vac.com
    Description:  VAC content type plugin. Depends on VACComponent.
    Version:      0.0.0
    Author:       Gui Machiavelli
    Author URI:   http://guimachiavelli.com
*/

class VACFrontPage {
    public static $slug = 'front-page';
    public static $slug_russian = 'stranitsa';
    public static $template = 'front-page-template.php';
    public static $title = 'Front page';
    public static $title_russian = 'титульная страница';

    public static function init() {
        register_activation_hook(__FILE__, array(__CLASS__, 'activate'));
        register_deactivation_hook(__FILE__, array(__CLASS__, 'deactivate'));
        add_action('admin_init', array(__CLASS__, 'add_to_menu'));
        add_action('admin_init', array(__CLASS__, 'set_front_page'));
        add_action('init', array(__CLASS__, 'register_fields'));
    }

    public static function activate() {
        $english = VACHelpers::add_page(
            self::$title,
            self::$slug,
            self::$template,
            'en'
        );

        $russian = VACHelpers::add_page(
            self::$title_russian,
            self::$slug_russian,
            self::$template,
            'ru'
        );

        VACHelpers::link_translations(array(
            'en' => $english,
            'ru' => $russian
        ));
    }

    public static function set_front_page() {
        $type_front = get_option('show_on_front');
        $current_front = get_option('page_on_front');
        $page = get_page_by_title(self::$title);

        if ($type_front != 'page') {
            update_option('show_on_front', 'page');
        }

        if ($current_front != $page->ID) {
            update_option('page_on_front', $page->ID);
        }
    }

    public static function deactivate() {
        VACHelpers::delete_page(self::$title);
        VACHelpers::delete_page(self::$title_russian);
    }

    public static function add_to_menu() {
        $page = get_page_by_title(self::$title);
        if (!$page) return;

        add_menu_page(
            self::$title,
            self::$title,
            'edit_pages',
            "post.php?post={$page->ID}&action=edit",
            null,
            'dashicons-welcome-widgets-menus',
            '4'
        );
    }

    public static function register_fields() {
        $main_component = new VACComponent(array(
            'id' => self::$slug,
            'location' => array('page_template', self::$template),
            'position' => 'normal',
            'post_type' => self::$slug,
            'name' => self::$slug
        ), array(
            'left' => array(
                'type' => 'group',
                'fields' => array('hero', 'featured_posts'),
            ),
            'right' => array(
                'type' => 'group',
                'fields' => array('featured_posts',
                                  'floating_image',
                                  'side_gallery'),
            )
        ));

        $main_component->register();
    }
}

VACFrontPage::init();
