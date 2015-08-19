<?php

    class VACSettings {
        public static function init() {
            add_theme_support('post-thumbnails');

            // remove admin bar
            add_filter('show_admin_bar', '__return_false');

            //remove links and set images to full size
            add_action('after_setup_theme', array(__CLASS__, 'post_image_defaults'));

            //remove categories and tags
            add_action('init', array(__CLASS__, 'remove_taxonomies'));
            add_action('admin_init', array(__CLASS__, 'remove_default_fields'));

            //remove menu cruft
            add_action('admin_menu', array(__CLASS__, 'remove_menus'));
            add_action('admin_head', array(__CLASS__, 'remove_collapse'));
            add_action('init', array(__CLASS__, 'tiny_mce_full_width'));

            // remove wp emoji stuff
            remove_action('wp_head', 'print_emoji_detection_script', 7);
            remove_action('wp_print_styles', 'print_emoji_styles');

            //remove cruft from head
            remove_action('wp_head', 'wp_generator');
            remove_action('wp_head', 'wlwmanifest_link');
            remove_action('wp_head', 'rel_canonical');
            remove_action('wp_head', 'wp_shortlink_wp_head');
            remove_action('wp_head', 'rsd_link');
        }

        public static function post_image_defaults() {
            update_option('image_default_link_type', 'none');
            update_option('image_default_size', 'large');
            update_option('large_size_w', 1400);
            update_option('large_size_h', 0);
        }

        public static function remove_taxonomies(){
            register_taxonomy('post_tag', array());
            register_taxonomy('category', array());
        }

        public static function remove_menus() {
            remove_menu_page('edit.php');
            remove_menu_page('edit-comments.php');
            remove_menu_page('edit.php?post_type=page');
            remove_menu_page('upload.php');
            remove_menu_page('index.php');
            if (self::is_admin_user()) return;
            remove_menu_page('profile.php');
            remove_menu_page('tools.php');
            remove_menu_page('themes.php');
            remove_menu_page('plugins.php');
            remove_menu_page('users.php');
            remove_menu_page('options-general.php');
        }

        public static function remove_default_fields() {
            remove_post_type_support('page', 'editor');
            remove_post_type_support('page', 'thumbnail');
            remove_post_type_support('page', 'page-attributes');
        }

        public static function remove_collapse() {
            echo '<style>#collapse-menu { display: none; }</style>';
        }

        public static function is_admin_user() {
            $user = wp_get_current_user();
            return in_array('administrator', $user->roles);
        }

        public static function tiny_mce_full_width() {
            add_editor_style('css/tiny-mce.css');
        }
    }

    VACSettings::init();
