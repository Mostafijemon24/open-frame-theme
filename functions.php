<?php
/**
 * Open Frame functions and definitions.
 *
 * Branding constants and the theme bootstrap are centralized here.
 *
 * @package Open_Frame
 * @since   0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'OPEN_FRAME_VERSION', '0.6.0' );
define( 'OPEN_FRAME_DIR', get_template_directory() );
define( 'OPEN_FRAME_URI', get_template_directory_uri() );

/**
 * Load a theme include file.
 *
 * @param string $relative Relative path from the theme root.
 * @return void
 */
function open_frame_require( $relative ) {
	$path = OPEN_FRAME_DIR . '/' . ltrim( $relative, '/' );
	if ( is_readable( $path ) ) {
		require_once $path;
	}
}

open_frame_require( 'inc/setup.php' );
open_frame_require( 'inc/enqueue.php' );
open_frame_require( 'inc/template-tags.php' );
open_frame_require( 'inc/template-functions.php' );
open_frame_require( 'inc/class-open-frame-walker-nav-menu.php' );
open_frame_require( 'inc/customizer/sanitize.php' );
open_frame_require( 'inc/customizer/customizer.php' );
open_frame_require( 'inc/customizer/dynamic-css.php' );
open_frame_require( 'inc/header-builder.php' );
open_frame_require( 'inc/footer-builder.php' );
open_frame_require( 'inc/blocks.php' );
