<?php
    wp_nav_menu(array(
        'theme_location' => VACNav::$location,
        'container' => 'nav',
        'container_class' => 'header-menu',
        'menu_class' => 'header-menu-list',
        'container_id' => 'header-menu',
    ));
?>
