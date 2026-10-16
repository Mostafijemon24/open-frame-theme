<?php
/**
 * Asset loading.
 *
 * Fonts are loaded locally (no remote font requests) when the bundled
 * woff2 files are present in assets/fonts/. Until those files are added
 * the theme falls back to the system font stack — see assets/fonts/README.txt.
 *
 * @package Open_Frame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue frontend styles and scripts.
 *
 * @return void
 */
function open_frame_enqueue_assets() {
	$version = OPEN_FRAME_VERSION;

	// Local fonts stylesheet, only if the font files actually exist.
	if ( file_exists( OPEN_FRAME_DIR . '/assets/fonts/fonts.css' ) && open_frame_has_local_fonts() ) {
		wp_enqueue_style( 'open-frame-fonts', OPEN_FRAME_URI . '/assets/fonts/fonts.css', array(), $version );
	}

	wp_enqueue_style( 'open-frame-style', get_stylesheet_uri(), array(), $version );

	wp_enqueue_script(
		'open-frame-navigation',
		OPEN_FRAME_URI . '/assets/js/navigation.js',
		array(),
		$version,
		true
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'open_frame_enqueue_assets' );

/**
 * Whether bundled local font files are present.
 *
 * @return bool
 */
function open_frame_has_local_fonts() {
	$dir = OPEN_FRAME_DIR . '/assets/fonts';
	if ( ! is_dir( $dir ) ) {
		return false;
	}
	$fonts = glob( $dir . '/*.woff2' );
	return ! empty( $fonts );
}

/**
 * Enqueue block editor assets so the editor matches the frontend.
 *
 * @return void
 */
function open_frame_editor_assets() {
	if ( open_frame_has_local_fonts() && file_exists( OPEN_FRAME_DIR . '/assets/fonts/fonts.css' ) ) {
		add_editor_style( 'assets/fonts/fonts.css' );
	}
}
add_action( 'after_setup_theme', 'open_frame_editor_assets', 20 );
