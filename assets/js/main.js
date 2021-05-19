// READY
jQuery(document).on( "ready", function() {
	// CCM Required
	disableDatePickerAutoComplete();

  mobileMenuToggle();
	stickySidebar();
});

// LOAD
jQuery(window).on( "load", function() {
	adjustTopOffset();
});

// RESIZE
jQuery(window).on( "resize", function() {
	adjustTopOffset();
	stickySidebar();
});

function disableDatePickerAutoComplete() {
	jQuery('input.datepicker').prop('autocomplete','off');
  jQuery(".datepicker").attr("autocomplete", "off");
}

function adjustTopOffset() {
	var headerHeight = jQuery('header').outerHeight();

	jQuery('main#main-wrapper').css({
		'padding-top': headerHeight,
	});

	jQuery('aside#mobile-menu').css({
		'top': headerHeight,
	});
}

function stickySidebar() {

	var headerHeight = jQuery('#header').outerHeight() || 0;
	var footerHeight = jQuery('#footer').outerHeight() || 0;

	var fullHeader = headerHeight + 30;
	var fullFooter = footerHeight;

	if (Modernizr.mq('(min-width: 992px)')) {
		// Generic Sidebar Sidebar
		jQuery(".page-sidebar").sticky({
			topSpacing:fullHeader,
			bottomSpacing:fullFooter
		});
		// Woocommerce Sidebar
		jQuery(".sidebar-wrap").sticky({
			topSpacing:fullHeader,
			bottomSpacing:fullFooter
		});
	} else {
		jQuery(".page-sidebar").unstick();
		jQuery(".sidebar-wrap").unstick();
	}

}

function mobileMenuToggle() {
	var HamburgerMenu = jQuery( "[data=mobile-menu-trigger]" );

  HamburgerMenu.on( 'click', function( e ) {
		e.preventDefault();
		jQuery( this ).toggleClass( "is-active" );
		jQuery( '#mobile-menu' ).toggleClass( "active" );		
	} );
}

function mobileMenuToggleAlt() {
	var HamburgerMenu = jQuery( "[data=mobile-menu-trigger]" );
	var McBar1        = HamburgerMenu.find( "b:nth-child(1)" );
	var McBar2        = HamburgerMenu.find( "b:nth-child(2)" );
	var McBar3        = HamburgerMenu.find( "b:nth-child(3)" );
	HamburgerMenu.on( 'click', function( e ) {
		e.preventDefault();
		jQuery( this ).toggleClass( "active" );
		jQuery( '#mobile-menu' ).toggleClass( "active" );

		if ( HamburgerMenu.hasClass( "active" ) ) {
			McBar1.velocity({ top: "50%", transform: "translateY(-50%)" }, { duration: 200, easing: "swing" });
			McBar3.velocity({ top: "50%", transform: "translateY(-50%)" }, { duration: 200, easing: "swing" })
						.velocity({ rotateZ:"90deg" }, { duration: 800, delay: 200, easing: [500,20] });
			HamburgerMenu.velocity({rotateZ:"135deg"}, {duration: 800, delay: 200, easing: [500,20] });
		} else {
			jQuery( '#mobile-menu .menu li.menu-item-has-children' ).removeClass( "active" );
			HamburgerMenu.velocity("reverse");
			McBar3.velocity({ rotateZ:"0deg" }, { duration: 200, easing: [500,20] })
						.velocity({ top: "88%" }, { duration: 300, easing: "swing" });
			McBar1.velocity("reverse", {delay: 300});
		}
	} );
}