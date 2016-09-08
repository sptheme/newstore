<?php
/**
 * Mobile menu helper functions.
 *
 * @package newstore
 */

/*-------------------------------------------------------------------------------*/
/* Mobile Menu
/*-------------------------------------------------------------------------------*/

/**
 * Checks if header is enabled
 *
 * @since 1.0.0
 */
function has_header() {

	// Return true by default
	$return = wpsp_get_redux( 'is-enable-header', true );

	// Check meta
	$meta = get_post_meta( get_the_ID(), 'wpsp_is_display_header', true );

	// Check if disabled via meta option
	if ( $meta ) {
		$return = true;
	} elseif ( !$meta ) {
		$return = false;
	}

	// Apply filters and return
	return apply_filters( 'wpsp_display_header', $return );

}

/**
 * Returns mobile menu style
 *
 * @since 1.0.0
 */
function mobile_menu_style() {

	// Get and sanitize style
	$style = wpsp_esc_html( wpsp_get_redux( 'mobile-menu-style' ), 'sidr' );

	// Apply filters and return
	return apply_filters( 'wpsp_mobile_menu_style', $style );

}


/**
 * Check if the mobile menu is enabled or not
 *
 * @since 1.0.0
 */
function has_mobile_menu() {
	$is_has_header = has_header();
	$mobile_menu_style = mobile_menu_style();

	if ( $is_has_header && 'disabled' != $mobile_menu_style ) {
		return true;
	}
}
