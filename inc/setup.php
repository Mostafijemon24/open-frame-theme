<?php
/**
 * Theme setup: supports, menus, sidebars, image sizes.
 *
 * @package Open_Frame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register theme supports and features.
 *
 * @return void
 */
function open_frame_setup() {
	load_theme_textdomain( 'open-frame', OPEN_FRAME_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor.css' );

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
			'navigation-widgets',
		)
	);

	add_theme_support(
		'custom-logo',
		array(
			'height'               => 48,
			'width'                => 180,
			'flex-height'          => true,
			'flex-width'           => true,
			'unlink-homepage-logo' => true,
		)
	);

	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'f8fafc',
		)
	);

	register_nav_menus(
		array(
			'primary'   => __( 'Primary Menu', 'open-frame' ),
			'secondary' => __( 'Secondary Menu', 'open-frame' ),
			'footer'    => __( 'Footer Menu', 'open-frame' ),
		)
	);

	// Editor image sizes aligned with the design system aspect ratios.
	add_image_size( 'open-frame-card', 720, 480, true );
	add_image_size( 'open-frame-wide', 1200, 630, true );
}
add_action( 'after_setup_theme', 'open_frame_setup' );

/**
 * Set the content width in pixels.
 *
 * @return void
 */
function open_frame_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'open_frame_content_width', 960 );
}
add_action( 'after_setup_theme', 'open_frame_content_width', 0 );

/**
 * Register widget areas.
 *
 * @return void
 */
function open_frame_widgets_init() {
	$defaults = array(
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	);

	register_sidebar(
		array(
			'name'        => __( 'Main Sidebar', 'open-frame' ),
			'id'          => 'sidebar-main',
			'description' => __( 'Appears on posts and pages that use a sidebar layout.', 'open-frame' ),
		) + $defaults
	);

	register_sidebar(
		array(
			'name'        => __( 'Blog Sidebar', 'open-frame' ),
			'id'          => 'sidebar-blog',
			'description' => __( 'Appears on the blog index and archives.', 'open-frame' ),
		) + $defaults
	);

	for ( $i = 1; $i <= 4; $i++ ) {
		register_sidebar(
			array(
				/* translators: %d: footer widget column number. */
				'name'        => sprintf( __( 'Footer %d', 'open-frame' ), $i ),
				'id'          => 'footer-' . $i,
				'description' => __( 'Footer widget column. Empty columns are hidden automatically.', 'open-frame' ),
			) + $defaults
		);
	}
}
add_action( 'widgets_init', 'open_frame_widgets_init' );
