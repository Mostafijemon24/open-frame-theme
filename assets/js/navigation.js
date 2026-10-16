/**
 * Open Frame accessible navigation.
 *
 * - Toggles the mobile menu with correct aria-expanded state.
 * - Adds click + keyboard support for submenu toggle buttons.
 * - Closes open submenus on Escape and on outside click.
 */
( function () {
	'use strict';

	function setupMobileToggle() {
		var toggle = document.querySelector( '.menu-toggle' );
		var nav = document.getElementById( 'site-navigation' );
		if ( ! toggle || ! nav ) {
			return;
		}

		toggle.addEventListener( 'click', function () {
			var expanded = toggle.getAttribute( 'aria-expanded' ) === 'true';
			toggle.setAttribute( 'aria-expanded', String( ! expanded ) );
			nav.classList.toggle( 'is-open', ! expanded );
		} );

		document.addEventListener( 'keydown', function ( event ) {
			if ( event.key === 'Escape' && nav.classList.contains( 'is-open' ) ) {
				toggle.setAttribute( 'aria-expanded', 'false' );
				nav.classList.remove( 'is-open' );
				toggle.focus();
			}
		} );
	}

	function setupSubmenus() {
		var toggles = document.querySelectorAll( '.of-submenu-toggle' );
		Array.prototype.forEach.call( toggles, function ( btn ) {
			btn.addEventListener( 'click', function ( event ) {
				event.preventDefault();
				var expanded = btn.getAttribute( 'aria-expanded' ) === 'true';
				btn.setAttribute( 'aria-expanded', String( ! expanded ) );
				var parent = btn.closest( '.menu-item-has-children' );
				if ( parent ) {
					parent.classList.toggle( 'submenu-open', ! expanded );
				}
			} );
		} );
	}

	function closeOnOutsideClick() {
		document.addEventListener( 'click', function ( event ) {
			var open = document.querySelectorAll( '.menu-item-has-children.submenu-open' );
			Array.prototype.forEach.call( open, function ( item ) {
				if ( ! item.contains( event.target ) ) {
					item.classList.remove( 'submenu-open' );
					var btn = item.querySelector( '.of-submenu-toggle' );
					if ( btn ) {
						btn.setAttribute( 'aria-expanded', 'false' );
					}
				}
			} );
		} );
	}

	if ( document.readyState !== 'loading' ) {
		setupMobileToggle();
		setupSubmenus();
		closeOnOutsideClick();
	} else {
		document.addEventListener( 'DOMContentLoaded', function () {
			setupMobileToggle();
			setupSubmenus();
			closeOnOutsideClick();
		} );
	}
}() );
