<?php

	add_action('after_setup_theme', 'vac_remove_default_posts');
	//add_action('after_setup_theme', 'vac_add_pages');

	function vac_remove_default_posts() {
		//remove sample page and hello world post
		wp_delete_post(2);
		wp_delete_post(1);
	}
