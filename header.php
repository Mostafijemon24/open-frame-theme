<?php
/**
 * The header for the theme.
 *
 * @package Open_Frame
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'open-frame' ); ?></a>

	<?php
	$open_frame_header_layout      = get_theme_mod( 'open_frame_header_layout', 'logo-left-menu-right' );
	$open_frame_header_transparent = get_theme_mod( 'open_frame_transparent_header', false ) && is_front_page();
	$open_frame_header_classes     = array(
		'site-header',
		'header-layout-' . sanitize_html_class( $open_frame_header_layout ),
	);
	if ( get_theme_mod( 'open_frame_sticky_header', false ) ) {
		$open_frame_header_classes[] = 'is-sticky';
	}
	if ( $open_frame_header_transparent ) {
		$open_frame_header_classes[] = 'is-transparent';
	}
	?>

	<header id="masthead" class="<?php echo esc_attr( implode( ' ', $open_frame_header_classes ) ); ?>">
		<div class="of-container site-header-inner">
			<?php
			open_frame_site_branding();
			open_frame_primary_nav();
			open_frame_header_search();
			?>
		</div>
	</header>

	<div id="content" class="site-content">
