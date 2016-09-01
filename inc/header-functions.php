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
	$classes = array( 'site-branding', 'clearfix' );

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

	// Vars
	$header_style = wpsp_get_redux( 'header-style' );
	$classes = array();

	// Main header style
	$classes['header_style'] = 'header-'. $header_style;

	// Full width header
	if ( wpsp_get_redux( 'is-full-width-header' ) ) {
		$classes[] = 'wpsp-full-width';
	}

	// Clearfix class
	$classes[] = 'clearfix';

	// Set keys equal to vals
	$classes = array_combine( $classes, $classes );

	// Turn classes into space seperated string
	$classes = implode( ' ', $classes );

	$classes = apply_filters( 'wpsp_header_classes', $classes );

	return $classes;
}


/*-------------------------------------------------------------------------------*/
/* Menu header
/*-------------------------------------------------------------------------------*/

/**
 * Adds the search icon to the menu items
 *
 * @since 1.0.0
 */
function wpsp_add_search_to_menu ( $items, $args ) {

	// Only used on main menu
	if ( 'primary' != $args->theme_location ) {
		return $items;
	}

	// Get search style
	$search_style = wpsp_get_redux( 'menu-search-style' );

	// Return if disabled
	if ( ! $search_style || 'disabled' == $search_style ) {
		return $items;
	}

	// Get header style
	$header_style = wpsp_get_redux( 'header-style' );
	
	// Get correct search icon class
	if ( 'overlay' == $search_style) {
		$class = ' search-overlay-toggle';
	} elseif ( 'drop_down' == $search_style ) {
		$class = ' search-dropdown-toggle';
	} elseif ( 'header_replace' == $search_style ) {
		$class = ' search-header-replace-toggle';
	} else {
		$class = '';
	}

	// Add search item to menu
	$items .= '<li class="search-toggle-li wpsp-menu-extra">';
		$items .= '<a href="#" class="site-search-toggle'. $class .'">';
			$items .= '<span class="link-inner">';
				$items .= '<span class="fa fa-search"></span>';
				if ( 'six' == $header_style ) {
					$text = esc_html__( 'Search', 'newstore' );
					$text = apply_filters( 'wpsp_header_search_text', $text );
					$items .= '<span class="wpsp-menu-search-text">'. $text .'</span>';
				}
			$items .= '</span>';
		$items .= '</a>';
	$items .= '</li>';
	
	// Return nav $items
	return $items;

}
add_filter( 'wp_nav_menu_items', 'wpsp_add_search_to_menu', 11, 2 );

/**
 * Returns correct menu classes
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_header_menu_classes' ) ) :
function wpsp_header_menu_classes( $return ) {

	// Define classes array
	$classes = array();

	// Get data
	$header_style = wpsp_get_redux( 'header-style' );
	
	// Return wrapper classes
	if ( 'wrapper' == $return ) {

		// Add Header Style to wrapper
		$classes[] = 'navbar-style-'. $header_style;

		// Add the fixed-nav class if the fixed header option is enabled
		if ( wpsp_get_redux( 'is-fixed-header', true )
			&& ( 'two' == $header_style
				|| 'three' == $header_style
				|| 'four' == $header_style
			)
		) {
			$classes[] = 'fixed-nav';
		}

		// Dropdown dropshadow
		if ( 'one' == $header_style || 'five' == $header_style ) {
			$classes[] = 'wpsp-dropdowns-caret';
		}

		// Flush Dropdowns
		if ( wpsp_get_redux( 'menu-flush-dropdowns' )
			&& 'one' == $header_style
		) {
			$classes[] = 'wpsp-flush-dropdowns';
		}

		// Dropdown dropshadow
		if ( $shadow = wpsp_get_redux( 'menu-dropdown-dropshadow' ) ) {
			$classes[] = 'wpsp-dropdowns-shadow-'. $shadow;
		}

		// Add special class if the dropdown top border option in the admin is enabled
		if ( wpsp_get_redux( 'menu-dropdown-top-border' ) ) {
			$classes[] = 'wpsp-dropdown-top-border';
		}

		// Add clearfix
		$classes[] = 'clearfix';

		// Set keys equal to vals
		$classes = array_combine( $classes, $classes );

		// Apply filters
		$classes = apply_filters( 'wpsp_header_menu_wrap_classes', $classes );

	}

	// Inner Classes
	elseif ( 'inner' == $return ) {

		// Core
		$classes[] = 'navigation';
		$classes[] = 'main-navigation';
		$classes[] = 'clearfix';

		// Add the container div for specific header styles
		if ( in_array( $header_style, array( 'two', 'three', 'four' ) ) ) {
			$classes[] = 'container';
		}

		// Set keys equal to vals
		$classes = array_combine( $classes, $classes );

		// Apply filters
		$classes = apply_filters( 'wpsp_header_menu_classes', $classes );

	}

	// Return
	if ( is_array( $classes ) ) {
		return implode( ' ', $classes );
	} else {
		return $return;
	}

}
endif;

/**
 * Custom menu walker
 *
 * @since 1.0.0
 */
if ( ! class_exists( 'WPSP_Dropdown_Walker_Nav_Menu' ) ) :
	class WPSP_Dropdown_Walker_Nav_Menu extends Walker_Nav_Menu {
		function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {

			// Define vars
			$id_field     = $this->db_fields['id'];
			$header_style = wpsp_get_redux( 'header-style' );

			// Down Arrows
			if ( ! empty( $children_elements[$element->$id_field] ) && ( $depth == 0 ) ) {
				$element->classes[] = 'dropdown';
				if ( wpsp_get_redux( 'menu-arrow-down' ) ) {
					$arrow_class = 'six' == $header_style ? 'fa-chevron-right' : 'fa-angle-down';
					$element->title .= ' <span class="nav-arrow top-level fa '. $arrow_class .'"></span>';
				}
			}

			// Right/Left Arrows
			if ( ! empty( $children_elements[$element->$id_field] ) && ( $depth > 0 ) ) {
				$element->classes[] = 'dropdown';
				if ( wpsp_get_redux( 'menu-arrow-side', true ) ) {
					if ( is_rtl() ) {
						$element->title .= '<span class="nav-arrow second-level fa fa-angle-left"></span>';
					} else {
						$element->title .= '<span class="nav-arrow second-level fa fa-angle-right"></span>';
					}
				}
			}

			// Remove current menu item when using local-scroll class
			if ( in_array( 'local-scroll', $element->classes ) && in_array( 'current-menu-item', $element->classes ) ) {
				$key = array_search( 'current-menu-item', $element->classes );
				unset( $element->classes[$key] );
			}

			// Define walker
			Walker_Nav_Menu::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );

		}
	}
endif;