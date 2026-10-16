<?php
/**
 * Template functions: body classes, layout resolution, misc hooks.
 *
 * @package Open_Frame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Resolve the active sidebar layout for the current view.
 *
 * @return string One of: right-sidebar, left-sidebar, no-sidebar, full-width.
 */
function open_frame_get_layout() {
	$default = get_theme_mod( 'open_frame_default_layout', 'right-sidebar' );

	if ( is_page() ) {
		$default = get_theme_mod( 'open_frame_page_layout', $default );
		if ( is_page_template( 'templates/full-width.php' ) ) {
			$default = 'full-width';
		}
	} elseif ( is_singular( 'post' ) ) {
		$default = get_theme_mod( 'open_frame_single_layout', $default );
	} elseif ( is_home() || is_archive() || is_search() ) {
		$default = get_theme_mod( 'open_frame_blog_layout', $default );
	}

	$layout  = apply_filters( 'open_frame_layout', $default );
	$allowed = array( 'right-sidebar', 'left-sidebar', 'no-sidebar', 'full-width' );

	return in_array( $layout, $allowed, true ) ? $layout : 'right-sidebar';
}

/**
 * Whether the active layout shows a sidebar and one has widgets.
 *
 * @return bool
 */
function open_frame_has_sidebar() {
	$layout = open_frame_get_layout();
	if ( in_array( $layout, array( 'no-sidebar', 'full-width' ), true ) ) {
		return false;
	}

	$sidebar = ( is_home() || is_archive() || is_search() ) ? 'sidebar-blog' : 'sidebar-main';
	return is_active_sidebar( $sidebar );
}

/**
 * CSS classes for the main layout wrapper.
 *
 * @return string
 */
function open_frame_layout_classes() {
	$layout  = open_frame_get_layout();
	$classes = array( 'of-layout' );

	if ( open_frame_has_sidebar() ) {
		$classes[] = 'of-layout--has-sidebar';
		$classes[] = 'of-layout--' . $layout;
	} else {
		$classes[] = 'of-layout--no-sidebar';
	}

	return implode( ' ', array_map( 'sanitize_html_class', $classes ) );
}

/**
 * Add helpful classes to the body element.
 *
 * @param array $classes Existing classes.
 * @return array
 */
function open_frame_body_classes( $classes ) {
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	$classes[] = 'layout-' . open_frame_get_layout();

	if ( 'boxed' === get_theme_mod( 'open_frame_site_layout', 'full' ) ) {
		$classes[] = 'boxed-layout';
	}

	if ( ! open_frame_has_sidebar() ) {
		$classes[] = 'no-sidebar';
	}

	if ( get_theme_mod( 'open_frame_sticky_header', false ) ) {
		$classes[] = 'has-sticky-header';
	}

	return $classes;
}
add_filter( 'body_class', 'open_frame_body_classes' );

/**
 * Add a pingback url when the site is set to accept them.
 *
 * @return void
 */
function open_frame_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'open_frame_pingback_header' );

/**
 * Use a custom excerpt "more" string.
 *
 * @param string $more Default more string.
 * @return string
 */
function open_frame_excerpt_more( $more ) {
	return is_admin() ? $more : '&hellip;';
}
add_filter( 'excerpt_more', 'open_frame_excerpt_more' );

/**
 * Apply the Customizer-controlled excerpt length.
 *
 * @param int $length Default length.
 * @return int
 */
function open_frame_excerpt_length( $length ) {
	if ( is_admin() ) {
		return $length;
	}
	$custom = (int) get_theme_mod( 'open_frame_excerpt_length', 30 );
	return open_frame_clamp( $custom, 5, 80 );
}
add_filter( 'excerpt_length', 'open_frame_excerpt_length', 999 );

/**
 * CSS classes for the posts listing container based on Customizer settings.
 *
 * @return string
 */
function open_frame_posts_grid_classes() {
	$style   = get_theme_mod( 'open_frame_blog_style', 'list' );
	$style   = in_array( $style, array( 'list', 'grid' ), true ) ? $style : 'list';
	$classes = array( 'posts-grid', 'posts-grid--' . $style );

	if ( 'grid' === $style ) {
		$cols      = open_frame_clamp( (int) get_theme_mod( 'open_frame_blog_columns', 2 ), 2, 4 );
		$classes[] = 'posts-grid--cols-' . $cols;
	}

	return implode( ' ', array_map( 'sanitize_html_class', $classes ) );
}
