<?php get_header(); ?>

<style>
	.slider .slide-item.tns-item{
		color: white;
		font-size: 24px;
		text-align: center;
		padding: 0 10px;
	}
	.slider .slide-item.tns-item .wrap{
		background-color: rgba( 0, 0, 0, 0.4 );
		border: 1px solid black;
	}
</style>

<!-- https://github.com/ganlanyuan/tiny-slider#responsive-options -->
<!-- http://ganlanyuan.github.io/tiny-slider/demo/ -->

<div class="container">
	<div class="row">
		<div class="col-12">
			<h3>Test Slider w/ Data Settings</h3>
			<?php
				$responsiveOptions = [
					'480' => [
						'items' => 2,
						'edgePadding' => 0
					],
					'992' => [
						'items' => 3,
						'edgePadding' => 0
					],
					'1200' => [
						'edgePadding' => 150 // outside space -- panghatak sa elements
					]
				];
			?>
			<div class="slider"
				data-autoplay="<?php echo get_theme_mod( 'enable_slider_autoplay' ); ?>"
				data-slide-speed="<?php echo get_theme_mod( 'slide_speed' ); ?>"
				data-time-before-slide="<?php echo get_theme_mod( 'slide_transition_time' ); ?>"
				data-mousedrag="<?php echo get_theme_mod( 'enable_slider_mousedrag' ); ?>"
				data-loop="true"
				data-items="1"
				data-slide-count="1"
				data-center-slides="false"
				data-start-index="0"
				data-slider-nav="false"
				data-controls="true"
				data-auto-width="false"
				data-responsive-options="<?php echo htmlspecialchars( json_encode( $responsiveOptions ), ENT_QUOTES, 'UTF-8'); ?>">
				<div class="slide-item"><div class="wrap">1</div></div>
				<div class="slide-item"><div class="wrap">2</div></div>
				<div class="slide-item"><div class="wrap">3</div></div>
				<div class="slide-item"><div class="wrap">4</div></div>
				<div class="slide-item"><div class="wrap">5</div></div>
				<div class="slide-item"><div class="wrap">6</div></div>
				<div class="slide-item"><div class="wrap">7</div></div>
			</div>
		
			<h3 class="mt-5">Test Default Slider</h3>
			<div class="slider" data-autoplay='false'>
				<div class="slide-item"><div class="wrap">a</div></div>
				<div class="slide-item"><div class="wrap">b</div></div>
				<div class="slide-item"><div class="wrap">c</div></div>
				<div class="slide-item"><div class="wrap">d</div></div>
				<div class="slide-item"><div class="wrap">e</div></div>
				<div class="slide-item"><div class="wrap">f</div></div>
			</div>
		
			<button class="btn mt-5" data-toggle="modal" data-target="#contactModal">Default Modal</button>
		</div>
	</div>
</div>

<?php get_footer(); ?>