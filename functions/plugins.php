<?php
// ACF PLUGIN HOOKS & FUNCTIONS
/* if ( class_exists( 'acf' ) ) { 
	// OPTIONS PAGE
	acf_add_options_page( array(
        'page_title' => 'General Settings',
        'menu_title' => 'Theme Options',
        'menu_slug'  => 'theme-general-settings',
        'capability' => 'edit_posts',
        'redirect'   => false,
        'icon_url'   => 'dashicons-admin-site'
    ) );

   	// GOOGLE MAP INIT FOR ACF PRO
   	if ( get_field( "google_map_api_key", "option" ) ) {
		add_action('acf/init', function(){
			if( get_theme_mod( "google_api_map_key" ) ){
				acf_update_setting( "google_api_key", get_theme_mod( "google_map_key" ) );
			}
		} );
   	}

   	// ACF INPUT READONLY & DISABLE OPTIONS
   	add_action( 'acf/render_field_settings/type=text', function( $field ){
   		acf_render_field_setting( $field, array(
	        'label'         => __( 'Read Only?', 'acf' ),
	        'instructions'  => '',
	        'type'          => 'radio',
	        'name'          => 'readonly',
	        'default_value' => 0,
	        'layout'  		=>  'horizontal',
	        'choices'       => array(
	                1 => __( "Yes", 'acf' ),
	                0 => __( "No", 'acf' ),
	            ),
	    ) );
	    acf_render_field_setting( $field, array(
	        'label'         => __( 'Disabled?', 'acf' ),
	        'instructions'  => '',
	        'type'          => 'radio',
	        'name'          => 'disabled',
	        'default_value' => 0,
	        'layout'  		=>  'horizontal',
	        'choices'       => array(
	                1 => __( "Yes", 'acf' ),
	                0 => __( "No", 'acf' ),
	            ),
	    ) );
   	} );
} */

// GRAVITY FORMS PLUGIN HOOKS & FUNCTIONS
// GFORMS TAB INDEX FUNCTION
add_filter( 'gform_tabindex', '__return_false' );

// DISABLE AUTO SCROLLING UPON SUBMISSION OF GRAVITY FORM
add_filter( 'gform_confirmation_anchor', '__return_false' );

// GRAVITY FORMS ASYNC ISSUE FIX
add_filter( 'gform_cdata_open', function( $content = "" ) {
	$content = 'document.addEventListener( "DOMContentLoaded", function() { ';
	return $content;
} );

add_filter( 'gform_cdata_close', function( $content = "" ) {
	$content = ' }, false );';
	return $content;
} );

add_filter( 'gform_confirmation', function( $confirmation, $form, $entry, $ajax ) {
	if ( $ajax && $form['confirmation']['type'] == 'page' ) {
		$confirmation = "<script>function gformRedirect(){document.location.href='" . get_permalink($form['confirmation']['pageId']) . "';}</script>";
	} elseif ( $ajax && $form['confirmation']['type'] == 'redirect' ) {
		$confirmation = "<script>function gformRedirect(){document.location.href='" . $form['confirmation']['url'] . "';}</script>";
	}
	return $confirmation;
}, 10, 4);

// FORCE GFORM SCRIPTS TO THE FOOTER
add_filter( 'gform_init_scripts_footer', '__return_true' );

// CHANGE LOADER IMAGE
add_filter( 'gform_ajax_spinner_url', 'spinner_url', 10, 2 );
function spinner_url( $image_src, $form ) {
	$gformSpinner = get_theme_mod( 'gform_spinner' );
	if ( $gformSpinner ) {
		return $gformSpinner['url'];
	}
}