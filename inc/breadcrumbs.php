<section class="breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-12">
			<?php
				if ( function_exists('yoast_breadcrumb') ) {
					yoast_breadcrumb( '<div id="breadcrumbs">','</div>' );
				}
			?>
			</div>
		</div>
	</div>
</section>