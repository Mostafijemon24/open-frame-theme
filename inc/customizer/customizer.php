<?php
/**
 * Theme Customizer registration.
 *
 * Every control registered here produces a real, verifiable effect on the
 * frontend through inc/customizer/dynamic-css.php or template logic.
 *
 * @package Open_Frame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Available font family choices.
 *
 * @return array<string,array{label:string,stack:string}>
 */
function open_frame_font_choices() {
	return array(
		'hanken' => array(
			'label' => __( 'Hanken Grotesk (default)', 'open-frame' ),
			'stack' => '"Hanken Grotesk", system-ui, -apple-system, "Segoe UI", roboto, helvetica, arial, sans-serif',
		),
		'system' => array(
			'label' => __( 'System UI', 'open-frame' ),
			'stack' => 'system-ui, -apple-system, "Segoe UI", roboto, helvetica, arial, sans-serif',
		),
		'serif'  => array(
			'label' => __( 'Serif', 'open-frame' ),
			'stack' => 'Georgia, "Times New Roman", serif',
		),
		'mono'   => array(
			'label' => __( 'Monospace', 'open-frame' ),
			'stack' => '"JetBrains Mono", ui-monospace, menlo, monospace',
		),
	);
}

/**
 * Default values used across Customizer and dynamic CSS.
 *
 * @return array<string,mixed>
 */
function open_frame_defaults() {
	return array(
		'open_frame_site_layout'         => 'full',
		'open_frame_container_width'     => 1200,
		'open_frame_content_width'       => 960,
		'open_frame_section_spacing'     => 64,
		'open_frame_default_layout'      => 'right-sidebar',
		'open_frame_blog_style'          => 'list',
		'open_frame_blog_columns'        => 2,
		'open_frame_excerpt_length'      => 30,
		'open_frame_blog_layout'         => 'right-sidebar',
		'open_frame_single_layout'       => 'right-sidebar',
		'open_frame_page_layout'         => 'no-sidebar',

		'open_frame_color_primary'       => '#3f4cd6',
		'open_frame_color_primary_hover' => '#2b36b8',
		'open_frame_color_secondary'     => '#14b8a6',
		'open_frame_color_accent'        => '#f5a623',
		'open_frame_color_heading'       => '#0f172a',
		'open_frame_color_text'          => '#0f172a',
		'open_frame_color_link'          => '#3f4cd6',
		'open_frame_color_link_hover'    => '#2b36b8',
		'open_frame_color_border'        => '#e2e8f0',
		'open_frame_color_bg'            => '#f8fafc',
		'open_frame_color_surface'       => '#ffffff',

		'open_frame_body_font'           => 'hanken',
		'open_frame_heading_font'        => 'hanken',
		'open_frame_base_font_size'      => 16,
		'open_frame_body_line_height'    => 160,
		'open_frame_heading_weight'      => 700,

		'open_frame_header_layout'       => 'logo-left-menu-right',
		'open_frame_header_bg'           => '#ffffff',
		'open_frame_sticky_header'       => false,
		'open_frame_transparent_header'  => false,
		'open_frame_header_search'       => false,

		'open_frame_footer_layout'       => '4-col',
		'open_frame_footer_bg'           => '#0f172a',
		'open_frame_footer_text'         => '#cbd5e1',
		'open_frame_footer_visible'      => true,
		'open_frame_copyright_text'      => '',
	);
}

/**
 * Register Customizer panels, sections, settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 * @return void
 */
