<?php
/**
 * All page header functions
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package newstore
 *
 */

/**
 * Returns page header style
 *
 * @since 1.0.0
 */
function wpsp_page_header_style() {

	$post_id = post_id();

	// Get default page header style defined in theme option
	$style = wpsp_get_redux( 'page-title-style' );

	// Get for header style defined in page settings
	if ( $meta = get_post_meta( $post_id, 'wpsp_post_title_style', true ) ) {
		$style = $meta;
	}

	// Sanitize data
	$style = ( 'default' == $style ) ? '' : $style;
	
	// Apply filters and return
	return apply_filters( 'wpsp_page_header_style', $style );

}

/**
 * Checks if the page header is enabled
 *
 * @since 1.0.0
 */
function wpsp_has_page_header() {
	
	// Define vars
	$return = true;
	$style  = wpsp_page_header_style();
	$post_id = post_id();

	// Check if page header style is set to hidden
	if ( 'hidden' == $style ) {
		$return = false;
	}

	// Return if page header is disabled via custom field
	if ( $post_id ) {

		// Get page meta setting
		$meta = get_post_meta( $post_id, 'wpsp_is_page_title', true );

		// Return true if enabled via page settings
		if ( $meta ) {
			$return = true;
		}

		// Return if page header is disabled and there isn't a page header background defined
		elseif ( !$meta && 'background-image' != $style ) {
			$return	= false;
		}

	}

	// Apply filters and return
	return apply_filters( 'wpsp_display_page_header', $return );

}

/**
 * Checks if the page header has a title
 *
 * @since 1.0.0
 */
function wpsp_has_page_header_title() {

	$post_id = post_id();

	// Disable title if the page header is disabled via meta (ignore filter)
	$meta = get_post_meta( $post_id, 'wpsp_is_page_title', true );
	if ( !$meta && !is_404() && !is_search() ) {
		return false;
	}
	
	// Apply filters and return
	return apply_filters( 'has_page_header_title', true );

}

/**
 * Checks if the page header has subheading
 *
 * @since 1.0.0
 */
function wpsp_has_page_header_subheading() {
	if ( wpsp_get_page_subheading() ) {
		return true;
	}
}

/**
 * Returns page subheading
 *
 * @since 3.0.0
 */
function wpsp_get_page_subheading() {

	$post_id = post_id();

	// Subheading is NULL by default
	$subheading = NULL;

	// Posts & Pages
	if ( $meta = get_post_meta( $post_id, 'wpsp_post_subheading', true ) ) {
		$subheading = $meta;
	}

	// Search
	elseif ( is_search() ) {
		$subheading = esc_html__( 'You searched for:', 'newstore' ) .' &quot;'. esc_html( get_search_query( false ) ) .'&quot;';
	}

	// Categories
	elseif ( is_category() ) {
		/*$position = get_option( 'category_description_position' );
		$position = $position ? $position : 'under_title';
		if ( 'under_title' == $position ) {
			$subheading = term_description();
		}*/
		$subheading = term_description();
	}

	// Author
	elseif ( is_author() ) {
		$subheading = esc_html__( 'This author has written', 'newstore' ) .' '. get_the_author_posts() .' '. esc_html__( 'articles', 'newstore' );
	}

	// All other Taxonomies - TODO: in blog-functions.php
	/*elseif ( is_tax() && ! wpsp_has_term_description_above_loop() ) {
		$subheading = term_description();
	}*/

	// Apply filters and return
	return apply_filters( 'wpsp_post_subheading', $subheading );

}

/**
 * Adds correct classes to the page header
 *
 * @since 1.0.0
 */
function wpsp_page_header_classes() {

	global $redux_wpsp;
	
	// Define main class
	$classes = array( 'page-header' );

	// Get header style
	$style = wpsp_page_header_style();

	// Add classes for title style
	if ( $style ) {
		$classes[$style .'-page-header'] = $style .'-page-header';
	}

	// Check if current page title supports mods
	if ( ! in_array( $style, array( 'background-image', 'solid-color' ) ) ) {
		$classes['wpsp-supports-mods'] = 'wpsp-supports-mods';
	}

	// Add global background
	$bg = $redux_wpsp['page-title-background-img']['url'];
	if ( $bg ) {
		$classes['has-bg-image'] = 'has-bg-image';
		$bg_style = wpsp_get_redux( 'page-title-background-img-position' );
		$bg_style =  $bg_style ? $bg_style : 'fixed';
		$bg_style = apply_filters( 'wpsp_page_header_background_img_position', $bg_style );
		$classes['bg-'. $bg_style] = 'bg-'. $bg_style;
	}

	// Apply filters
	apply_filters( 'wpsp_page_header_classes', $classes );

	// Turn into comma seperated list
	$classes = implode( ' ', $classes );

	// Return classes
	return $classes;
}

