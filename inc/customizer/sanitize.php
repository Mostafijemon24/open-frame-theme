<?php
/**
 * Customizer sanitization callbacks.
 *
 * @package Open_Frame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sanitize a checkbox value.
 *
 * @param mixed $checked Incoming value.
 * @return bool
 */
function open_frame_sanitize_checkbox( $checked ) {
	return ( isset( $checked ) && true === (bool) $checked );
}

/**
 * Sanitize a value against a whitelist derived from the control choices.
 *
 * @param string               $input   Incoming value.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string
 */
function open_frame_sanitize_select( $input, $setting ) {
	$input   = sanitize_key( $input );
	$control = $setting->manager->get_control( $setting->id );
	$choices = ( $control && isset( $control->choices ) ) ? array_keys( $control->choices ) : array();

	return in_array( $input, $choices, true ) ? $input : $setting->default;
}

/**
 * Sanitize an integer within optional bounds stored on the setting default.
 *
 * @param mixed                $input   Incoming value.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return int
 */
function open_frame_sanitize_int( $input, $setting ) {
	$input = absint( $input );
	return $input ? $input : absint( $setting->default );
}

/**
 * Clamp a number between min and max.
 *
 * @param int $value Value.
 * @param int $min   Minimum.
 * @param int $max   Maximum.
 * @return int
 */
function open_frame_clamp( $value, $min, $max ) {
	$value = (int) $value;
	return max( $min, min( $max, $value ) );
}

/**
 * Sanitize a font family stack choice by mapping to a known set.
 *
 * @param string $input Incoming value.
 * @return string
 */
function open_frame_sanitize_font_choice( $input ) {
	$input = sanitize_text_field( $input );
	return array_key_exists( $input, open_frame_font_choices() ) ? $input : 'hanken';
}
