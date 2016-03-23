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

    public static function featured_image($post_id) {
        $fields = get_fields($post_id);
        $fields = self::parsed_ACF($fields);

        if (!isset($fields['hero'])) return null;
        $field = $fields['hero'];

        if (!isset($field['vac_block_image_slider'][0])) return null;

        return $field['vac_block_image_slider'][0]['id'];
    }

    public static function featured_title($post_id) {
        return get_the_title($post_id);
    }

    public static function featured_excerpt($post_id) {
        $fields = get_fields($post_id);
        $fields = self::parsed_ACF($fields);

        if (!isset($fields['vac_block_standfirst'])) return '';

        return $field['vac_block_standfirst'];
    }

    public static function ACF_featured_content($post_id) {
        $fields = get_fields($post_id);
        $fields = self::parsed_ACF($fields);

        $content = array(
            'image' => null,
            'standfirst' => null
        );

        if (!isset($fields['left'])) {
            return $content;
        }

        $fields = $fields['left'];

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

    public static function image($image_id) {
        return wp_get_attachment_image($image_id, 'large');
    }

    public static function image_metadata($image_id) {
        $attachment = get_post($image_id);
        return array(
            'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
            'caption' => $attachment->post_excerpt,
            'description' => $attachment->post_content,
            'href' => get_permalink( $attachment->ID ),
            'src' => $attachment->guid,
            'title' => $attachment->post_title
        );
    }

    public static function image_caption($image_id) {
        $metadata = self::image_metadata($image_id);
        if (!isset($metadata['caption'])) return '';

        return $metadata['caption'];
    }

    public static function field_toggle($value) {
        return $value == true ? 'true' : 'false';
    }

    public static function page_slug($post, $wp_query) {
        if (isset($post->post_name)) {
            return $post->name;
        }

        if (isset($wp_query->post->post_name)) {
            return $wp_query->post->post_name;
        }

        return '';
    }

    public static function taxonomies_from_post_type($post_type) {
        $taxonomies = get_object_taxonomies($post_type);
        return array_filter($taxonomies, array(__CLASS__, 'filter_vac_taxonomy'));
    }

    public static function terms_from_post_type($post_type) {
        $taxonomies = self::taxonomies_from_post_type($post_type);
        $terms = get_terms($taxonomies, 'hide_empty=0');
        $parsed_terms = array();

        foreach ($terms as $term) {
            $taxonomy = $term->taxonomy;
            if (!isset($parsed_terms[$taxonomy])) {
                $parsed_terms[$taxonomy] = array();
            }

            $parsed_terms[$taxonomy][] = array($term->name, $term->slug);
        }

        if (isset($parsed_terms['vac-year'])) {
            rsort($parsed_terms['vac-year']);
        }

        ksort($parsed_terms);

        return $parsed_terms;
    }

    public static function post_terms($post_id) {
        $post = get_post($post_id);
        $post_type = $post->post_type;
        $taxonomies = self::taxonomies_from_post_type($post_type);

        $out = array();
        foreach ($taxonomies as $taxonomy):
            $terms = get_the_terms($post->ID, $taxonomy);

            if ( !empty( $terms ) ) {
              foreach ( $terms as $term ) {
                $out[] = $term->slug;
              }
            }
        endforeach;

        return implode(', ', $out);
    }

    private static function filter_vac_taxonomy($taxonomy) {
        return strpos($taxonomy, 'vac') !== false;
    }

}
