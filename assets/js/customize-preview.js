/**
 * Open Frame Customizer live preview.
 *
 * Applies postMessage settings instantly by updating CSS custom properties,
 * so color, typography and layout changes are visible without a full refresh.
 */
( function ( $ ) {
	'use strict';

	if ( typeof wp === 'undefined' || ! wp.customize ) {
		return;
	}

	var root = document.documentElement;

	function cssVar( name, value ) {
		root.style.setProperty( name, value );
	}

	// Site title & description.
	wp.customize( 'blogname', function ( value ) {
		value.bind( function ( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function ( value ) {
		value.bind( function ( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	var colorMap = {
		open_frame_color_primary: '--of-color-primary',
		open_frame_color_primary_hover: '--of-color-primary-hover',
		open_frame_color_secondary: '--of-color-secondary',
		open_frame_color_accent: '--of-color-accent',
		open_frame_color_heading: '--of-color-heading',
		open_frame_color_text: '--of-color-text',
		open_frame_color_link: '--of-color-link',
		open_frame_color_link_hover: '--of-color-link-hover',
		open_frame_color_border: '--of-color-border',
		open_frame_color_bg: '--of-color-bg',
		open_frame_color_surface: '--of-color-surface'
	};

	Object.keys( colorMap ).forEach( function ( setting ) {
		wp.customize( setting, function ( value ) {
			value.bind( function ( to ) {
				if ( to ) {
					cssVar( colorMap[ setting ], to );
				}
			} );
		} );
	} );

	wp.customize( 'open_frame_base_font_size', function ( value ) {
		value.bind( function ( to ) {
			cssVar( '--of-fs-body', parseInt( to, 10 ) + 'px' );
		} );
	} );

	wp.customize( 'open_frame_body_line_height', function ( value ) {
		value.bind( function ( to ) {
			cssVar( '--of-lh-body', String( parseInt( to, 10 ) / 100 ) );
		} );
	} );

	wp.customize( 'open_frame_heading_weight', function ( value ) {
		value.bind( function ( to ) {
			cssVar( '--of-fw-bold', String( parseInt( to, 10 ) ) );
		} );
	} );

	wp.customize( 'open_frame_container_width', function ( value ) {
		value.bind( function ( to ) {
			cssVar( '--of-container-wide', parseInt( to, 10 ) + 'px' );
		} );
	} );

	wp.customize( 'open_frame_content_width', function ( value ) {
		value.bind( function ( to ) {
			cssVar( '--of-content-width', parseInt( to, 10 ) + 'px' );
		} );
	} );

	wp.customize( 'open_frame_section_spacing', function ( value ) {
		value.bind( function ( to ) {
			cssVar( '--of-section-spacing', parseInt( to, 10 ) + 'px' );
		} );
	} );

	wp.customize( 'open_frame_header_bg', function ( value ) {
		value.bind( function ( to ) {
			$( '.site-header' ).css( 'background-color', to );
		} );
	} );

	wp.customize( 'open_frame_footer_bg', function ( value ) {
		value.bind( function ( to ) {
			$( '.site-footer' ).css( 'background-color', to );
		} );
	} );

	wp.customize( 'open_frame_footer_text', function ( value ) {
		value.bind( function ( to ) {
			$( '.site-footer' ).css( 'color', to );
		} );
	} );
}( jQuery ) );
