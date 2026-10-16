<?php
/**
 * Dynamic CSS generated from Customizer settings.
 *
 * Output as an inline stylesheet attached to the main theme stylesheet so it
 * loads with correct ordering and benefits from the same cache-busting version.
 *
 * @package Open_Frame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build the dynamic CSS string from theme mods.
 *
 * @return string
 */
function open_frame_build_dynamic_css() {
	$d     = open_frame_defaults();
	$fonts = open_frame_font_choices();
	$mod   = function ( $key ) use ( $d ) {
		return get_theme_mod( $key, isset( $d[ $key ] ) ? $d[ $key ] : '' );
	};

	$body_font    = $fonts[ open_frame_sanitize_font_choice( $mod( 'open_frame_body_font' ) ) ]['stack'];
	$heading_font = $fonts[ open_frame_sanitize_font_choice( $mod( 'open_frame_heading_font' ) ) ]['stack'];

	$base_size   = open_frame_clamp( $mod( 'open_frame_base_font_size' ), 14, 22 );
	$line_height = open_frame_clamp( $mod( 'open_frame_body_line_height' ), 120, 200 ) / 100;
	$h_weight    = open_frame_clamp( $mod( 'open_frame_heading_weight' ), 400, 800 );

	$container = open_frame_clamp( $mod( 'open_frame_container_width' ), 800, 1600 );
	$content   = open_frame_clamp( $mod( 'open_frame_content_width' ), 600, 1400 );
	$section   = open_frame_clamp( $mod( 'open_frame_section_spacing' ), 16, 160 );

	$vars = array(
		'--of-color-primary'       => sanitize_hex_color( $mod( 'open_frame_color_primary' ) ),
		'--of-color-primary-hover' => sanitize_hex_color( $mod( 'open_frame_color_primary_hover' ) ),
		'--of-color-secondary'     => sanitize_hex_color( $mod( 'open_frame_color_secondary' ) ),
		'--of-color-accent'        => sanitize_hex_color( $mod( 'open_frame_color_accent' ) ),
		'--of-color-heading'       => sanitize_hex_color( $mod( 'open_frame_color_heading' ) ),
		'--of-color-text'          => sanitize_hex_color( $mod( 'open_frame_color_text' ) ),
		'--of-color-link'          => sanitize_hex_color( $mod( 'open_frame_color_link' ) ),
		'--of-color-link-hover'    => sanitize_hex_color( $mod( 'open_frame_color_link_hover' ) ),
		'--of-color-border'        => sanitize_hex_color( $mod( 'open_frame_color_border' ) ),
		'--of-color-bg'            => sanitize_hex_color( $mod( 'open_frame_color_bg' ) ),
		'--of-color-surface'       => sanitize_hex_color( $mod( 'open_frame_color_surface' ) ),
		'--of-color-focus'         => sanitize_hex_color( $mod( 'open_frame_color_primary' ) ),
		'--of-font-body'           => $body_font,
		'--of-font-heading'        => $heading_font,
		'--of-fs-body'             => $base_size . 'px',
		'--of-lh-body'             => (string) $line_height,
		'--of-fw-bold'             => (string) $h_weight,
		'--of-container-wide'      => $container . 'px',
		'--of-content-width'       => $content . 'px',
		'--of-section-spacing'     => $section . 'px',
	);

	$css = ':root{';
	foreach ( $vars as $name => $value ) {
		if ( '' === $value || null === $value ) {
			continue;
		}
		$css .= $name . ':' . $value . ';';
	}
	$css .= '}';

	// Header background.
	$header_bg = sanitize_hex_color( $mod( 'open_frame_header_bg' ) );
	if ( $header_bg ) {
		$css .= '.site-header{background-color:' . $header_bg . ';}';
	}

	// Footer colors.
	$footer_bg   = sanitize_hex_color( $mod( 'open_frame_footer_bg' ) );
	$footer_text = sanitize_hex_color( $mod( 'open_frame_footer_text' ) );
	if ( $footer_bg ) {
		$css .= '.site-footer{background-color:' . $footer_bg . ';}';
	}
	if ( $footer_text ) {
		$css .= '.site-footer{color:' . $footer_text . ';}';
	}

	return $css;
}

/**
 * Attach the dynamic CSS to the main stylesheet.
 *
 * @return void
 */
function open_frame_output_dynamic_css() {
	$css = open_frame_build_dynamic_css();
	wp_add_inline_style( 'open-frame-style', wp_strip_all_tags( $css ) );
}
add_action( 'wp_enqueue_scripts', 'open_frame_output_dynamic_css', 20 );
