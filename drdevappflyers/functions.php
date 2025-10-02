<?php 

function drdev_enqueue_assets() {
    wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/output.css', [], '1.0');
    wp_enqueue_script('main-script', get_template_directory_uri() . '/assets/js/main.min.js', [], false, true);
}
add_action('wp_enqueue_scripts', 'drdev_enqueue_assets');