function open_frame_customize_register( $wp_customize ) {
	$defaults = open_frame_defaults();

	// Live preview for core blogname / blogdescription.
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	$wp_customize->add_panel(
		'open_frame_options',
		array(
			'title'    => __( 'Open Frame Options', 'open-frame' ),
			'priority' => 20,
		)
	);

	// ---- General / Layout ------------------------------------------------.
	$wp_customize->add_section(
		'open_frame_layout',
		array(
			'title' => __( 'Layout', 'open-frame' ),
			'panel' => 'open_frame_options',
		)
	);

	$wp_customize->add_setting(
		'open_frame_site_layout',
		array(
			'default'           => $defaults['open_frame_site_layout'],
			'sanitize_callback' => 'open_frame_sanitize_select',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'open_frame_site_layout',
		array(
			'label'   => __( 'Site layout', 'open-frame' ),
			'section' => 'open_frame_layout',
			'type'    => 'select',
			'choices' => array(
				'full'  => __( 'Full width', 'open-frame' ),
				'boxed' => __( 'Boxed', 'open-frame' ),
			),
		)
	);

	$ranges = array(
		'open_frame_container_width' => array( __( 'Container width (px)', 'open-frame' ), 800, 1600 ),
		'open_frame_content_width'   => array( __( 'Content width (px)', 'open-frame' ), 600, 1400 ),
		'open_frame_section_spacing' => array( __( 'Section spacing (px)', 'open-frame' ), 16, 160 ),
	);
	foreach ( $ranges as $id => $range ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $defaults[ $id ],
				'sanitize_callback' => 'open_frame_sanitize_int',
				'transport'         => 'postMessage',
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'       => $range[0],
				'section'     => 'open_frame_layout',
				'type'        => 'number',
				'input_attrs' => array(
					'min'  => $range[1],
					'max'  => $range[2],
					'step' => 4,
				),
			)
		);
	}

	// Blog listing style.
	$wp_customize->add_setting(
		'open_frame_blog_style',
		array(
			'default'           => $defaults['open_frame_blog_style'],
			'sanitize_callback' => 'open_frame_sanitize_select',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'open_frame_blog_style',
		array(
			'label'   => __( 'Blog listing style', 'open-frame' ),
			'section' => 'open_frame_layout',
			'type'    => 'select',
			'choices' => array(
				'list' => __( 'List', 'open-frame' ),
				'grid' => __( 'Grid', 'open-frame' ),
			),
		)
	);

	$wp_customize->add_setting(
		'open_frame_blog_columns',
		array(
			'default'           => $defaults['open_frame_blog_columns'],
			'sanitize_callback' => 'open_frame_sanitize_int',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'open_frame_blog_columns',
		array(
			'label'       => __( 'Grid columns', 'open-frame' ),
			'description' => __( 'Applies when the blog listing style is Grid.', 'open-frame' ),
			'section'     => 'open_frame_layout',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 2,
				'max'  => 4,
				'step' => 1,
			),
		)
	);

	$wp_customize->add_setting(
		'open_frame_excerpt_length',
		array(
			'default'           => $defaults['open_frame_excerpt_length'],
			'sanitize_callback' => 'open_frame_sanitize_int',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'open_frame_excerpt_length',
		array(
			'label'       => __( 'Excerpt length (words)', 'open-frame' ),
			'section'     => 'open_frame_layout',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 5,
				'max'  => 80,
				'step' => 1,
			),
		)
	);

	$layout_choices  = array(
		'right-sidebar' => __( 'Right sidebar', 'open-frame' ),
		'left-sidebar'  => __( 'Left sidebar', 'open-frame' ),
		'no-sidebar'    => __( 'No sidebar', 'open-frame' ),
		'full-width'    => __( 'Full width', 'open-frame' ),
	);
	$layout_settings = array(
		'open_frame_blog_layout'   => __( 'Blog / archive layout', 'open-frame' ),
		'open_frame_single_layout' => __( 'Single post layout', 'open-frame' ),
		'open_frame_page_layout'   => __( 'Default page layout', 'open-frame' ),
	);
	foreach ( $layout_settings as $id => $label ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $defaults[ $id ],
				'sanitize_callback' => 'open_frame_sanitize_select',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'   => $label,
				'section' => 'open_frame_layout',
				'type'    => 'select',
				'choices' => $layout_choices,
			)
		);
	}

	// ---- Colors ----------------------------------------------------------.
	$wp_customize->add_section(
		'open_frame_colors',
		array(
			'title' => __( 'Global Colors', 'open-frame' ),
			'panel' => 'open_frame_options',
		)
	);

	$colors = array(
		'open_frame_color_primary'       => __( 'Primary', 'open-frame' ),
		'open_frame_color_primary_hover' => __( 'Primary (hover)', 'open-frame' ),
		'open_frame_color_secondary'     => __( 'Secondary', 'open-frame' ),
		'open_frame_color_accent'        => __( 'Accent', 'open-frame' ),
		'open_frame_color_heading'       => __( 'Headings', 'open-frame' ),
		'open_frame_color_text'          => __( 'Body text', 'open-frame' ),
		'open_frame_color_link'          => __( 'Links', 'open-frame' ),
		'open_frame_color_link_hover'    => __( 'Link hover', 'open-frame' ),
		'open_frame_color_border'        => __( 'Borders', 'open-frame' ),
		'open_frame_color_bg'            => __( 'Page background', 'open-frame' ),
		'open_frame_color_surface'       => __( 'Surfaces', 'open-frame' ),
	);
	foreach ( $colors as $id => $label ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $defaults[ $id ],
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'postMessage',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$id,
				array(
					'label'   => $label,
					'section' => 'open_frame_colors',
				)
			)
		);
	}

	// ---- Typography ------------------------------------------------------.
	$wp_customize->add_section(
		'open_frame_typography',
		array(
			'title' => __( 'Typography', 'open-frame' ),
			'panel' => 'open_frame_options',
		)
	);

	$font_labels = array();
	foreach ( open_frame_font_choices() as $key => $data ) {
		$font_labels[ $key ] = $data['label'];
	}

	foreach ( array(
		'open_frame_body_font'    => __( 'Body font', 'open-frame' ),
		'open_frame_heading_font' => __( 'Heading font', 'open-frame' ),
	) as $id => $label ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $defaults[ $id ],
				'sanitize_callback' => 'open_frame_sanitize_font_choice',
				'transport'         => 'postMessage',
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'   => $label,
				'section' => 'open_frame_typography',
				'type'    => 'select',
				'choices' => $font_labels,
			)
		);
	}

	$type_numbers = array(
		'open_frame_base_font_size'   => array( __( 'Base font size (px)', 'open-frame' ), 14, 22, 1 ),
		'open_frame_body_line_height' => array( __( 'Body line height (%)', 'open-frame' ), 120, 200, 5 ),
		'open_frame_heading_weight'   => array( __( 'Heading weight', 'open-frame' ), 400, 800, 100 ),
	);
	foreach ( $type_numbers as $id => $range ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $defaults[ $id ],
				'sanitize_callback' => 'open_frame_sanitize_int',
				'transport'         => 'postMessage',
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'       => $range[0],
				'section'     => 'open_frame_typography',
				'type'        => 'number',
				'input_attrs' => array(
					'min'  => $range[1],
					'max'  => $range[2],
					'step' => $range[3],
				),
			)
		);
	}

	// ---- Header (handled by header-builder.php) --------------------------.
	open_frame_customize_header( $wp_customize, $defaults );

	// ---- Footer (handled by footer-builder.php) --------------------------.
	open_frame_customize_footer( $wp_customize, $defaults );
}
add_action( 'customize_register', 'open_frame_customize_register' );

/**
 * Enqueue the Customizer live-preview script.
 *
 * @return void
 */
function open_frame_customize_preview_js() {
	wp_enqueue_script(
		'open-frame-customize-preview',
		OPEN_FRAME_URI . '/assets/js/customize-preview.js',
		array( 'customize-preview' ),
		OPEN_FRAME_VERSION,
		true
	);
}
add_action( 'customize_preview_init', 'open_frame_customize_preview_js' );
