<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<meta name="theme-color" content="#c81919">
	<title></title>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<!-- Don't remove this -->
	<?php do_action( "after_body_tag" ); ?>

	<!-- SITE LOADER -->
	<?php
		$enableLoader = get_theme_mod( 'enable_site_loader' );
		$siteLoader   = get_theme_mod( 'site_loader' );
		if ( $enableLoader && $siteLoader ) {
			echo "<div class='site-loader'><div class='spinner' style='background-image: url(" . $siteLoader['url'] . ");'></div></div>";
		}
	?>

	<!-- TINY SLIDER POLYFILLS FOR IE8 -->
	<!--[if (lt IE 9)]><script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.helper.ie8.js"></script><![endif]-->

	<!--[if lt IE 9]>
		<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
	<!--[if lt IE 8]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->


	<!-- VARIABLES -->
	<?php
		$search = get_theme_mod('enable_site_search');
	
		$numberDisplay = get_theme_mod( 'site_number' );
		$number        = str_replace(" ", "", get_theme_mod( 'site_number' ));
		$email         = get_theme_mod('site_email');
		$location      = get_theme_mod('site_location');

		$logo     = get_theme_mod( 'site_logo' );
		$siteName = get_bloginfo( 'name' );
	?>

	<!-- MOBILE MENU -->
	<aside id="mobile-menu">
		<div class="mobile-menu-wrap">
			<?php if ($search): ?>
				<div class="mobile-search">
					<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="search-form" role="search" id="searchform">
						<input type="search" autocomplete="off" id="s" placeholder="Search" value="<?php echo trim( esc_attr( get_search_query() ) ); ?>" name="s" placeholder="Search" required>
						<button><span class="fa fa-search"></span></button>
					</form>
				</div>
			<?php endif; ?>

			<?php
				if ( is_active_sidebar( 'mobile-menu-widget' ) ) {
					dynamic_sidebar( 'mobile-menu-widget' );
				}
			?>
			<div class="mobile-contact-wrap">

				<?php if (isset($number) && $number != ""): ?>
					<div class="site-phone ct">
						<span>Phone:</span>
						<a href="tel:<?php echo $number ?>" class="tracknumber">
							<?php echo $numberDisplay; ?>
						</a>
					</div>
				<?php endif; ?>

				<?php if (isset($email) && $email != ""): ?>
					<div class="site-email ct">
						<span>Email: </span>
						<a href="#" data-toggle="modal" data-target="#contactModal" class="site-email"><?php echo $email; ?></a>
					</div>
				<?php endif; ?>

				<?php if (isset($location) && $location != ""): ?>
					<div class="site-location ct">
						<?php echo $location; ?>
					</div>
				<?php endif; ?>

			</div>
		</div>
	</aside>

	<!-- SITE HEADER -->
	<header id="header">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-7 col-xl-3">
					<a href="<?php echo get_site_url(); ?>/" class="site-logo">
						<?php
							if ( $logo ) {
								echo "<img src='" . $logo['url'] . "' alt='" . $siteName . "' class='img-fluid'>";
							} else {
								echo "<span class='site-name'>" . $siteName . "</span>";
							}
						?>
					</a>
				</div>
				<div class="d-none d-xl-block col-xl-9">
					<?php if (has_nav_menu( 'main-menu' )): ?>
						<?php wp_nav_menu( array(
							'menu'  => 'Main Menu',
							'depth' => 3
						) ); ?>
					<?php endif; ?>
				</div>
				<div class="col-5 d-xl-none text-right align-items-center">

					<?php if (isset($number) && $number != ""): ?>
						<a href="tel:<?php echo $number; ?>" class="tracknumber">
							<i class="fas fa-phone fa-rotate-90"></i>
						</a>
					<?php endif; ?>

					<button class="hamburger hamburger--squeeze" type="button" data="mobile-menu-trigger">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</button>

				</div>
			</div>
		</div>
	</header>

	<!-- MAIN WRAPPER -->
	<main id="main-wrapper">