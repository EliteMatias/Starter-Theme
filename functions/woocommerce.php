<?php
/* CHANGE PRODUCT LOOP COLUMS */
add_filter('loop_shop_columns', 'loop_columns', 999);
if (!function_exists('loop_columns')) {
	function loop_columns() {
		/* IF CATEGORIES WILL BE DISPLAYED ON MAIN SHOP PAGE, USE 3 COLUMNS */
		if ( is_shop() && get_option('woocommerce_shop_page_display') == "subcategories" && !is_search() ) {
			return 3;
		} else {
			return 4;
		}
	}
}

/* CHANGE PER PAGE PRODUCT DISPLAY */
add_filter( 'loop_shop_per_page', 'woocommerce_modify_product_per_page', 20 );
function woocommerce_modify_product_per_page( $per_page ) {
  $per_page = 20;
  return $per_page;
}

/* SHOP LOOP HEADER */
function shop_loop_header() {
	echo "<div class='shop-loop-header'>";
		woocommerce_result_count();
		woocommerce_catalog_ordering();
	echo "</div>";
}

/* SHOP LOOP FOOTER */
function shop_loop_footer() {
	echo "<div class='shop-loop-footer'>";
		woocommerce_result_count();
		woocommerce_pagination();
	echo "</div>";
}

/* ADD CATEGORIES ON WOOCOMMERCE PRODUCT LOOP */
function woocommerce_product_categories( $max = "" ) {
	$terms = get_the_terms( get_the_ID(), 'product_cat' );

	$max = ( $max != 0 ) ? absint( $max ) : "";

	if ( $terms && !is_wp_error( $terms ) ) {
		echo "<div class='product-categories'>";
			foreach ( $terms as $key => $term ) {
				$termLink = get_term_link( $term->term_id );
				$termName = $term->name;
				echo "<a href='{$termLink}'>{$termName}</a>";

				if ( $key+1 == $max ) {
					break;
				}
			}
		echo "</div>";
	}
}

/* RENAME WOOCOMMERCE SORT BY */
add_filter( 'woocommerce_catalog_orderby', function( $options ) {
	$options[ 'menu_order' ] = 'Default';
	$options[ 'popularity' ] = 'Popularity';
	$options[ 'rating' ]     = 'Rating';
	$options[ 'date' ]       = 'Date';
	$options[ 'price' ]      = 'Price';
	$options[ 'price-desc' ] = 'Price: high to low';

	return $options;
} );

/* REMOVE TRAILING ZEROS  FROM PRODUCT PRICE */
add_filter('woocommerce_price_trim_zeros', 'wc_hide_trailing_zeros', 10, 1);
function wc_hide_trailing_zeros( $trim ) {
	return true;
}

/* ADD WOOCOMMERCE CUSTOMIZER FIELDS */
add_action('customize_register','wc_customizer_fields');
function wc_customizer_fields( $wp_customize ) {
	$wp_customize->add_section('shop_heading',array(
		'title'    => 'Shop Page Heading',
		'priority' => 1,
		'panel'    => 'woocommerce',
	));

	$wp_customize->add_setting('shop_top_text',array(
		'default' => '',
	));

	$wp_customize->add_control('shop_top_text_control', array(
		'label'    => 'Shop Top Text',
		'type'     => 'text',
		'section'  => 'shop_heading',
		'settings' => 'shop_top_text',
	));

	$wp_customize->add_setting('shop_tagline',array(
		'default' => '',
	));

	$wp_customize->add_control('shop_tagline_control', array(
		'label'    => 'Shop Tagline',
		'type'     => 'text',
		'section'  => 'shop_heading',
		'settings' => 'shop_tagline',
	));
}

/* CHANGE CROSS SELL COLUMNS */
add_action('woocommerce_cross_sells_columns', function(){ return 4; });

/* CHANGE PAYPAL LOGO ON CHECKOUT, REMOVE WHAT IS PAYPAL LINK */
add_filter( 'woocommerce_gateway_icon', function( $icon_html, $gateway_id ) {
	if ( $gateway_id == "paypal" ) {
		$icon      = get_stylesheet_directory_uri().'/assets/images/paypal-icon.jpg';
		$icon_html = "<img class='paypal-icon' src='{$icon}' alt='paypal icon'/>";
	}

	return $icon_html;
}, 10, 2 );

/* CHANGE PLACE ORDER TEXT */
add_filter( 'woocommerce_order_button_text', function() {
	return "CONTINUE TO PAYMENT";
} );

/* CHANGE GATEWAY PLACE ORDER BUTTON TEXT */
add_filter( 'gettext', function( $translated_text, $text, $domain ) {
	if( $translated_text == 'Proceed to PayPal' ) {
		$translated_text = 'CONTINUE TO PAYMENT';
	}
	return $translated_text;
}, 20, 3 );

