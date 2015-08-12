<?php
	require_once ABSPATH . 'wp-admin/includes/plugin.php';

	function setup_plugins() {
		$plugins_dir = WP_CONTENT_DIR . '/plugins/';
		activate_plugin($plugins_dir . '/regenerate-thumbnails/regenerate-thumbnails.php');
		activate_plugin($plugins_dir . '/wp-retina-2x/wp-retina-2x.php');
	}

	add_action('init', 'setup_plugins');
