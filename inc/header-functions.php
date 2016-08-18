<?php
/**
 * Site header helper functions.
 *
 * @package newstore
 */ 

/**
 * Add classes to the header wrap
 *
 * @since 1.0.0
 */
function wpsp_header_classes() {

	$classes = array();

	// Full width header
	if ( wpsp_get_redux( 'is-full-width-header' ) ) {
		$classes[] = 'wpsp-full-width';
	}

	// Set keys equal to vals
	$classes = array_combine( $classes, $classes );

	// Turn classes into space seperated string
	$classes = implode( ' ', $classes );

	$classes = apply_filters( 'wpsp_header_classes', $classes );

	return $classes;
}
