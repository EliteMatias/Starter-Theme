	</main>
	<footer id="footer">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="copyright-text">
						<!-- DON'T REMOVE THE PHP DATE / AUTO UPDATE PER YEAR -->
						&copy; <?php echo date('Y'); ?> <?php echo get_theme_mod( 'copyright' ); ?>. Website by <a href="https://clickclick.media/" target="_blank">Click Click Media</a>
					</div>
				</div>
			</div>
		</div>
	</footer>

	<!-- CONTACT FORM MODAL -->
	<?php
		$modalForm        = get_theme_mod( 'modal_form' );
		$modalTitle       = get_theme_mod( 'modal_title' );
		$modalDescription = get_theme_mod( 'modal_description' );

		if ( $modalForm ) {
	?>
		<div class="modal fade" id="contactModal">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="modal-body">
						<?php if ( $modalTitle ) { ?>
							<h3 class="modal-title"><?php echo $modalTitle; ?></h3>
						<?php } ?>
						<?php if ( $modalDescription ) { ?>
							<p class="modal-description"><?php echo $modalDescription; ?></p>
						<?php } ?>
						<?php echo do_shortcode( $modalForm ); ?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

	<?php wp_footer(); ?>
</body>
</html>