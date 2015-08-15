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
    public static $archive_page = 'exhibitions';
    public static $archive_page_title = 'Exhibitions Page';
    public static $archive_template = 'exhibition_archive.php';

    public static function activate() {
        self::add_archive_page();
    }

    public static function deactivate() {
        self::remove_archive_page();
    }

    private static function add_archive_page() {
		$page_exists = get_page_by_title(self::$archive_page);
		if ($page_exists) return;
		$page = array(
			'post_title'		=> self::$archive_page_title,
			'post_content'		=> '',
			'post_status'		=> 'publish',
			'post_author'		=> 1,
            'post_type'			=> 'page',
            'page_template'     => self::$archive_template
		);
		wp_insert_post($page);
    }

    private static function remove_archive_page() {
 		$page = get_page_by_title(self::$archive_page_title);
		if (!$page) return;
        wp_delete_post($page->ID, true);
    }

    public static function init() {
        register_activation_hook(__FILE__, array(__CLASS__, 'activate'));
        register_deactivation_hook(__FILE__, array(__CLASS__, 'deactivate'));
        add_action('init', array(__CLASS__, 'register_post'));
        add_action('init', array(__CLASS__, 'register_post_fields'));
        add_action('init', array(__CLASS__, 'register_archive_fields'));
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
                'taxonomies' => array('vac-year', 'vac-city')
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

        $sidebar_component = new VACComponent(array(
            'id' => str_replace('-', '_', self::$post_type) . '_side',
            'location' => array('post_type', self::$post_type),
            'position' => 'side'
        ), array(
            'side' => array(
                'type' => 'single',
                'fields' => array('featured')
            )
        ));

        $sidebar_component->register();
    }

    public static function register_archive_fields() {
        $main_component = new VACComponent(array(
            'id' => str_replace('-', '_', self::$post_type) . '_archive',
            'location' => array('page_template', self::$archive_template),
            'position' => 'normal'
        ), array(
            'left' => array(
                'type' => 'single',
                'fields' => array('text'),
        )));
        $main_component->register();
    }
}

VACExhibition::init();
