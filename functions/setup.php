<?php
// ENQUEUE SCRIPTS & STYLES
add_action( 'wp_enqueue_scripts', function() {
	// DEREGISTER DEFAULT WORDPRESS JQUERY FILE
	// wp_deregister_script( 'jquery' );

	// STYLESHEETS
	wp_enqueue_style( 'tiny-slider', '//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/tiny-slider.css' );
	wp_enqueue_style( 'bootstrap-css', '//cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css' );
	wp_enqueue_style( 'hamburger', get_template_directory_uri() . '/assets/css/vendor/hamburgers.css' );
	wp_enqueue_style( 'main', get_template_directory_uri() . '/assets/css/main.css' );
	wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css' );

	// JAVASCRIPTS
	wp_enqueue_script( 'modernizr', '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js', array(), '2.8.3', false );
	// wp_enqueue_script( 'jquery', '//code.jquery.com/jquery-2.2.4.min.js', array(), '2.2.4', false );
	wp_enqueue_script( 'tiny-slider-js', '//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js', array(), '2.9.2', true );
	// wp_enqueue_script( 'bootstrap-bundle', '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js', array( 'jquery' ), '4.4.1', false );
	wp_enqueue_script( 'bootstrap-bundle', '//cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js', array( 'jquery' ), '4.6.0', false );
	wp_enqueue_script( 'velocity-js', '//cdnjs.cloudflare.com/ajax/libs/velocity/1.2.2/velocity.min.js', array( 'jquery' ), '1.2.2', true );
	wp_enqueue_script( 'fancybox-script', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js', array( 'jquery' ), '3.5.7', true );
	wp_enqueue_script( 'sticky-js', get_template_directory_uri() . '/assets/js/vendor/jquery.sticky.js', array( 'jquery' ), '1.0.4', true );
	wp_enqueue_script( 'theme-defaults-js', get_template_directory_uri() . '/assets/js/theme-defaults.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script( 'main-js', get_template_directory_uri() . '/assets/js/main.js', array( 'jquery' ), '1.0.0', true );

	// COMMENTS
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}, 10 );

// REMOVE SCRIPT & STYLES ATTR TYPES
add_filter( 'style_loader_tag', '_remove_attr', 10, 2 );
add_filter( 'script_loader_tag', '_remove_attr', 10, 2 );
function _remove_attr( $tag, $handle ) {
	return preg_replace( "/type=['\"]text\/(javascript|css)['\"]/", '', $tag );
}

// THEME SETUP
add_action( 'after_setup_theme', function(){
	// THEME SUPPORTS
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// ENABLE SHORTCODES ON WIDGETS
	add_filter( 'widget_text', 'do_shortcode' );

	// DEFAULT SIDEBAR WIDGET
	register_sidebar( array(
		'name'          => __( 'Sidebar' ),
		'id'            => 'sidebar-widget',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Mobile Menu' ),
		'id'            => 'mobile-menu-widget',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	// DEFAULT MENU
	register_nav_menu( 'main-menu', __( 'Main Menu', 'elite-theme' ) );
} );

// DISABLE & REMOVE WORDPRESS EMOJIS
add_action( 'init', function() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

	// REMOVE TINYMCE EMOJI PLUGIN
	add_filter( 'tiny_mce_plugins', function( $plugins ) {
		return is_array( $plugins ) ? array_diff( $plugins, array( 'wpemoji' ) ) : array();
	} );

	// REMOVE EMOJI CDN HOSTNAME FROM DNS PREFETCHING HINTS
	add_filter( 'wp_resource_hints', function( $urls, $relation_type ) {
		if ( 'dns-prefetch' == $relation_type ) {
			$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
			$urls = array_diff( $urls, array( $emoji_svg_url ) );
		}
		return $urls;
	}, 10, 2 );
} );

// ADD ALT TEXT TO IMAGE ON UPLOAD
add_action( 'add_attachment', function( $post_ID ) {
	if ( wp_attachment_is_image( $post_ID ) ) {
		$my_image_title = get_post( $post_ID )->post_title;
		$my_image_title = preg_replace( '%\s*[-_\s]+\s*%', ' ',  $my_image_title );
		$my_image_title = ucwords( strtolower( $my_image_title ) );
		$my_image_meta  = array(
			'ID'         => $post_ID,
			'post_title' => $my_image_title,
		);
		update_post_meta( $post_ID, '_wp_attachment_image_alt', $my_image_title );
		wp_update_post( $my_image_meta );
	}
} );

// SEARCH REDIRECT TO HOME IF BLANK
add_filter( 'request', function( $query_vars ) {
	if( isset( $_GET['s'] ) && $_GET['s'] == '' && !is_admin() ) {
		wp_redirect( site_url() );
		exit;
	}
	return $query_vars;
} );

// MEDIA UPLOAD SVG SUPPORT
add_action( 'upload_mimes', function( $file_types ) {
	$new_filetypes = array();
	$new_filetypes['svg'] = 'image/svg+xml';
	$file_types = array_merge($file_types, $new_filetypes );
	return $file_types;
} );

// ADD BOOTSTRAP IMAGE CLASS TO WP THUMBNAILS
add_filter( 'wp_get_attachment_image_attributes', function( $attr ) {
	remove_filter('wp_get_attachment_image_attributes','add_class_thumbnail');
	$attr['class'] .= ' img-fluid';
	return $attr;
} );

// HOOK TO WP_HEAD
add_action( 'wp_head', function() {
	$tag_manager      = get_theme_mod( 'tag_manager' );
	$google_analytics = get_theme_mod( 'analytics' );
	$tracking_code    = get_theme_mod( 'tracking_code' );
	$tracking_num     = get_theme_mod( 'tracking_number' );
	$custom_css       = get_theme_mod( 'css_code' );
?>
	<?php if ( $tag_manager ) { ?>
		<!-- TAG MANAGER -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','<?php echo $tag_manager; ?>');</script>
	<?php } ?>

	<?php if ( $tracking_code && $tracking_num ) { ?>
		<!-- GOOGLE TRACKING OPTION -->
		<script>(function(a,e,c,f,g,b,d){var h={ak:"<?php echo $tracking_num; ?>",cl:"<?php echo $tracking_code; ?>"};a[c]=a[c]||function(){(a[c].q=a[c].q||[]).push(arguments)};a[f]||(a[f]=h.ak);b=e.createElement(g);b.async=1;b.src="//www.gstatic.com/wcm/loader.js";d=e.getElementsByTagName(g)[0];d.parentNode.insertBefore(b,d);a._googWcmGet=function(b,d,e){a[c](2,b,h,d,null,new Date,e)}})(window,document,"_googWcmImpl","_googWcmAk","script");
		</script>
	<?php } ?>

	<?php if ( $google_analytics ) { ?>
		<!-- GOOGLE ANALYTICS -->
		<script>
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', '<?php echo $google_analytics; ?>']);
			_gaq.push(['_trackPageview']);
			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s  = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>
	<?php } ?>

	<?php if ( $custom_css ) { ?>
		<!-- css -->
		<style>
			<?php echo $custom_css; ?>
		</style>
	<?php } ?>
<?php
} );

// AFTER OPENING BODY TAG
add_action( "after_body_tag", function() { ?>
	<?php if ( get_theme_mod( 'tag_manager' ) ) { ?>
		<!-- TAG MANAGER -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo get_theme_mod( 'tag_manager' ); ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<?php } ?>
<?php } ); // after_body_tag end

// HOOK TO WP_FOOTER
add_action( "wp_footer", function() { ?>
	<!-- CUSTOM JS -->
	<?php if ( get_theme_mod( 'js_code' ) ) { ?>
		<script><?php echo get_theme_mod( 'js_code' ); ?></script>
	<?php } ?>
<?php } ); // wp_footer end

// LOGIN PAGE
add_action( 'login_enqueue_scripts', 'my_login_logo' );
function my_login_logo() {
	$logo               = get_theme_mod('site_logo');
	$login_button_color = get_theme_mod('wp_login_button_text_color');
	$login_button_bg    = get_theme_mod('wp_login_button_bg_color');
	$login_page_bg      = get_theme_mod('wp_login_bg_color');
	$login_form_bg      = get_theme_mod('wp_login_box_bg_color');
?>
	<style>
		#login h1 a,
		body.login h1 a {
			outline: 0;
			background-image: url(<?php echo $logo['url']; ?>);
			height: 65px;
			width: 100%;
			max-width: 250px;
			background-size: initial;
			background-repeat: no-repeat;
			background-position: center;
			margin-bottom:15px;
		}
	</style>
<?php
	if ($login_button_bg || $login_button_color) {
?>
	<style>
		body.login #wp-submit{
			background-color: <?php echo $login_button_bg; ?>;
			color: <?php echo $login_button_color; ?>;
			border: 0;
			box-shadow: none;
			text-shadow: none;
		}
	</style>
<?php
	}
	if($login_page_bg) {
?>
	<style>
		body.login {
			background-color: <?php echo $login_page_bg; ?>;
		}
	</style>
<?php
	}
	if($login_form_bg) {
?>
	<style>
		body.login #loginform{
			background-color: <?php echo $login_form_bg; ?>;
		}
	</style>
<?php
	}
}
add_filter( 'login_headerurl', 'my_login_logo_url' );
function my_login_logo_url() {
	return home_url();
}

// ADD LOADING CLASS TO THE BODY FOR THE LOADER
add_filter( 'body_class', function( $classes ) {
	$enableLoader = get_theme_mod( 'enable_site_loader' );
	if ( $enableLoader == true ) {
		return array_merge( $classes, array( 'site-is-loading' ) );
	} else {
		return $classes;
	}
} );

// Remove Shortlink
function remove_redundant_shortlink() {
	remove_action('wp_head', 'wp_shortlink_wp_head', 10);
	remove_action( 'template_redirect', 'wp_shortlink_header', 11);
}
add_filter('after_setup_theme', 'remove_redundant_shortlink');

// Remove Feed
remove_action('wp_head', 'feed_links', 2 );
add_filter('post_comments_feed_link',function () { return null;});

function custom_disable_feed() {
	wp_die( __( 'No feed available, please visit the homepage!' ) );
}
add_action('do_feed', 'custom_disable_feed', 1);
add_action('do_feed_rdf', 'custom_disable_feed', 1);
add_action('do_feed_rss', 'custom_disable_feed', 1);
add_action('do_feed_rss2', 'custom_disable_feed', 1);
add_action('do_feed_atom', 'custom_disable_feed', 1);
add_action('do_feed_rss2_comments', 'custom_disable_feed', 1);
add_action('do_feed_atom_comments', 'custom_disable_feed', 1);