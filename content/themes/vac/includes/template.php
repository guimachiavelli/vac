<?php

class VACTemplate {
    public static $content_key = 'vac_content';
    public static $content_position_key = 'vac_content_position';
    public static $post_type_key = 'vac_post_type';

    public static function parsed_ACF($fields) {
        $parsed = array(
            'hero' => array(),
            'left' => array(),
            'right' => array()
        );

        foreach ($fields as $field_name => $field) {
            $name = explode('_', $field_name);
            $name = $name[count($name) - 1];
            $parsed[$name][str_replace("_{$name}", '', $field_name)] = $field;
        }

        return array_filter($parsed);
    }

    public static function ACF_loop($content, $key = null) {
        if (!is_array($content)) return;
        if ($key && !isset($content[$key])) return;

        $content = $key != null ? $content[$key] : $content;

        set_query_var(self::$content_position_key, $key);

        foreach ($content as $name => $field) {
            if (VACHelpers::has_template('partials/component', $name)):
                set_query_var(self::$content_key, $field);
                get_template_part('partials/component', $name);
                self::clear_query_vars();
            elseif ($name == 'acf_fc_layout' && VACHelpers::has_template('partials/component', $field)):
                set_query_var(self::$content_key, $content);
                get_template_part('partials/component', $field);
                self::clear_query_vars();
                break 1;
            elseif (is_array($field)):
                self::ACF_loop($field);
            elseif ($name == 'acf_fc_layout'):
                continue;
            else:
                echo 'missing template: ' . $name . "\n";
            endif;
        }

        set_query_var(self::$content_position_key, null);
    }

    public static function ACF_featured_content($post_id) {
        $fields = get_fields($post_id);
        $fields = self::parsed_ACF($fields);
        $fields = array_values($fields);
        $fields = $fields[0];


        $content = array(
            'image' => null,
            'standfirst' => null
        );

        if (empty($fields)) return $content;

        foreach ($fields as $field) {
            if (empty($field)) continue;
            foreach ($field as $subfields) {
                foreach ($subfields as $name => $subfield) {
                    if ($name == 'vac_block_image_slider') {
                        $image = $subfield[0];
                        $content['image'] = array(
                            'id' => $image['id'],
                            'caption' => $image['caption'],
                            'alt' => $image['alt']
                        );
                    }

                    if ($name == 'vac_block_standfirst') {
                        $content['standfirst'] = $subfield;
                    }
                }
            }
        }

        return $content;
    }

    public static function ACF_content($wp_query) {
        return $wp_query->query_vars[self::$content_key];
    }

    public static function post_type_from_wp_query($wp_query) {
        return $wp_query->query_vars[self::$post_type_key];
    }

    public static function clear_query_vars() {
        set_query_var(self::$content_key, null);
    }

    public static function image_src($image_id) {
        $img = wp_get_attachment_image_src($image_id, 'large');
        return $img[0];
    }

}
