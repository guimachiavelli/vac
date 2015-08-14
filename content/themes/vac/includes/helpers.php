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
}
