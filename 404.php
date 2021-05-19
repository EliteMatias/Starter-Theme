<?php
	get_header();
	$errorImg        = get_theme_mod( 'error_page_image' );
	$error_back_home = get_theme_mod( 'error_back_home' );
?>

<section class="page-not-found" style="background-color: <?php echo get_theme_mod( 'error_page_bg_color' );?>;">
	<div class="container h-100">
		<div class="row h-100 align-items-center justify-content-center">
			<div class="col-12 col-lg-10">
				<div class="inner-content-wrap">
					<a href="<?php echo get_site_url(); ?>/" class="back-to-home">
						<img src="<?php echo $error_back_home['url']; ?>">
					</a>
					<div class="image-wrap">
						<img src="<?php echo $errorImg['url']; ?>">
					</div>
					<div class="inner-content-wrap">
						<h3>WHOOPS...!</h3>
						<?php echo get_theme_mod( 'error_page' ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>