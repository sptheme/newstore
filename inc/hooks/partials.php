<?php
/**
 * These functions are used to load template parts (partials) when used within action hooks,
 * and they probably should never be updated or modified.
 *
 * @package newstore
 */

/*-------------------------------------------------------------------------------*/
/* #  Header
/*-------------------------------------------------------------------------------*/

/**
 * Get the header template part if enable 
 *
 * @version 1.0.0
 */
function wpsp_header() {
	if ( wpsp_get_redux( 'is-enable-header' ) ) {
		get_template_part( 'partials/header/header-layout' );	
	}
}