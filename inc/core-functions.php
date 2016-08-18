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

/**
 * Returns the correct classname for any specific column grid work with bootstrap
 *
 * @since 1.0.0
 */
if ( ! function_exists('bootstrap_grid_class') ) :
function bootstrap_grid_class( $col = '4' ) {
	$bootstrap_grid = 12;
	return esc_attr( apply_filters( 'bootstrap_grid_class', 'col-md-'. ($bootstrap_grid/$col) ) );
}
endif;

/*-------------------------------------------------------------------------------*/
/* [ Schema Markup ]
/*-------------------------------------------------------------------------------*/

/**
 * Outputs correct schema HTML for sections of the site
 *
 * @since 1.0.0
 */
if ( ! function_exists('wpsp_schema_markup') ) :
function wpsp_schema_markup( $location ) {
	echo wpsp_sanitize_data( wpsp_get_schema_markup( $location ), 'html' );
}
endif;

/**
 * Returns correct schema HTML for sections of the site
 *
 * @since 1.0.0
 */
if ( ! function_exists('wpsp_get_schema_markup') ) :
function wpsp_get_schema_markup( $location ) {

	// Return nothing if disabled
	if ( ! wpsp_get_redux( 'schema_markup_enable', true ) ) {
		return null;
	}

	// Loop through locations
	if ( 'body' == $location ) {
		$itemscope = 'itemscope';
		$itemtype  = 'http://schema.org/WebPage';
		if ( is_singular( 'post' ) ) {
			$type = "Article";
		} elseif ( is_author() ) {
			$type = 'ProfilePage';
		} elseif ( is_search() ) {
			$type = 'SearchResultsPage';
		}
		$schema = 'itemscope="'. $itemscope .'" itemtype="'. $itemtype .'"';
	} elseif ( 'header' == $location ) {
		$schema = 'itemscope="itemscope" itemtype="http://schema.org/WPHeader"';
	} elseif ( 'site_navigation' == $location ) {
		$schema = 'itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement"';
	} elseif ( 'main' == $location ) {
		$itemtype = 'http://schema.org/WebPageElement';
		$itemprop = 'mainContentOfPage';
		if ( is_singular( 'post' ) ) {
			$itemprop = '';
			$itemtype = 'http://schema.org/Blog';
		}
		$schema = 'itemprop="'. $itemprop .'" itemscope="itemscope" itemtype="'. $itemtype .'"';
	} elseif ( 'sidebar' == $location ) {
		$schema = 'itemscope="itemscope" itemtype="http://schema.org/WPSideBar"';
	} elseif ( 'footer' == $location ) {
		$schema = 'itemscope="itemscope" itemtype="http://schema.org/WPFooter"';
	} elseif ( 'footer_bottom' == $location ) {
		$schema = '';
	} elseif ( 'headline' == $location ) {
		$schema = 'itemprop="headline"';
	} elseif ( 'blog_post' == $location ) {
		$schema = 'itemprop="blogPost" itemscope="itemscope" itemtype="http://schema.org/BlogPosting"';
	} elseif ( 'entry_content' == $location ) {
		$schema = 'itemprop="text"';
	} elseif ( 'publish_date' == $location ) {
		$schema = 'itemprop="datePublished" pubdate';
	} elseif ( 'author_name' == $location ) {
		$schema = 'itemprop="name"';
	} elseif ( 'author_link' == $location ) {
		$schema = 'itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person"';
	} elseif ( 'image' == $location ) {
		$schema = 'itemprop="image"';
	} else {
		$schema = '';
	}

	// Apply filters and return
	return ' '. apply_filters( 'wpsp_get_schema_markup', $schema );

}
endif;