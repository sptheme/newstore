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

	$post_id = post_id();

	// Return true by default
	$return = wpsp_get_redux( 'is-enable-header', true );

	// Check meta
	$meta = get_post_meta( $post_id, 'wpsp_is_display_header', true );

	// Check if disabled via meta option
	if ( 'on' == $meta ) {
		$return = true;
	} elseif ( 'off' == $meta ) {
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

/**
 * Returns sidebar menu source
 *
 * @since 1.0.0
 */
function sidr_menu_source() {

	// Only needed for sidr menu style
	if ( 'sidr' != mobile_menu_style() ) {
		return false;
	}

	// Define array of items
	$items = array();

	// Add close button
	$items['sidrclose'] = '#sidr-close';

	// Add mobile menu alternative if defined
	if ( has_nav_menu( 'mobile_menu_alt' ) ) {
		$items['nav'] = '#mobile-menu-alternative';
	}

	// If mobile menu alternative is not defined add main navigation
	else {
		$items['nav'] = '#site-navigation';
	}

	// Add search form
	if ( wpsp_get_redux( 'is-mobile-menu-search', true ) ) {
		$items['search'] = '#mobile-menu-search';
	}

	// Apply filters for child theming
	$items = apply_filters( 'wpsp_mobile_menu_source', $items );

	// Turn items into comma seperated list and return
	return implode( ', ', $items );

}
