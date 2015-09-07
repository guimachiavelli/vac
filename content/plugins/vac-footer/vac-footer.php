<?php

/*
    Plugin Name:  VAC Footer
    Plugin URI:   http://vac.com
    Description:  VAC footer content.
    Version:      0.0.0
    Author:       Gui Machiavelli
    Author URI:   http://guimachiavelli.com
*/


class VACFooter {
    public static $slug = 'footer';
    public static $slug_russian = 'nizhniy';
    public static $template = 'footer-template.php';
    public static $title = 'Footer';
    public static $title_russian = 'нижний колонтитул';

    public static function init() {
        register_activation_hook(__FILE__, array(__CLASS__, 'activate'));
        register_deactivation_hook(__FILE__, array(__CLASS__, 'deactivate'));
        add_action('admin_menu', array(__CLASS__, 'add_to_menu'), 1000);
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
            'dashicons-info',
            '20.99'
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
            'single' => array(
                'type' => 'single',
                'fields' => array('text'),
            )
        ));

        $main_component->register();
    }
}

VACFooter::init();