/**
 * Get page header background image URL
 *
 * @since 1.0.0
 */
function wpsp_page_header_background_image( $post_id = '' ) {

	// Return NULL by default
	$image = null;

	// Get page header background from meta
	if ( $post_id ) {
		$attachments = rwmb_meta( 'wpsp_post_title_background_img', array('type' => 'image_advanced', 'size' => 'full') );
		foreach ($attachments as $attachment ) {
			$image = $attachment['full_url'];
		}		
	}

	// Apply filters
	$image = apply_filters( 'wpsp_page_header_background_image', $image );

	// Generate image URL if using ID
	/*if ( is_numeric( $image ) ) {
		$image = wp_get_attachment_image_src( $image, 'full' );
		$image = $image[0];
	}*/

	// Return URL
	return $image;
}

/**
 * Outputs Custom CSS for the page title
 *
 * @since 1.0.0
 */
function wpsp_page_header_overlay() {

	// Only needed for the background-image style so return otherwise
	if ( 'background-image' != wpsp_page_header_style() ) {
		return;
	}

	// Define vars
	$return  = '';

	// Set default overlay styles for tax archives since we don't have meta settings
	if ( is_tax() || is_tag() || is_category() ) {
		$overlay       = 1;
		$opacity       = '';
		$overlay_style = 'solid';
	}

	// Get options from post meta
	else {
		global $post; 
		$post_id       = $post->ID;
		$overlay       = get_post_meta( $post_id, 'wpsp_post_title_background_overlay', true );
		$opacity       = get_post_meta( $post_id, 'wpsp_post_title_background_overlay_opacity', true );
		$overlay_style = get_post_meta( $post_id, 'wpsp_post_title_background_overlay', true );
	}

	// Apply filters
	$overlay       = apply_filters( 'wpsp_page_header_overlay_enabled', $overlay );
	$overlay_style = apply_filters( 'wpsp_page_header_overlay_style', $overlay_style );
	$opacity       = apply_filters( 'wpsp_page_header_overlay_opacity', $opacity );

	// Sanitize
	$overlay = 'none' == $overlay ? false : $overlay;

	// Check that overlay style isn't set to none
	if ( $overlay && $overlay_style ) {

		// Add opacity style if opacity is defined
		if ( $opacity ) {
			$opacity = 'style="opacity:'. $opacity .'"';
		}

		// Return overlay element
		$return = '<span class="background-image-page-header-overlay style-'. $overlay_style .'" '. $opacity .'></span>';
		
	}

	// Apply filters and echo
	echo apply_filters( 'wpsp_page_header_overlay', $return );
}

/**
 * Outputs Custom CSS for the page title
 *
 * @since 1.0.0
 */
function wpsp_page_header_css( $output ) {

	global $post;

	// Make sure page header is enabled so we don't run unnedded checks or add useless CSS
	if ( wpsp_has_page_header() ) {

		// Get post ID
		$post_id = $post->ID;

		// Get header style
		$page_header_style = wpsp_page_header_style();

		// Define var
		$css = '';
		$page_header_css = '';

		// Check if a header style is defined and make header style dependent tweaks
		if ( $page_header_style ) {

			// Customize background color
			if ( 'solid-color' == $page_header_style || 'background-image' == $page_header_style ) {
				$bg_color = get_post_meta( $post_id, 'wpsp_post_title_background_color', true );
				if ( $bg_color ) {
					$page_header_css .='background-color: '. $bg_color .' !important;';
				}
			}

			// Background image Style
			if ( 'background-image' == $page_header_style ) {

				// Get background image
				$bg_img = wpsp_page_header_background_image( $post_id );

				// Add CSS for background image
				if ( $bg_img ) {

					// Add css for background image
					$page_header_css .= 'background-image: url('. $bg_img .' ) !important;
							background-position: 50% 0;
							-webkit-background-size: cover;
							-moz-background-size: cover;
							-o-background-size: cover;
							background-size: cover;';

				}

				// Custom height => Added to inner table NOT page header
				$title_height = get_post_meta( $post_id, 'wpsp_post_title_height', true );
				$title_height = apply_filters( 'wpsp_post_title_height', $title_height );
				if ( $title_height ) {
					$css .= '.page-header-table { height:'. wpsp_sanitize_data( $title_height, 'px' ) .'; }';
				}

			}

			// Apply all css to the page-header class
			if ( ! empty( $page_header_css ) ) {
				$css .= '.page-header { '. $page_header_css .' }';
			}

			// Overlay Color
			if ( ! empty( $bg_img ) ) {
				if ( 'bg-color' == get_post_meta( $post_id, 'wpsp_post_title_background_overlay', true )
					&& 'background-image' == $page_header_style
					&& isset( $bg_color )
				) {
					$css .= '.background-image-page-header-overlay { background-color: '. $bg_color .' !important; }';
				}
			}

			// If css var isn't empty add to custom css output
			if ( ! empty( $css ) ) {
				$output .= $css;
			}

		}

	}

	// Return output
	return $output;

}
add_filter( 'wpsp_head_css', 'wpsp_page_header_css' );

