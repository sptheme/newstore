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

/**
 * Get the header logo template part.
 *
 * @since 1.0.0
 */
function wpsp_header_logo() {
	get_template_part( 'partials/header/header-logo' );
}

/*-------------------------------------------------------------------------------*/
/* #  Page Header
/*-------------------------------------------------------------------------------*/

/**
 * Get page header template part if enabled.
 *
 * @since 1.0.0
 */
function wpsp_page_header() {
	if ( wpsp_has_page_header() ) {
		get_template_part( 'partials/page-header/page-header-layout' );
	}
}

/**
 * Get page header title template part if enabled.
 *
 * @since 1.0.0
 */
function wpsp_page_header_title() {
	if ( wpsp_has_page_header_title() ) {
		get_template_part( 'partials/page-header/page-header-title' );
	}
}

/**
 * Get post heading template part.
 *
 * @since 1.0.0
 */
function wpsp_page_header_subheading() {
	if ( wpsp_has_page_header_subheading() ) {
		get_template_part( 'partials/page-header/page-header-subheading' );
	}
}

/**
 * Open wrapper around page header content to vertical align things
 *
 * @since 1.0.0
 */
function wpsp_page_header_title_table_wrap_open() {
	if ( 'background-image' == wpsp_page_header_style() ) {
		echo '<div class="page-header-table"><div class="page-header-table-cell">';
	}
}

/**
 * Close wrapper around page header content to vertical align things
 *
 * @since 1.0.0
 */
function wpsp_page_header_title_table_wrap_close() {
	if ( 'background-image' == wpsp_page_header_style() ) {
		echo '</div></div>';
	}
}