<?php
/**
 * Core theme functions
 *
 * These functions are used throughout the theme and must be loaded
 * early on.
 *
 * @package WPSP_Blog
 */

/*-------------------------------------------------------------------------------*/
/* General
/*-------------------------------------------------------------------------------*/

/**
 * Get Theme Branding
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_get_theme_branding' ) ) :
function wpsp_get_theme_branding( $branding = true ) {
	$fullname = THEME_BRANDING;		
	$prefix = THEME_BRANDING_PREFIX;
	if ( $branding ) {
		return $fullname;
	} else {
		return $prefix;
	}
}
endif;

/**
 * Returns theme options value from redux framework
 *
 * @since 1.0.0
 */
if ( ! function_exists('wpsp_get_redux') ) :
function wpsp_get_redux( $id, $default = '' ) {

	// Get global object
	global $redux_wpsp;

	// Return data from global object
	if ( ! empty( $redux_wpsp ) ) {

		// Return value
		if ( isset( $redux_wpsp[$id] ) ) {
			return $redux_wpsp[$id];
		}

		// Return default
		else {
			return $default;
		}

	}

	else {
		return $default;
	}

}
endif;