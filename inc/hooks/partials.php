<?php
/**
 * These functions are used to load template parts (partials) when used within action hooks,
 * and they probably should never be updated or modified.
 *
 * @package newstore
 */

/*-------------------------------------------------------------------------------*/
/* #  Header logo + main navigation
/*-------------------------------------------------------------------------------*/

/**
 * Get the header template part if enable 
 *
 * @version 1.0.0
 */
function wpsp_header() {
	if ( has_header() ) {
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

/**
 * Get header search dropdown template part.
 *
 * @since 1.0.0
 */
function wpsp_search_dropdown() {

	// Make sure site is set to dropdown style
	if ( 'drop_down' != wpsp_get_redux( 'menu-search-style' ) ) {
		return;
	}

	// Get header style
	$header_style = wpsp_get_redux( 'header-style' );

	// Get current filter
	$filter = current_filter();

	// Set get variable to false by default
	$get = false;

	// Check current filter against header style
	if ( 'wpsp_hook_header_inner' == $filter ) {
		if ( 'one' == $header_style || 'five' == $header_style ) {
			$get = true;
		}
	} elseif ( 'wpsp_hook_main_menu_bottom' == $filter ) {
		if ( 'two' == $header_style || 'three' == $header_style || 'four' == $header_style ) {
			$get = true;
		}
	}

	// Get search dropdown template part
	if ( $get ) {
		get_template_part( 'partials/header/header-search-dropdown' );
	}

}

/**
 * Get header search replace template part.
 *
 * @since 1.0.0
 */
function wpsp_search_header_replace() {
	if ( 'header_replace' == wpsp_get_redux( 'menu-search-style' ) ) {
		get_template_part( 'partials/header/header-search-replace' );
	}
}

/**
 * Gets header search overlay template part.
 *
 * @since 1.0.0
 */
function wpsp_search_overlay() {
	if ( 'overlay' == wpsp_get_redux( 'menu-search-style' ) ) {
		get_template_part( 'partials/header/header-search-overlay' );
	}
}

/*-------------------------------------------------------------------------------*/
/* # Menu
/*-------------------------------------------------------------------------------*/

/**
 * Outputs the main header menu
 *
 * @since 1.0.0
 */
function wpsp_header_menu() {

	// Set vars
	$header_style = wpsp_get_redux( 'header-style' );
	$filter       = current_filter();
	$get          = false;

	// Header Inner Hook
	if ( 'wpsp_hook_header_inner' == $filter ) {
		if ( ( 'one' == $header_style || 'five' == $header_style || 'six' == $header_style ) ) {
			$get = true;
		}
	}

	// Header Top Hook
	elseif ( 'wpsp_hook_header_top' == $filter ) {
		if (  'four' == $header_style ) {
			$get = true;
		}
	}

	// Header bottom hook
	elseif ( 'wpsp_hook_header_bottom' == $filter ) {
		if ( ( 'two' == $header_style || 'three' == $header_style ) ) {
			$get = true;
		}
	}

	// Get menu template part
	if ( $get ) {
		get_template_part( 'partials/header/header-menu' );
	}

}

/*-------------------------------------------------------------------------------*/
/* -  Menu > Mobile
/*-------------------------------------------------------------------------------*/

/**
 * Gets the template part for the "icons" style mobile menu.
 *
 * @since 1.0.0
 */
function wpsp_mobile_menu_icons() {
	$style = wpsp_get_redux( 'mobile-menu-toggle-style' );
	$is_has_mobile_menu = has_mobile_menu();
	if ( $is_has_mobile_menu && ( 'icon_buttons' == $style || 'icon_buttons_under_logo' == $style )
	) {
		get_template_part( 'partials/header/header-menu-mobile-icons' );
	}
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