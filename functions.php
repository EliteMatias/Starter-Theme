<?php
// KIRKI CUSTOMIZER
locate_template( 'functions/kirki/kirki.php', TRUE, TRUE );
add_filter( 'kirki/config', '_kirki_configuration' );
function _kirki_configuration() {
	return array( 'url_path' => get_stylesheet_directory_uri() . '/functions/kirki/' );
}

// WP CUSTOMIZER
locate_template( "functions/customizer.php", TRUE, TRUE );

// THEME SETUPS, SCRIPTS & STYLES
locate_template( "functions/setup.php", TRUE, TRUE );

// PLUGIN FUNCTIONS & HOOKS
locate_template( "functions/plugins.php", TRUE, TRUE );

// FUNCTION OVERWRITES 
locate_template( "functions/overwrites.php", TRUE, TRUE );

// WOOCOMMERCE CUSTOM FUNCTIONS
locate_template( "functions/woocommerce.php", TRUE, TRUE );

// Remove Shortlink
function remove_redundant_shortlink() {
	remove_action('wp_head', 'wp_shortlink_wp_head', 10);
	remove_action( 'template_redirect', 'wp_shortlink_header', 11);
}
add_filter('after_setup_theme', 'remove_redundant_shortlink');

// Remove Feed
remove_action('wp_head', 'feed_links', 2 );
add_filter('post_comments_feed_link',function () { return null;});

function ccm_disable_feed() {
	wp_die( __( 'No feed available, please visit the homepage!' ) );
}
add_action('do_feed', 'ccm_disable_feed', 1);
add_action('do_feed_rdf', 'ccm_disable_feed', 1);
add_action('do_feed_rss', 'ccm_disable_feed', 1);
add_action('do_feed_rss2', 'ccm_disable_feed', 1);
add_action('do_feed_atom', 'ccm_disable_feed', 1);
add_action('do_feed_rss2_comments', 'ccm_disable_feed', 1);
add_action('do_feed_atom_comments', 'ccm_disable_feed', 1);

// Remove Emoji
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// UPDATES