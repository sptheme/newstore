<?php
/**
 * Site header helper functions.
 *
 * @package newstore
 */

/**
 * Returns header logo title
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_header_logo_title' ) ) :
function wpsp_header_logo_title() {
	$title = get_bloginfo( 'name' );
	$title = apply_filters( 'wpsp_logo_title', $title );
	return $title;
}
endif;

/**
 * Returns header logo URL
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_header_logo_url' ) ) :
function wpsp_header_logo_url() {
	$url = esc_url( home_url( '/' ) );
	$url = apply_filters( 'wpsp_logo_url', $url );
	return $url;
}
endif;

/**
 * Header logo classes
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_header_logo_classes' ) ) :
function wpsp_header_logo_classes() {

	// Define classes array
	$classes = array( 'site-branding' );

	// Default class
	$classes[] = 'header-'. wpsp_get_redux( 'header-style' ) .'-logo';

	// Apply filters for child theming
	$classes = apply_filters( 'wpsp_header_logo_classes', $classes );

	// Turn classes into space seperated string
	$classes = implode( ' ', $classes );

	// Return classes
	return $classes;

}
endif; 

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
