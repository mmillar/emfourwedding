/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and 
 * then make any necessary changes to the page using jQuery.
 */
( function( $ ) {

	// Update the site title in real time...
	wp.customize( 'blogname', function( value ) {
		value.bind( function( newval ) {
			$( '#logo a' ).html( newval );
		} );
	} );
	
	//Update the site description in real time...
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( newval ) {
			$( '#logo p' ).html( newval );
		} );
	} );

	//Update site background color...
	wp.customize( 'stag_framework_values[style_background_color]', function( value ) {
		value.bind( function( newval ) {
			$('body').css('background-color', newval );
		} );
	} );
	
	//Update site accent color
	wp.customize( 'stag_framework_values[accent_color]', function( value ) {
		value.bind( function( newval ) {
			$('.accent-color, a, .wedding-couple-wrap h2, [class*="icon-"], [data-icon]:before, .hentry:before, .countdown_section:before, .section-title, #reply-title,h3#comments,.comment-author, .commentlist li:after, .entry-content h2,.stag-toggle .ui-state-active,.stag-tabs ul.stag-nav .ui-state-active a,.stag-divider.plain:after, .section-divider:after').css('color', newval );
			$('.wedding-couple-wrap .person-info:first-child:before, .meta-data,.accent-background, #navigation, #primary-menu ul,#mobile-nav,#mobile-primary-nav,input[type="submit"], button, .button, .stag-button, .countdown_section, .nav-next a, .nav-prev a, .page-numbers, blockquote, .person-info:first-child:after').css('background-color', newval );
		} );
	} );
	
} )( jQuery );
