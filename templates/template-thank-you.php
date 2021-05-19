<?php
	// Template Name: Thank You
	get_header();
	$error_back_home = get_theme_mod( 'error_back_home' );
?>

<section class="thank-you-section" style="background-color: <?php echo get_theme_mod( 'thankyou_bg_color' );?>;">
	<div class="container h-100">
		<div class="row h-100 align-items-center justify-content-center">
			<div class="col-12">
				<div class="inner-content-wrap">
					<?php
						if ( have_posts() ) {
							while( have_posts() ) { the_post();
								the_content();
							}
						}
					?>
					<a href="<?php echo get_site_url(); ?>/" class="back-to-home">
						<img src="<?php echo $error_back_home['url']; ?>">
					</a>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>