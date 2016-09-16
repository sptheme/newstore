<?php
/**
 * Site footer helper functions.
 *
 * @package newstore
 */

/**
 * Checks if the footer is enabled
 *
 * @since 1.0.0
 */
function has_footer() {

	// Return true by default
	$return = true;

	$post_id = post_id();

	// Check page settings
	if ( $meta = get_post_meta( $post_id, 'wpsp_is_display_footer', true ) ) {
		if ( 'on' == $meta ) {
			$return = true;
		} elseif ( 'off' == $meta ) {
			$return = false;
		}
	}

	// Apply filters and return
	return apply_filters( 'wpsp_display_footer', $return );

}

/**
 * Checks if footer widgets are enabled
 *
 * @since 1.0.0
 */
function has_footer_widgets() {

	// Check if enabled via the customizer
	$return = wpsp_get_redux( 'is-footer-widgets', true );

	$post_id = post_id();

	// Check page settings
	if ( $meta = get_post_meta( $post_id, 'wpsp_is_display_footer_widgets', true ) ) {
		if ( 'on' == $meta ) {
			$return = true;
		} elseif ( 'off' == $meta ) {
			$return = false;
		}
	}

	// Apply filters and return
	return apply_filters( 'wpsp_display_footer_widgets', $return );

}