/**
 * Display the correct title to display for any post/page/archive
 *
 * @since 1.0.0
 */
function wpsp_title() {

	// Default title is null
	$title = NULL;
	
	// Get post ID from global object
	$post_id = post_id();
	
	// Homepage - display blog description if not a static page
	if ( is_front_page() && ! is_singular( 'page' ) ) {
		
		if ( get_bloginfo( 'description' ) ) {
			$title = get_bloginfo( 'description' );
		} else {
			return esc_html__( 'Recent Posts', 'newstore' );
		}

	// Homepage posts page
	} elseif ( is_home() && ! is_singular( 'page' ) ) {

		$title = get_the_title( get_option( 'page_for_posts', true ) );

	}

	// Search => NEEDS to go before archives
	elseif ( is_search() ) {
		global $wp_query;
		$title = '<span id="search-results-count">'. $wp_query->found_posts .'</span> '. esc_html__( 'Search Results Found', 'newstore' );
	}
		
	// Archives
	elseif ( is_archive() ) {

		// Author
		if ( is_author() ) {
			/*$title = sprintf(
				esc_html__( 'All posts by%s', 'newstore' ),': <span class="vcard">' . get_the_author() . '</span>'
			);*/
			$title = get_the_archive_title();
		}

		// Post Type archive title
		elseif ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		}

		// Daily archive title
		elseif ( is_day() ) {
			$title = sprintf( esc_html__( 'Daily Archives: %s', 'newstore' ), get_the_date() );
		}

		// Monthly archive title
		elseif ( is_month() ) {
			$title = sprintf( esc_html__( 'Monthly Archives: %s', 'newstore' ), get_the_date( 'F Y' ) );
		}

		// Yearly archive title
		elseif ( is_year() ) {
			$title = sprintf( esc_html__( 'Yearly Archives: %s', 'newstore' ), get_the_date( 'Y' ) );
		}

		// Categories/Tags/Other
		else {

			// Get term title
			$title = single_term_title( '', false );

			// Fix for bbPress and other plugins that are archives but use pages
			if ( ! $title ) {
				global $post;
				$title = get_the_title( $post_id );
			}

		}

	} // End is archive check

	// 404 Page
	elseif ( is_404() ) {

		$title = wpsp_get_translated_theme_mod( 'error_page_title' );
		$title = $title ? $title : esc_html__( '404: Page Not Found', 'newstore' );
	}
	
	// Anything else with a post_id defined
	elseif ( $post_id ) {

		// Single Pages
		if ( is_singular( 'page' ) || is_singular( 'attachment' ) ) {
			$title = get_the_title( $post_id );
		}

		// Single blog posts
		elseif ( is_singular( 'post' ) ) {
			$display = wpsp_get_redux( 'blog-single-header' );
			$display = $display ? $display : 'custom_text';
			if ( 'custom_text' == $display ) {
				$title = wpsp_get_redux( 'blog-single-header-custom-text' );
				$title = $title ? $title : esc_html__( 'Blog', 'newstore' );
			} elseif ( 'first_category' == $display ) {
				$title = wpsp_get_first_term_name();
			} else {
				$title = get_the_title( $post_id );
			}
		}

		// Other posts (custom types)
		else {
			$obj = get_post_type_object( get_post_type() );
			if ( is_object( $obj ) ) {
				$title = $obj->labels->name;
			}
		}

		// Custom meta title
		if ( $meta = get_post_meta( $post_id, 'wpsp_post_title', true ) ) {
			$title = $meta;
		}

	}

	// Last check if title is empty
	$title = $title ? $title : get_the_title();

	// Apply filters and return title
	return apply_filters( 'wpsp_title', $title );
	
}

