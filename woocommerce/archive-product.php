<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
do_action( 'woocommerce_before_main_content' );

// AD BANNER
$adbanner     = get_theme_mod( 'banner_ad' );
$adbannerlink = get_theme_mod( 'banner_ad_link' );
if ($adbanner):
  echo '<div class="adbanner text-center">';
  if($adbannerlink): echo '<a href="'.$adbannerlink.'">'; endif;
  echo '<img src="'.$adbanner['url'].'" alt="Ronnie John" class="img-fluid py-3" />';
  if($adbannerlink): echo '</a>'; endif;
  echo '</div>';
endif; 

$product_cat_object = get_queried_object();

if ( is_shop() && !is_search() ) {
	$shop_subheading = get_theme_mod('shop_top_text');
	$shop_tagline    = get_theme_mod('shop_tagline');

	if ( $shop_subheading || $shop_tagline ) {
?>
	 <div class="shop-header shop-tagline">
		<?php if ( $shop_subheading ) { ?>
			<p class="shop-subheading"><?php echo $shop_subheading; ?></p>
		<?php } ?>
		<?php if ( $shop_tagline ) { ?>
			<h1 class="shop-heading"><?php echo $shop_tagline; ?></h1>
		<?php } ?>
	</div>
<?php
	}
} else {
	$cstm_prod_name = get_field('custom_product_category_name', 'product_cat_' . $product_cat_object->term_id);
	$cat_desc       = category_description();
?>
	<div class="shop-header">
		<?php if($cstm_prod_name) { ?>
		  <h1 class="category-name"><?php echo $cstm_prod_name; ?></h1>
		<?php } else { ?>
		  <h1 class="category-name">SHOP <?php single_cat_title(); ?></h1>
		<?php } ?>

		<?php if ($cat_desc) { ?>
		  <div class="category-description default-content cat-content"><?php echo $cat_desc; ?></div>
		  <button class="expand-button">Read more</button>
		<?php } ?>
	</div>
<?php
} ?>

<div class="row">

	<?php if ( !is_shop() ): ?>
		<div class="col-12 col-lg-3 left">
			<div class="sidebar-wrap">
				<?php
					/**
					* Hook: woocommerce_sidebar.
					*
					* @hooked woocommerce_get_sidebar - 10
					*/

					/*OMIT SIDEBAR*/
					do_action( 'woocommerce_sidebar' );
				?>
			</div>
		</div>
	<?php endif; ?>


	<div class="col-12 <?php if ( !is_shop() ) { echo "col-lg-9 right"; } ?>">
		<?php if ( woocommerce_product_loop() ) {

			/**
			 * Hook: woocommerce_before_shop_loop.
			 *
			 * @hooked woocommerce_output_all_notices - 10
			 * @hooked woocommerce_result_count - 20
			 * @hooked woocommerce_catalog_ordering - 30
			 */
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
			add_action('woocommerce_before_shop_loop', 'shop_loop_header', 20);
			do_action( 'woocommerce_before_shop_loop' );

			woocommerce_product_loop_start();

			if ( wc_get_loop_prop( 'total' ) ) {
				while ( have_posts() ) {
					the_post();

					/**
					 * Hook: woocommerce_shop_loop.
					 */
					do_action( 'woocommerce_shop_loop' );

					wc_get_template_part( 'content', 'product' );
				}
			}

			woocommerce_product_loop_end();

			/**
			 * Hook: woocommerce_after_shop_loop.
			 *
			 * @hooked woocommerce_pagination - 10
			 */
			remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
			add_action( 'woocommerce_after_shop_loop', 'shop_loop_footer', 10 );
			do_action( 'woocommerce_after_shop_loop' );
		} else {
			/**
			 * Hook: woocommerce_no_products_found.
			 *
			 * @hooked wc_no_products_found - 10
			 */
			do_action( 'woocommerce_no_products_found' );
		} ?>
	</div>

</div>

<?php
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

get_footer( 'shop' );
