<?php
/**
 * Block styles and patterns (transition-to-block enhancements).
 *
 * @package Open_Frame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register custom block styles.
 *
 * @return void
 */
function open_frame_register_block_styles() {
	if ( ! function_exists( 'register_block_style' ) ) {
		return;
	}

	register_block_style(
		'core/quote',
		array(
			'name'  => 'open-frame-card',
			'label' => __( 'Card', 'open-frame' ),
		)
	);

	register_block_style(
		'core/button',
		array(
			'name'  => 'open-frame-soft',
			'label' => __( 'Soft', 'open-frame' ),
		)
	);

	register_block_style(
		'core/image',
		array(
			'name'  => 'open-frame-shadow',
			'label' => __( 'Shadow', 'open-frame' ),
		)
	);
}
add_action( 'init', 'open_frame_register_block_styles' );

/**
 * Register a block pattern category and a starter pattern.
 *
 * @return void
 */
function open_frame_register_block_patterns() {
	if ( ! function_exists( 'register_block_pattern' ) ) {
		return;
	}

	if ( function_exists( 'register_block_pattern_category' ) ) {
		register_block_pattern_category(
			'open-frame',
			array( 'label' => __( 'Open Frame', 'open-frame' ) )
		);
	}

	register_block_pattern(
		'open-frame/hero',
		array(
			'title'      => __( 'Open Frame hero', 'open-frame' ),
			'categories' => array( 'open-frame', 'banner' ),
			'content'    => '<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}}} -->'
				. '<div class="wp-block-group alignwide" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">'
				. '<!-- wp:heading {"level":1} --><h1 class="wp-block-heading">' . esc_html__( 'Build anything, beautifully', 'open-frame' ) . '</h1><!-- /wp:heading -->'
				. '<!-- wp:paragraph {"fontSize":"large"} --><p class="has-large-font-size">' . esc_html__( 'A clean, accessible multipurpose theme with a token-driven design system.', 'open-frame' ) . '</p><!-- /wp:paragraph -->'
				. '<!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button">' . esc_html__( 'Get started', 'open-frame' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons -->'
				. '</div><!-- /wp:group -->',
		)
	);
}
add_action( 'init', 'open_frame_register_block_patterns' );
