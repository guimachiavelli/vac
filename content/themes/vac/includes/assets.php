<?php

add_action('wp_enqueue_scripts', 'vac_enqueue_scripts');
add_action('wp_enqueue_scripts', 'vac_enqueue_styles');

function vac_enqueue_styles() {
    wp_register_style('vac-styles', TEMPLATE_URL . '/assets/build/css/vac-styles.css');
    wp_enqueue_style('vac-styles');
}

function vac_enqueue_scripts() {
    //wp_deregister_script('jquery');

    //wp_register_script('jquery',
        //'http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js',
        //false, false, true);

    wp_register_script('vac-bundle',
        TEMPLATE_URL . '/assets/build/js/vac-bundle.js',
        false, false, true);

    wp_enqueue_script('vac-bundle');
}
