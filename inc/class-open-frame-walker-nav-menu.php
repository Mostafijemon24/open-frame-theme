<?php
/**
 * Accessible nav menu walker with submenu toggle buttons.
 *
 * @package Open_Frame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds keyboard-accessible submenu toggles to menu items with children.
 */
class Open_Frame_Walker_Nav_Menu extends Walker_Nav_Menu {

	/**
	 * Starts the element output, injecting a toggle button before submenus.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of menu item.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int      $id     Current item ID.
	 * @return void
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$has_children = in_array( 'menu-item-has-children', (array) $item->classes, true );

		parent::start_el( $output, $item, $depth, $args, $id );

		if ( $has_children ) {
			$label  = __( 'Submenu', 'open-frame' );
			$button = sprintf(
				'<button type="button" class="of-submenu-toggle of-plain" aria-expanded="false"><span class="screen-reader-text">%s</span><span class="of-submenu-icon" aria-hidden="true"></span></button>',
				esc_html( $label )
			);

			// Insert the toggle just before the opening of the child <ul>.
			$output .= $button;
		}
	}
}
