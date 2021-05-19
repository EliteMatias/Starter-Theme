<?php get_header(); ?>

<div class="container archive-wrapper">
	<div class="row">
		<div class="col-12 col-lg-8 col-xl-9">
			<?php if ( have_posts() ): ?>
				<?php while ( have_posts() ): the_post(); ?>
					<?php
						$featuredImage  = get_the_post_thumbnail_url( get_the_ID(), 'full' ) ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : get_template_directory_uri() . '/assets/img/placeholder.jpg';
						$author         = get_the_author();
						$category       = get_the_category();
						$excerpt        = get_the_excerpt();
						$parentCategory = $category ? $category[0]->name : '';
					?>
					<div class="post-item text-center text-lg-left">
						<?php
							if( $featuredImage ) {
								echo "<img src='".$featuredImage."' alt='".get_the_title()."' class='img-fluid featured-image' />";
							}
						?>
						<h3 class="post-title"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
						<div class="post-author">
							Posted<?php echo $author ? " by <strong>" . $author . "</strong>" : ""; ?><?php echo $category ? " in <strong>" . $parentCategory . "</strong>" : ""; ?>
						</div>
						<div class="post-content">
							<?php
								if ( $excerpt ) {
									echo $excerpt;
								} elseif (get_the_content()) {
									echo wp_trim_words( get_the_content(), 30, "..." );
								} else {
									echo "Coming soon...";
								}
							?>
						</div>
						<a href="<?php echo get_the_permalink(); ?>" class="read-more">Read More</a>
					</div>
				<?php endwhile; ?>

				<?php
					$big = 999999999; // need an unlikely integer

					$paginate = paginate_links( array(
						'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format'    => '?paged=%#%',
						'current'   => max( 1, get_query_var('paged') ),
						'total'     => $wp_query->max_num_pages,
						'prev_text' => '<i class="fal fa-angle-left"></i>',
						'next_text' => '<i class="fal fa-angle-right"></i>'
					) );
				?>

				<div class="pagination">
					<?php
						if ( $paginate ) {
							echo "<div class='post-pagination'>" . $paginate . "</div>";
						}
					?>
				</div>

			<?php endif; ?>
		</div>

		<div class="col-12 col-lg-4 col-xl-3">
			<?php get_template_part( 'inc/sidebar' ); ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>