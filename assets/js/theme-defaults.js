// DEFAULT SLIDES
var sliders = document.querySelectorAll( '.slider' );
if ( sliders.length > 0 ) {
	jQuery.each( sliders, function ( index, value ) {
		var sliderItems       = jQuery(this).data( 'items' ),
		    sliderAutoPlay    = jQuery(this).data( 'autoplay' ),
		    sliderLoop        = jQuery(this).data( 'loop' ),
		    sliderSpeed       = jQuery(this).data( 'slide-speed' ) ? jQuery(this).data( 'slide-speed' ) : "300",                        // slide change transition speed
		    sliderTransition  = jQuery(this).data( 'time-before-slide' ) ? jQuery(this).data( 'time-before-slide' ) + "000" : "8000",   // autoplay slide change transition speed
		    slideCount        = jQuery(this).data( 'slide-count' ) ? jQuery(this).data( 'slide-count' ) : 'page',                       // number of slides to show in one click
		    centerSlides      = jQuery(this).data( 'center-slides' ),                                                                   // center the slides
		    controls          = jQuery(this).data( 'controls' ),                                                                        // enable next prev buttons
		    sliderNav         = jQuery(this).data( 'slider-nav' ),                                                                      // enable slider nav dots
		    mouseDrag         = jQuery(this).data( 'mousedrag' ),                                                                       // enable mouse drag
		    edgePadding       = jQuery(this).data( 'edge-padding' ),                                                                    // outside space -- panghatak sa elements
		    autoWidth         = jQuery(this).data( 'auto-width' ),                                                                      // auto width items
		    startIndex        = jQuery(this).data( 'start-index' ),                                                                     // slider start
		    responsiveOptions = jQuery(this).data( 'responsive-options' );

		var slider = tns( {
			container           : value,
			items               : sliderItems,
			autoplay            : sliderAutoPlay,
			startIndex          : startIndex,         // slider start
			loop                : sliderLoop,
			speed               : sliderSpeed,        // slide change transition speed
			mouseDrag           : mouseDrag,          // enable mouse drag
			center              : centerSlides,       // center the slides
			edgePadding         : edgePadding,        // outside space -- panghatak sa elements
			autoWidth           : autoWidth,          // auto width items
			slideBy             : slideCount,         // number of slides to show in one click
			controls            : controls,           // enable next prev buttons
			controlsPosition    : 'bottom',           // position of the prev next buttons
			nav                 : sliderNav,          // enable slider nav dots
			navPosition         : 'bottom',           // position of the nav dots
			autoplayPosition    : 'bottom',           // autoplay button position
			autoplayButtonOutput: false,              // hide autoplay button
			autoplayTimeout     : sliderTransition,   // autoplay slide change transition speed
			responsive          : responsiveOptions   // responsive options declared
		} );
	} )
}

jQuery( document ).ready( function() {
	jQuery( window ).on( 'load', function() {
		// mobileMenuAlignment(); // MOBILE MENU DYNAMIC MARGIN & PADDING

		// SITE LOADER
		if ( jQuery( "body" ).hasClass( 'site-is-loading' ) ) {
			jQuery( ".site-loader" ).css( "opacity", 0 );
			setTimeout( function() {
				jQuery( "body" ).removeClass( 'site-is-loading' );
				jQuery( ".site-loader" ).remove();
			}, 300 );
		}
	} );

	jQuery( window ).on( 'resize', function() {
		// mobileMenuAlignment(); // MOBILE MENU DYNAMIC MARGIN & PADDING
	} );

	// MOBILE MENU ADD ARROW
	jQuery( ".mobile-menu-wrap .widget_nav_menu .menu .menu-item-has-children" ).append( "<div class='dropdown-arrow'></div>" );
	jQuery( "body" ).on( "click", ".mobile-menu-wrap .widget_nav_menu .dropdown-arrow", function() {
		jQuery(".sub-menu").css({"margin-top":"0px"});
		jQuery( this ).closest( ".menu-item" ).toggleClass( "active" );
		if ( jQuery( this ).closest( ".menu-item" ).hasClass( "active" ) ) {
			jQuery( this ).siblings( ".sub-menu" ).slideDown();
		} else {
			jQuery( this ).siblings( ".sub-menu" ).slideUp();
		}
	} );


	// SIDEBAR WIDGET MENU
	jQuery( ".page-sidebar .widget_nav_menu .menu .menu-item-has-children" ).append( "<div class='dropdown-arrow'></div>" );
	jQuery( "body" ).on( "click", ".page-sidebar .widget_nav_menu .dropdown-arrow", function() {
		jQuery( this ).closest( ".menu-item" ).toggleClass( "active" );
		if ( jQuery( this ).closest( ".menu-item" ).hasClass( "active" ) ) {
			jQuery( this ).siblings( ".sub-menu" ).slideDown();
		} else {
			jQuery( this ).siblings( ".sub-menu" ).slideUp();
		}
	} );

	// MOBILE MENU DYNAMIC MARGIN & PADDING
	function mobileMenuAlignment() {
		var headerHeight = jQuery( "#header" ).outerHeight();

		// mobile menu
		jQuery( "#mobile-menu" ).css( 'margin-top', headerHeight );
		jQuery( "#mobile-menu .mobile-menu-wrap" ).css( 'padding-bottom', headerHeight );
		jQuery( "#mobile-menu .menu .sub-menu" ).css( 'margin-top', headerHeight );
	}
} );