/* CHANGE WOOCOMMERCE SEPARATOR */
add_filter( 'woocommerce_breadcrumb_defaults', function( $defaults ) {
	$defaults['delimiter'] = " <span class='separator'>></span> ";
	return $defaults;
} );

/* CREATE SHIPPING AND RETURNS META BOX ON PRODUCT PAGE */
add_action( 'add_meta_boxes', function () {
	add_meta_box(
		'shipping_return_meta_box',
		__( 'Shipping and returns', 'woocommerce' ),
		'add_shipping_return_meta_box',
		'product',
		'normal',
		'default'
	);
} );

// ADD WP EDITOR TO SHIPPING AND RETURNS META BOX
function add_shipping_return_meta_box( $post ){
	$product = wc_get_product($post->ID);
	$content = $product->get_meta( '_shipping_and_return' );

	wp_editor( $content, '_shipping_and_return', ['textarea_rows' => 10, 'media_buttons' => false]);
}

// SAVE SHIPPING AND RETURNS EDITOR ON PRODUCT UPDATE/SAVE
add_action( 'woocommerce_admin_process_product_object', 'save_product_custom_wysiwyg_field', 10, 1 );
function save_product_custom_wysiwyg_field( $product ) {
	if (  isset( $_POST['_shipping_and_return'] ) )
		 $product->update_meta_data( '_shipping_and_return', wp_kses_post( $_POST['_shipping_and_return'] ) );
}

// ADD SHIPPING AND RETURNS PRODUCT DATA TAB / REORDER PRODUCT DATA TABS / RENAME PRODUCT DATA TABS- FRONTEND
add_filter(
	'woocommerce_product_tabs',
	function ( $tabs ) {
		global $product;

		if ( $tabs ) {
			/* RENAME PRODUCT REVIEW TAB */
			if ( array_key_exists('reviews', $tabs) ) {
				if ( $product->get_review_count() == 0 ) {
					$tabs['reviews']['title'] = 'Reviews';
				} else {
					$tabs['reviews']['title'] = 'Reviews('.$product->get_review_count().')';
				}
			}

			/* REORDER DATA TABS */
			array_key_exists( 'description', $tabs ) ? $tabs['description']['priority'] = 10 : "";
			array_key_exists( 'additional_information', $tabs ) ? $tabs['additional_information']['priority'] = 20 : "";
			array_key_exists( 'reviews', $tabs ) ? $tabs['reviews']['priority'] = 30 : "";
		}

		/* ADD CUSTOM TAB  - SHIPPING AND RETURN */
		if ( !empty( $product->get_meta( '_shipping_and_return' ) ) ) {
			$tabs['shipping_return'] = array(
				'title'    => __( 'Shipping & Returns', 'woocommerce' ),
				'priority' => 40,
				'callback' => 'shipping_and_return_tab_content'
			);
		}

		return $tabs;
	},
	10,
	98
);

// DISPLAY SHIPPING AND RETURNS TAB CONTENT ON PRODUCT TABS - FRONT END
function shipping_and_return_tab_content() {
	global $product;

	echo "<div class='default-content'>";
		echo apply_filters( 'the_content', $product->get_meta( '_shipping_and_return' ) );
	echo "</div>";
}

/* PRODUCT SHARE ICONS */
add_action( 'woocommerce_share', 'woocommerce_product_share' );
function woocommerce_product_share() {
	$title = get_the_title();
	$url   = get_the_permalink();
?>
	<p class="social-media-heading"><strong>Share this:</strong></p>
	<?php echo do_shortcode('[addtoany]'); ?>
	
	<!-- <ul class="social-media-links product-share">
		<li>
			<?php $facebookURL = sanitize_url( "https://www.facebook.com/sharer/sharer.php?u={$url}" ); ?>
			<a href="<?php echo $facebookURL; ?>" target="_blank" class="scm-link">
				<i class="fab fa-facebook-f"></i>
			</a>
		</li>
		<li>
			<?php $twitterURL = sanitize_url( "https://twitter.com/intent/tweet?url={$url}&text={$title}"); ?>
			<a href="<?php echo $twitterURL; ?>" target="_blank" class="scm-link">
				<i class="fab fa-twitter"></i>
			</a>
		</li>
		<li class="d-none">
			<?php $pinterestURL = sanitize_url( "http://pinterest.com/pin/create/button/?url={$url}" ); ?>
			<a href="<?php echo $pinterestURL; ?>" target="_blank" class="scm-link">
				<i class="fab fa-pinterest-p"></i>
			</a>
		</li>
	</ul> -->
<?php
}


// Add back to store button on WooCommerce cart page
add_action('woocommerce_before_cart_table', 'themeprefix_back_to_store', 6);
// add_action( 'woocommerce_cart_actions', 'themeprefix_back_to_store' );

function themeprefix_back_to_store() { ?>
<a class="button wc-backward" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"> <?php _e( 'Back to Shop', 'woocommerce' ) ?> </a>

<?php
}
