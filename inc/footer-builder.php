<?php
/**
 * Footer builder: Customizer controls + render helpers.
 *
 * @package Open_Frame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register footer Customizer section.
 *
 * @param WP_Customize_Manager $wp_customize Manager.
 * @param array                $defaults     Default values.
 * @return void
 */
function open_frame_customize_footer( $wp_customize, $defaults ) {
	$wp_customize->add_section(
		'open_frame_footer',
		array(
			'title' => __( 'Footer Builder', 'open-frame' ),
			'panel' => 'open_frame_options',
		)
	);

	$wp_customize->add_setting(
		'open_frame_footer_visible',
		array(
			'default'           => $defaults['open_frame_footer_visible'],
			'sanitize_callback' => 'open_frame_sanitize_checkbox',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'open_frame_footer_visible',
		array(
			'label'   => __( 'Show footer widget area', 'open-frame' ),
			'section' => 'open_frame_footer',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'open_frame_footer_layout',
		array(
			'default'           => $defaults['open_frame_footer_layout'],
			'sanitize_callback' => 'open_frame_sanitize_select',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'open_frame_footer_layout',
		array(
			'label'   => __( 'Footer columns', 'open-frame' ),
			'section' => 'open_frame_footer',
			'type'    => 'select',
			'choices' => array(
				'1-col' => __( '1 column', 'open-frame' ),
				'2-col' => __( '2 columns', 'open-frame' ),
				'3-col' => __( '3 columns', 'open-frame' ),
				'4-col' => __( '4 columns', 'open-frame' ),
			),
		)
	);

	$wp_customize->add_setting(
		'open_frame_footer_bg',
		array(
			'default'           => $defaults['open_frame_footer_bg'],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'open_frame_footer_bg',
			array(
				'label'   => __( 'Footer background', 'open-frame' ),
				'section' => 'open_frame_footer',
			)
		)
	);

	$wp_customize->add_setting(
		'open_frame_footer_text',
		array(
			'default'           => $defaults['open_frame_footer_text'],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'open_frame_footer_text',
			array(
				'label'   => __( 'Footer text color', 'open-frame' ),
				'section' => 'open_frame_footer',
			)
		)
	);

	$wp_customize->add_setting(
		'open_frame_copyright_text',
		array(
			'default'           => $defaults['open_frame_copyright_text'],
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'open_frame_copyright_text',
		array(
			'label'       => __( 'Copyright text', 'open-frame' ),
			'description' => __( 'Leave blank for the default site name and year.', 'open-frame' ),
			'section'     => 'open_frame_footer',
			'type'        => 'textarea',
		)
	);
}

/**
 * Count active footer widget columns.
 *
 * @return int
 */
function open_frame_active_footer_columns() {
	$count = 0;
	for ( $i = 1; $i <= 4; $i++ ) {
		if ( is_active_sidebar( 'footer-' . $i ) ) {
			++$count;
		}
	}
	return $count;
}

/**
 * Output the footer widget columns, skipping empty ones.
 *
 * @return void
 */
function open_frame_footer_widgets() {
	if ( ! get_theme_mod( 'open_frame_footer_visible', true ) ) {
		return;
	}
	if ( 0 === open_frame_active_footer_columns() ) {
		return;
	}

	$layout = get_theme_mod( 'open_frame_footer_layout', '4-col' );
	$max    = (int) substr( $layout, 0, 1 );
	$max    = $max > 0 ? $max : 4;

	echo '<div class="footer-widgets footer-widgets--' . esc_attr( $layout ) . '">';
	echo '<div class="of-container footer-widgets-inner">';
	$shown = 0;
	for ( $i = 1; $i <= 4 && $shown < $max; $i++ ) {
		if ( is_active_sidebar( 'footer-' . $i ) ) {
			echo '<div class="footer-column">';
			dynamic_sidebar( 'footer-' . $i );
			echo '</div>';
			++$shown;
		}
	}
	echo '</div></div>';
}

/**
 * Output the copyright / site info bar.
 *
 * @return void
 */
function open_frame_footer_copyright() {
	$custom = get_theme_mod( 'open_frame_copyright_text', '' );

	echo '<div class="site-info"><div class="of-container site-info-inner">';
	if ( ! empty( $custom ) ) {
		echo '<div class="copyright">' . wp_kses_post( $custom ) . '</div>';
	} else {
		printf(
			'<div class="copyright">&copy; %1$s %2$s. %3$s</div>',
			esc_html( gmdate( 'Y' ) ),
			esc_html( get_bloginfo( 'name' ) ),
			esc_html__( 'All rights reserved.', 'open-frame' )
		);
	}

	if ( has_nav_menu( 'footer' ) ) {
		wp_nav_menu(
			array(
				'theme_location'       => 'footer',
				'menu_class'           => 'footer-menu',
				'container'            => 'nav',
				'container_class'      => 'footer-navigation',
				'container_aria_label' => __( 'Footer', 'open-frame' ),
				'depth'                => 1,
			)
		);
	}
	echo '</div></div>';
}
