<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Open_Frame
 */

if ( ! open_frame_has_sidebar() ) {
	return;
}

$open_frame_sidebar_id = ( is_home() || is_archive() || is_search() ) ? 'sidebar-blog' : 'sidebar-main';
?>
<aside id="secondary" class="widget-area of-sidebar" aria-label="<?php esc_attr_e( 'Sidebar', 'open-frame' ); ?>">
	<?php dynamic_sidebar( $open_frame_sidebar_id ); ?>
</aside>
