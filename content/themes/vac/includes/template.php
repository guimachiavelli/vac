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

    public static function ACF_featured_content($post_id) {
        $fields = get_fields($post_id);
        $fields = self::parsed_ACF($fields);
        $fields = array_values($fields);
        $fields = $fields[0];

        $content = array();

        foreach ($fields as $field) {
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

    public static function clear_query_vars() {
        set_query_var(self::$content_key, null);
    }

    public static function image_src($image_id) {
        $img = wp_get_attachment_image_src($image_id);
        return $img[0];
    }

}
