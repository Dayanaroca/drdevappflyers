<?php
if (!defined('ABSPATH')) exit;

function drdevcustomlanguage_load_textdomain() {
    load_theme_textdomain('drdevflyers', WP_LANG_DIR . '/wpml' );
	load_theme_textdomain('drdevflyers', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'drdevcustomlanguage_load_textdomain' );