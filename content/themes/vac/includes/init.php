<?php

	add_action('after_setup_theme', 'vac_remove_default_posts');
	//add_action('after_setup_theme', 'vac_add_pages');

	function vac_remove_default_posts() {
		//remove sample page and hello world post
		wp_delete_post(2);
		wp_delete_post(1);
	}

	function vac_add_page($page_name) {
		$page_exists = get_page_by_title($page_name);
		if ($page_exists) return;

		$page = array(
			'post_title'		=> $page_name,
			'post_content'		=> '',
			'post_status'		=> 'publish',
			'post_author'		=> 1,
			'post_type'			=> 'page'
		);

		wp_insert_post($page);
	}

	function p_add_pages() {
		p_add_page('About');
		p_add_page('Works');
	}


