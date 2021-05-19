<?php

if ( class_exists( 'Kirki' ) ) {

	// REMOVE DEFAULT PANEL SECTIONS ON WP CUSTOMIZER
	add_action( 'customize_register', '_wp_theme_settings' );
	function _wp_theme_settings( $wp_customize ) {
		// remove default customizer
		$wp_customize->remove_section('static_front_page');
		$wp_customize->remove_section('custom_css');
		$wp_customize->remove_panel('widgets');
	}

	// ====================================================================
	// THEME OPTIONS PANEL
	Kirki::add_panel( 'theme_options', array(
		'priority'    => 10,
		'title'       => esc_html__( 'Theme Options', 'kirki' ),
		'description' => esc_html__( 'Contains General Settings of the site.', 'kirki' ),
	) );

	// ====================================================================
	// GENERAL SETTINGS SECTION
	Kirki::add_section( 'general_settings_section', array(
		'title'    => esc_html__( 'General Settings', 'kirki' ),
		'panel'    => 'theme_options',
		'priority' => 1,
	) );

		// FIELDS INSIDE GENERAL SETTINGS
		Kirki::add_field( 'ccm_site_logo', [
			'type'        => 'image',
			'settings'    => 'site_logo',
			'label'       => esc_html__( 'Site Logo', 'kirki' ),
			'description' => esc_html__( 'General Logo of the site', 'kirki' ),
			'section'     => 'general_settings_section',
			'default'     => '',
			'priority'    => 1,
			'choices'     => [
				'save_as' => 'array',
			]
		] );

		Kirki::add_field( 'ccm_enable_site_search', [
			'type'        => 'switch',
			'settings'    => 'enable_site_search',
			'label'       => esc_html__( 'Enable Site Search Form', 'kirki' ),
			'section'     => 'general_settings_section',
			'default'     => '1',
			'priority'    => 1,
			'choices'     => [
				'on'  => esc_html__( 'Enable', 'kirki' ),
				'off' => esc_html__( 'Disable', 'kirki' ),
			],
		] );

		Kirki::add_field( 'ccm_email', [
			'type'     => 'email',
			'settings' => 'site_email',
			'label'    => esc_html__( 'Email Address', 'kirki' ),
			'section'  => 'general_settings_section',
			'priority' => 2,
		] );

		Kirki::add_field( 'ccm_site_number', [
			'type'     => 'text',
			'settings' => 'site_number',
			'label'    => esc_html__( 'Site Number', 'kirki' ),
			'section'  => 'general_settings_section',
			'priority' => 3,
		] );

		Kirki::add_field( 'site_location', [
			'type'     => 'text',
			'settings' => 'site_location',
			'label'    => esc_html__( 'Site Location', 'kirki' ),
			'section'  => 'general_settings_section',
			'priority' => 4,
		] );

		Kirki::add_field( 'ccm_copyright', [
			'type'     => 'text',
			'settings' => 'copyright',
			'label'    => esc_html__( 'Copyright Text', 'kirki' ),
			'section'  => 'general_settings_section',
			'priority' => 5,
		] );

		// SOCIAL MEDIA REPEATER
		Kirki::add_field( 'global_social_media', [
			'type'        => 'repeater',
			'label'       => esc_html__( 'Social Media Accounts', 'kirki' ),
			'section'     => 'general_settings_section',
			'priority'    => 6,
			'row_label' => [
				'type'  => 'text',
				'value' => esc_html__( 'Account', 'kirki' ),
			],
			'button_label' => esc_html__('Add an account', 'kirki' ),
			'settings'     => 'global_social_media',
			'fields' => [
				'account' => array(
					'type'    => 'select',
					'choices' => array(
						''               => 'Select a platform',
						'fa-facebook-f'  => 'Facebook',
						'fa-twitter'  => 'Twitter',
						'fa-instagram'  => 'Instagram',
						'fa-youtube'     => 'Youtube',
						'fa-linkedin-in' => 'Linkedin',
					),
					'default' => '',
				),

				'account_url'  => [
					'type'        => 'text',
					'label'       => esc_html__( 'URL', 'kirki' ),
					'description' => esc_html__( '', 'kirki' ),
					'default'     => '',
				],
			]
		] );

	// ====================================================================
	// WP LOGIN SECTION
	Kirki::add_section( 'login_section', array(
		'title'    => esc_html__( 'WP Login Settings', 'kirki' ),
		'panel'    => 'theme_options',
		'priority' => 20,
	) );

		// FIELDS INSIDE WP LOGIN SECTION SETTINGS
		Kirki::add_field( 'ccm_wp_login_bg_color', [
			'type'     => 'color',
			'settings' => 'wp_login_bg_color',
			'label'    => __( 'WP Login Background Color (hex-only)', 'kirki' ),
			'section'  => 'login_section',
			'default'  => '#fff',
		] );

		Kirki::add_field( 'ccm_wp_login_box_bg_color', [
			'type'     => 'color',
			'settings' => 'wp_login_box_bg_color',
			'label'    => __( 'WP Login Box Color (hex-only)', 'kirki' ),
			'section'  => 'login_section',
			'default'  => '#fff',
		] );

		Kirki::add_field( 'ccm_wp_login_button_bg_color', [
			'type'     => 'color',
			'settings' => 'wp_login_button_bg_color',
			'label'    => __( 'WP Login Button Color (hex-only)', 'kirki' ),
			'section'  => 'login_section',
			'default'  => '#fff',
		] );

		Kirki::add_field( 'ccm_wp_login_button_text_color', [
			'type'     => 'color',
			'settings' => 'wp_login_button_text_color',
			'label'    => __( 'WP Login Button Text Color (hex-only)', 'kirki' ),
			'section'  => 'login_section',
			'default'  => '#fff',
		] );


	// ====================================================================
	// 404 PAGE SETTINGS SECTION
	Kirki::add_section( 'error_page_settings', array(
		'title'    => esc_html__( '404 & Thank You Settings', 'kirki' ),
		'panel'    => 'theme_options',
		'priority' => 2,
	) );
		// THANK YOU PAGE BACKGROUND COLOR
		Kirki::add_field( 'ccm_thankyou_bg_color', [
			'type'        => 'color',
			'settings'    => 'thankyou_bg_color',
			'label'       => __( 'Thank You Background Color', 'kirki' ),
			'description' => '',
			'section'     => 'error_page_settings',
			'default'     => '#f06060',
		] );

		// 404 PAGE BACKGROUND COLOR
		Kirki::add_field( 'ccm_error_page_bg_color', [
			'type'        => 'color',
			'settings'    => 'error_page_bg_color',
			'label'       => __( '404 Page Background Color', 'kirki' ),
			'description' => '',
			'section'     => 'error_page_settings',
			'default'     => '#f06060',
		] );

		// FIELD INSIDE 404 SETTINGS SECTION
		Kirki::add_field( 'ccm_error_page', [
			'type'     => 'editor',
			'settings' => 'error_page',
			'label'    => esc_html__( 'Error Page Contents', 'kirki' ),
			'section'  => 'error_page_settings',
			'default'  => '',
		] );

		Kirki::add_field( 'ccm_error_image', [
			'type'        => 'image',
			'settings'    => 'error_page_image',
			'label'       => esc_html__( 'Error Image', 'kirki' ),
			'section'     => 'error_page_settings',
			'default'     => '',
			'choices'     => [
				'save_as' => 'array',
			]
		] );

		Kirki::add_field( 'ccm_error_back_home', [
			'type'        => 'image',
			'settings'    => 'error_back_home',
			'label'       => esc_html__( 'Error Image', 'kirki' ),
			'section'     => 'error_page_settings',
			'default'     => '',
			'choices'     => [
				'save_as' => 'array',
			]
		] );

	// ====================================================================
	// GOOGLE SETTINGS SECTION
	Kirki::add_section( 'google_settings_section', array(
		'title'    => esc_html__( 'Google Settings', 'kirki' ),
		'panel'    => 'theme_options',
		'priority' => 2,
	) );

		// FIELDS INSIDE GOOGLE SETTINGS SECTION
		Kirki::add_field( 'ccm_tag_manager', [
			'type'     => 'text',
			'settings' => 'tag_manager',
			'label'    => esc_html__( 'Tag Manager', 'kirki' ),
			'section'  => 'google_settings_section',
		] );

	//     Kirki::add_field( 'ccm_analytics', [
	//         'type'     => 'text',
	//         'settings' => 'analytics',
	//         'label'    => esc_html__( 'Analytics', 'kirki' ),
	//         'section'  => 'google_settings_section',
	//     ] );

	//     Kirki::add_field( 'ccm_tracking_code', [
	//         'type'     => 'text',
	//         'settings' => 'tracking_code',
	//         'label'    => esc_html__( 'Tracking Code', 'kirki' ),
	//         'section'  => 'google_settings_section',
	//     ] );

		Kirki::add_field( 'ccm_tracking_number', [
			'type'     => 'text',
			'settings' => 'tracking_number',
			'label'    => esc_html__( 'Tracking Number', 'kirki' ),
			'section'  => 'google_settings_section',
		] );

		Kirki::add_field( 'ccm_google_api_map_key', [
			'type'     => 'text',
			'settings' => 'google_map_key',
			'label'    => esc_html__( 'Google Map API Key', 'kirki' ),
			'section'  => 'google_settings_section',
		] );

	// ====================================================================
	// MODAL SETTINGS SECTION
	Kirki::add_section( 'modal_settings', array(
		'title'          => esc_html__( 'Modal Settings', 'kirki' ),
		'panel'          => 'theme_options',
		'priority'       => 2,
	) );

		// FIELDS INSIDE MODAL SETTINGS SECTION
		Kirki::add_field( 'ccm_modal_form', [
			'type'     => 'text',
			'settings' => 'modal_form',
			'label'    => esc_html__( 'Modal Form', 'kirki' ),
			'section'  => 'modal_settings',
			'priority' => 10,
		] );

		Kirki::add_field( 'ccm_modal_title', [
			'type'     => 'text',
			'settings' => 'modal_title',
			'label'    => esc_html__( 'Modal Title', 'kirki' ),
			'section'  => 'modal_settings',
			'priority' => 10,
		] );

		Kirki::add_field( 'ccm_modal_description', [
			'type'     => 'textarea',
			'settings' => 'modal_description',
			'label'    => esc_html__( 'Modal Description', 'kirki' ),
			'section'  => 'modal_settings',
			'priority' => 10,
		] );

	// ====================================================================
	// ADDITIONAL JS & CSS SECTION
	Kirki::add_section( 'additional_js_css_section', array(
		'title'    => esc_html__( 'Additional JS & CSS', 'kirki' ),
		'panel'    => 'theme_options',
		'priority' => 2,
	) );

		// FIELD INSIDE ADDITIONAL JS & CSS SECTION
		Kirki::add_field( 'ccm_js_code', [
			'type'        => 'code',
			'settings'    => 'js_code',
			'label'       => esc_html__( 'Javascript', 'kirki' ),
			'section'     => 'additional_js_css_section',
			'description' => 'Insert your custom javascript code here.',
			'default'     => '',
			'choices'     => [
				'language' => 'js',
			],
		] );

		Kirki::add_field( 'ccm_css_code', [
			'type'        => 'code',
			'settings'    => 'css_code',
			'label'       => esc_html__( 'CSS', 'kirki' ),
			'section'     => 'additional_js_css_section',
			'description' => 'Insert your custom css styles here.',
			'default'     => '',
			'choices'     => [
				'language' => 'css',
			],
		] );

	// ====================================================================
	// SITE LOADERS
	Kirki::add_section( 'ccm_loader_settings_section', array(
		'title'    => esc_html__( 'Site Loaders / Loading Icons', 'kirki' ),
		'panel'    => 'theme_options',
		'priority' => 19,
	) );

		Kirki::add_field( 'ccm_enable_site_loader', [
			'type'        => 'switch',
			'settings'    => 'enable_site_loader',
			'label'       => esc_html__( 'Enable Site Loader', 'kirki' ),
			'section'     => 'ccm_loader_settings_section',
			'default'     => '1',
			'priority'    => 1,
			'choices'     => [
				'on'  => esc_html__( 'Enable', 'kirki' ),
				'off' => esc_html__( 'Disable', 'kirki' ),
			],
		] );

		Kirki::add_field( 'ccm_site_loader', [
			'type'        => 'image',
			'settings'    => 'site_loader',
			'label'       => esc_html__( 'Site Loader', 'kirki' ),
			'description' => esc_html__( 'General Site Loader', 'kirki' ),
			'section'     => 'ccm_loader_settings_section',
			'default'     => '',
			'priority'    => 2,
			'choices'     => [
				'save_as' => 'array',
			]
		] );

		Kirki::add_field( 'ccm_gform_spinner', [
			'type'        => 'image',
			'settings'    => 'gform_spinner',
			'label'       => esc_html__( 'Custom Gravity Form Spinner', 'kirki' ),
			'description' => esc_html__( '60x60 gif spinner', 'kirki' ),
			'section'     => 'ccm_loader_settings_section',
			'default'     => '',
			'priority'    => 3,
			'choices'     => [
				'save_as' => 'array',
			]
		] );

	// ====================================================================
	// SLIDER SETTINGS
	Kirki::add_section( 'ccm_slider_settings_section', array(
		'title'    => esc_html__( 'Slider Settings', 'kirki' ),
		'panel'    => 'theme_options',
		'priority' => 18,
	) );
		Kirki::add_field( 'ccm_enable_slider_autoplay', [
			'type'        => 'switch',
			'settings'    => 'enable_slider_autoplay',
			'label'       => esc_html__( 'Autoplay', 'kirki' ),
			'section'     => 'ccm_slider_settings_section',
			'default'     => '1',
			'priority'    => 1,
			'choices'     => [
				'on'  => esc_html__( 'Enable', 'kirki' ),
				'off' => esc_html__( 'Disable', 'kirki' ),
			],
		] );

		Kirki::add_field( 'ccm_enable_slider_mousedrag', [
			'type'        => 'switch',
			'settings'    => 'enable_slider_mousedrag',
			'label'       => esc_html__( 'Enable Mousedrag', 'kirki' ),
			'section'     => 'ccm_slider_settings_section',
			'default'     => '1',
			'priority'    => 1,
			'choices'     => [
				'on'  => esc_html__( 'Enable', 'kirki' ),
				'off' => esc_html__( 'Disable', 'kirki' ),
			],
		] );

		Kirki::add_field( 'ccm_slide_transition_time', [
			'type'        => 'number',
			'settings'    => 'slide_transition_time',
			'label'       => esc_html__( 'Slide Transition Time (per second)', 'kirki' ),
			'section'     => 'ccm_slider_settings_section',
			'default'     => 8,
			'choices'     => [
				'min'  => 1,
				'max'  => 99,
				'step' => 1,
			],
		] );

		Kirki::add_field( 'ccm_slide_speed', [
			'type'        => 'number',
			'settings'    => 'slide_speed',
			'label'       => esc_html__( 'Slide Speed (per millisecond)', 'kirki' ),
			'section'     => 'ccm_slider_settings_section',
			'default'     => 300,
			'choices'     => [
				'min'  => 100,
				'max'  => 9999,
				'step' => 100,
			],
		] );

	// ====================================================================
	// HEADER SECTION
	Kirki::add_section( 'header_section', array(
		'title'    => esc_html__( 'Header Settings', 'kirki' ),
		'panel'    => 'theme_options',
		'priority' => 2,
	) );

	// ====================================================================
	// FOOTER SECTION
	Kirki::add_section( 'footer_section', array(
		'title'    => esc_html__( 'Footer Settings', 'kirki' ),
		'panel'    => 'theme_options',
		'priority' => 2,
	) );

}


// CALLBACK FUNCTION TO UNSANITIZE HTML ELEMENTS
function unfiltered( $value ) {
	return $value;
}