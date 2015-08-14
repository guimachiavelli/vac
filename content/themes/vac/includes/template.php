<?php

class VACTemplate {
    public static $content_key = 'vac_content';

    public static function parsed_ACF($fields) {
        $parsed = array(
            'left' => array(),
            'right' => array()
        );

        foreach ($fields as $field_name => $field) {
            $name = explode('_', $field_name);
            $name = $name[count($name) - 1];
            $parsed[$name][str_replace("_{$name}", '', $field_name)] = $field;
        }

        return $parsed;
    }

    public static function ACF_loop($content) {
        foreach ($content as $name => $field) {
            if (VACHelpers::has_template('partials/component', $name)):
                set_query_var(self::$content_key, $field);
                get_template_part('partials/component', $name);
                self::clear_query_vars();
            elseif (is_array($field)):
                self::ACF_loop($field);
            elseif ($name == 'acf_fc_layout'):
                continue;
            else:
                echo 'missing template: ' . $name . "\n";
            endif;
        }
    }

    public static function ACF_content($wp_query) {
        return $wp_query->query_vars[self::$content_key];
    }

    private static function clear_query_vars() {
        set_query_var(self::$content_key, null);
    }

    public static function image_src($image_id) {
        $img = wp_get_attachment_image_src($image_id);
        return $img[0];
    }

}
