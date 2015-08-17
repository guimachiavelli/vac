<?php

class VACHelpers {
    public static function get_page_link($slug) {
        $page = get_page_by_path($slug);
        if (!$page) { return ''; }
        echo get_page_link($page->ID);
    }

    public static function has_template($slug, $name) {
        if (locate_template(array("{$slug}-{$name}.php")) == '') {
            return false;
        }

        return true;
    }

    public static function add_page($title, $slug, $template, $language) {
		$page_exists = get_page_by_title($title);

		if ($page_exists) return;

		$page = array(
			'post_title'		=> $title,
            'post_name'         => $slug,
			'post_content'		=> '',
			'post_status'		=> 'publish',
			'post_author'		=> 1,
            'post_type'			=> 'page',
            'page_template'     => $template,
            'lang'              => $language
		);

        $post_id = wp_insert_post($page);

        if (function_exists('pll_set_post_language')) {
            pll_set_post_language($post_id, $language);
        }

        return $post_id;
    }

    public static function link_translations($posts) {
        if (!function_exists('pll_save_post_translations')) {
            return;
        }

        pll_save_post_translations($posts);
    }

    public static function delete_page($page_title) {
 		$page = get_page_by_title($page_title);
		if (!$page) return;
        wp_delete_post($page->ID, true);
    }

}
