<?php
/**
 * Customize layout by apply class on body tag.
 *
 * @package newstore
 */
/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function wpsp_theme_layout_class( $classes ) {
	
	global $post;

	// Save some vars
	$header_style = wpsp_get_redux( 'header-style' );
	$post_layout  = wpsp_post_layout();
	$global_layout = wpsp_get_redux( 'layout-global' );
	$post_id      = is_singular() ? $post->ID : NULL;

	// RTL
	if ( is_RTL() ) {
		$classes[] = 'rtl';
	}

	// Customizer
	if ( is_customize_preview() ) {
		$classes[] = 'is_customize_preview';
	}
	
	// Main class
	$classes[] = 'wpsp-theme';

	// Vertical header style
	if ( 'six' == $header_style) {
		$classes[] = 'wpsp-has-vertical-header';
		if ( 'fixed' == wpsp_get_redux( 'vertical-header-style' ) ) {
			$classes[] = 'wpsp-fixed-vertical-header';
		}
	}

	// Sidebar enabled
	if ( 'left-sidebar' == $post_layout || 'right-sidebar' == $post_layout || 'left-sidebar' == $global_layout || 'right-sidebar' == $global_layout ) { 
		$classes[] = 'has-sidebar';
	} 

	// Content layout
	if ( $post_layout ) {
		$classes[] = $post_layout;
	}

	// Single Post cagegories
	if ( is_singular( 'post' ) ) {
		$cats = get_the_category( $post_id );
		foreach ( $cats as $cat ) {
			$classes[] = 'post-in-category-'. $cat->category_nicename;
		}
	}

	// Topbar
	if ( wpsp_get_redux( 'has-top-bar', false ) ) {
		$classes[] = 'has-topbar';
	}

	// Widget Icons
	if ( wpsp_get_redux( 'has-widget-icons', true ) ) {
		$classes[] = 'sidebar-widget-icons';
	}

	// Overlay header style
	if ( wpsp_get_redux( 'has-overlay-header' ) ) {
		$classes[] = 'has-overlay-header';
	}

	// Footer reveal
	if ( wpsp_get_redux( 'has-footer-reveal' ) ) {
		$classes[] = 'footer-has-reveal';
	}

	// Disabled main header
	if ( ! wpsp_get_redux( 'enable-header' ) ) {
		$classes[] = 'wpsp-site-header-disabled';
	}

	// Mobile menu toggle style
	$classes[] = 'wpsp-mobile-toggle-menu-'. wpsp_get_redux( 'mobile-menu-toggle-style' );

	// Mobile menu style
	if ( 'disabled' == wpsp_get_redux( 'mobile-menu-style' ) ) {
		$classes[] = 'mobile-menu-disabled';
	} else {
		$classes[] = 'has-mobile-menu';
	}

	// Navbar inner span bg
	if ( wpsp_get_redux( 'menu-link-span-background' ) ) {
		$classes[] = 'navbar-has-inner-span-bg';
	}

	// Check if avatars are enabled
	if ( is_singular() && ! get_option( 'show_avatars' ) ) {
		$classes[] = 'comment-avatars-disabled';
	}
	
	return $classes;
}
add_filter( 'body_class', 'wpsp_theme_layout_class' );

function wpsp_post_layout() {
	global $post;

	// Define variables
	$meta   = get_post_meta( $post->ID, 'wpsp_layout', true );

	// Check meta first to override and return (prevents filters from overriding meta)
	if ( isset( $meta ) && !empty( $meta ) && $meta != 'inherit' ) {
		return $meta;
	}

	// Singular Page
	if ( is_page() && ( wpsp_get_redux('page-layout') !='inherit' ) ) {

		// Attachment
		if ( is_attachment() ) {
			$class = 'full-width';
		} 

		// All other pages
		else {
			$class = wpsp_get_redux( 'page-layout', 'right-sidebar' );	
		}
	}

	// Singular Post
	elseif ( is_singular( 'post' ) && ( wpsp_get_redux('single-layout') !='inherit' ) ) {

		$class = wpsp_get_redux( 'single-layout', 'right-sidebar' );

	}

	// Attachment
	elseif ( is_singular( 'attachment' ) ) {

		$class = 'full-width';

	}

	// Home
	elseif ( is_home() && ( wpsp_get_redux('archive-layout') !='inherit' ) ) {
		$class = wpsp_get_redux( 'archive-layout', 'right-sidebar' );
	}

	// Search
	elseif ( is_search() && ( wpsp_get_redux('search-layout') !='inherit' ) ) {
		$class = get_theme_mod( 'search-layout', 'right-sidebar' );
	}

	// Standard Categories
	elseif ( is_category() && ( wpsp_get_redux('archive-layout') !='inherit' ) ) {
		$class = wpsp_get_redux( 'archives-layout', 'right-sidebar' );
		$term  = get_query_var( 'cat' );
		if ( $term_data = get_option( "category_$term" ) ) {
			if ( ! empty( $term_data['wpsp_term_layout'] ) ) {
				$class = $term_data['wpsp_term_layout'];
			}
		}
	}

	// Archives
	elseif (
		is_tag()
		|| is_date()
		|| is_author()
		|| ( is_tax( 'post_format' ) && 'post' == get_post_type() ) 
	) {
		$class = wpsp_get_redux( 'archives-layout', 'right-sidebar' );
	}
	
	// 404 page
	elseif ( is_404() && ( wpsp_get_redux('404-layout') !='inherit' ) ) {
		$class = wpsp_get_redux( '404-layout', 'full-width' );
	}

	// All else
	else {
		// Class should never be empty
		if ( empty( $class ) ) {
			$class = wpsp_get_redux( 'layout-global', 'right-sidebar' );
		}
	}

	// Apply filters and return
	$class = apply_filters( 'wpsp_post_layout_class', $class );

	// Return correct classname
	return $class;
}