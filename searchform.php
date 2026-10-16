<?php
/**
 * Custom search form.
 *
 * @package Open_Frame
 */

$open_frame_unique = wp_unique_id( 'search-field-' );
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo esc_attr( $open_frame_unique ); ?>" class="screen-reader-text"><?php esc_html_e( 'Search for:', 'open-frame' ); ?></label>
	<input type="search" id="<?php echo esc_attr( $open_frame_unique ); ?>" class="search-field" placeholder="<?php echo esc_attr_x( 'Search&hellip;', 'placeholder', 'open-frame' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	<button type="submit" class="search-submit"><?php echo esc_html_x( 'Search', 'submit button', 'open-frame' ); ?></button>
</form>
