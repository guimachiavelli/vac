<?php

	class P_Detail_Image {

		public static function init() {
			add_filter('attachment_fields_to_edit', array('P_Detail_Image', 'detail_field'), 10, 2);
			add_filter('attachment_fields_to_save', array('P_Detail_Image', 'detail_field_update'), 4);
			add_action('wp_ajax_save-attachment-compat',  array('P_Detail_Image', 'detail_field_ajax'), 0, 1);
			add_action('admin_head', array('P_Detail_Image', 'disable_fields'));
		}

		public static function disable_fields() {
			echo '	<style type="text/css">
						.attachment-details .setting,
						.attachment-display-settings { display:none !important; }
					</style>';
		}

		public static function detail_field( $fields, $post ) {
			$meta = get_post_meta($post->ID, 'meta_link', true);
			$meta = $meta ? 'checked' : '';
			$field = array();
			$field['detail_image'] = array(
				'label' => 'Detail',
				'input' => 'html',
				'value' => $meta,
				'show_in_edit' => true,
				'html' => "<input type='checkbox' {$meta} value='detail' name='attachments[{$post->ID}]['detail_image']'id='attachments[{$post->ID}][detail_image]' />"
			);
			return $field;
		}

		public static function detail_field_update($attachment){
			global $post;
			update_post_meta($post->ID, 'detail_image', $attachment['attachments'][$post->ID]['detail_image']);
			return $attachment;
		}

		public static function detail_field_ajax() {
			$post_id = $_POST['id'];
			$meta = $_POST['attachments'][$post_id ]['detail_image'];
			update_post_meta($post_id , 'detail_image', $meta);
			clean_post_cache($post_id);
		}
	}

	P_Detail_Image::init();
