<?php

	function p_get_page_link ($slug) {
		$page = get_page_by_path($slug);
		if (!$page) { return ''; }
		echo get_page_link($page->ID);
	}
