<?php
    add_action('init', 'p_project_post');

    class

    //Create the post type
    function p_project_post() {
        $labels = array(
            'name'               => 'Works',
            'singular_name'      => 'Project',
            'menu_name'          => 'Works',
            'name_admin_bar'     => 'Works',
            'add_new'            => 'Add new project',
            'add_new_item'       => 'Add new project',
            'new_item'           => 'New project',
            'edit_item'          => 'Edit project',
            'view_item'          => 'View project',
            'all_items'          => 'All works',
            'search_items'       => 'Search works',
            'parent_item_colon'  => 'Parent project:',
            'not_found'          => 'No project found',
            'not_found_in_trash' => 'No project found in trash'
        );

        register_post_type(
            'project',
            array(
                'labels' => $labels,
                'public' => true,
                'menu_position' => 5,
                'supports' => array('title', 'editor', 'thumbnail'),
				'menu_icon' => 'dashicons-book-alt',
				'rewrite' => array('slug' => 'project', 'with_front' => false)
            )
        );
    }