/*WOOCOMMERCE*/
jQuery( document ).ready( function() {
	/* OPEN LIGHTBOX - SINGLE PRODUCT PAGE */
	jQuery('.woocommerce-product-gallery__wrapper a').attr('data-fancybox','product-images');
	jQuery('.woocommerce-product-gallery__wrapper a').fancybox({
		keyboard: true,
		modal: false,
		loop: true,
	});

	/* PRODUCT THUMBNAIL SLIDER */
	if ( jQuery('.flex-control-thumbs').length ) {
		tns({
			"container": ".flex-control-thumbs",
			"items": 4,
			"speed": 400,
			"slideBy": 1,
			"arrowkeys": true,
			"loop": false,
			"rewind": true,
			"touch": true,
			"mouseDrag": true,
			"swipeAngle": true,
			"controls": true,
			"controlsPosition": "bottom",
			"nav": false,
		});
	}

	(function(){

		$processing = false;

		jQuery('body').on('click', '.qty-up', function() {
			$processing = true;

			$cartForm = jQuery('form.woocommerce-cart-form');
			$qtyWrap = jQuery(this).parents('.qty-input-wrapper');

			$qty = $qtyWrap.find('input.qty');
			$qtyVal = $qty.val() ? parseInt( $qty.val() ) : 0;

			$step = $qty.attr('step') ? parseInt( $qty.attr('step') ) : 1;
			$min = $qty.attr('min') ? parseInt( $qty.attr('min') ) : 1;
			$max = parseInt( $qty.attr('max') );

			if ( $qtyVal >= $max || $qtyVal < $min ) {
				if ( !isNaN( $max ) ) {
					$qty.val( $max );
				} else {
					$qty.val( $min );
				}
			} else {
				if ( isNaN( $qtyVal ) ) {
					$qty.val( $min );
				} else {
					$qty.val( $qtyVal + $step );
				}
			}


			if ( $cartForm.length ) {
				$qty.trigger('change');
			}
		} );

		jQuery('body').on('click', '.qty-down', function() {
			$cartForm = jQuery('form.woocommerce-cart-form');
			$qtyWrap = jQuery(this).parents('.qty-input-wrapper');

			$qty = $qtyWrap.find('input.qty');
			$qtyVal = $qty.val() ? parseInt( $qty.val() ) : 0;

			$step = $qty.attr('step') ? parseInt( $qty.attr('step') ) : 1;
			$min = $qty.attr('min') ? parseInt( $qty.attr('min') ) : 1;
			$max = parseInt( $qty.attr('max') );

			if ( $qtyVal <= $min || $qtyVal >= $max || isNaN( $qtyVal ) ) {
				$qty.val( $min );
			} else {
				$qty.val( $qtyVal - $step );
			}

			if ( $cartForm.length ) {
				$qty.trigger('change');
			}
		} );

		jQuery('body').on('blur change', 'form.woocommerce-cart-form input.qty', function(){
			$cartForm = jQuery('form.woocommerce-cart-form');

			setTimeout(function(){
				$cartForm.find('.update_cart').trigger('click');
			},300);
		})
	})();

	(function() {
		orderby = jQuery('select.orderby');

		orderby.each(function(index,html) {
			orderbyWrap = jQuery(this);
			selectedOrderLabel = jQuery('option:selected',this).text();
			selectedOrderVal = jQuery(this).val();
			orderbyWrap.css('display','none');
			orderbyParent = orderbyWrap.parent();
			jQuery("<div class='custom-orderby-wrap'><div class='selected-option'>"+selectedOrderLabel+"</div><ul class='custom-orderby'></ul></div>").insertAfter(orderbyWrap);

			orderbyWrap.children('option').each(function(index,html){
				option = jQuery(this).val();
				label = jQuery(this).html();
				selectedClass = ( option == selectedOrderVal ) ? "selected" : "";
				orderbyWrap.parent().find('.custom-orderby-wrap .custom-orderby').append("<li class='"+selectedClass+"' data-option='"+option+"'>"+label+"</li>");
			});
		});

		jQuery('body').on('click','.custom-orderby-wrap .selected-option',function(){
			jQuery(this).toggleClass('active');
			jQuery(this).next('.custom-orderby').slideToggle();
		});

		jQuery('body').on('click','.custom-orderby-wrap .custom-orderby li',function(){
			option = jQuery(this).data('option');
			label = jQuery(this).text();

			jQuery('.custom-orderby-wrap').find('.selected-option').text( label );
			orderby.val( option ).trigger('change');
		});

		/* CLOSE ON RESIZE */
		jQuery(window).on('resize',function(){
			if ( jQuery('.custom-orderby').length )
				jQuery('.custom-orderby').slideUp();
		});

	})();
});
