<?php get_header(); ?>

<?php get_template_part( 'inc/breadcrumbs' ); ?>

<?php
	$post_type = get_queried_object()->post_type;
?>

<section class="single-wrapper single-<?= $post_type; ?>">
	<div class="container">
		<div class="row">
			<div class="col-12 col-lg-8 col-xl-9">
				<?php
					$featuredImage  = get_the_post_thumbnail_url( get_the_ID(), 'full' );
					$author         = get_the_author();
					$category       = get_the_category();
					$parentCategory = $category ? $category[0]->name : '';
				?>
				<div class="post-item">
					<?php
						if ( $featuredImage ) {
							echo "<img src='".$featuredImage."' alt='".get_the_title()."' class='img-fluid featured-image' />";
						}
					?>
					<h1 class="post-title"><?php echo get_the_title(); ?></h1>
					<div class="post-author">
						Posted<?php echo $author ? " by <strong>" . $author . "</strong>" : ""; ?><?php echo $category ? " in <strong>" . $parentCategory . "</strong>" : ""; ?>
					</div>
					<div class="post-content default-content">
						<?php the_content(); ?>
					</div>
				</div>
			</div>
			<div class="col-12 col-lg-4 col-xl-3">
				<?php get_template_part( 'inc/sidebar' ); ?>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>