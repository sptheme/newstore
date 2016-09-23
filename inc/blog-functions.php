<?php
/**
 * Helper functions for the blog
 *
 * @package newstore
 */

/**
 * Exclude categories from the blog
 * This function runs on pre_get_posts
 *
 * @since 1.0.0
 */
function wpsp_blog_exclude_categories( $deprecated = true ) {

	// Don't run in these places
	if ( is_admin()
		|| is_search()
		|| is_tag()
		|| is_category()
	) {
		return;
	}

	// Get Cat id's to exclude
	if ( $cats = wpsp_get_redux( 'blog-cats-exclude' ) ) {
		if ( ! is_array( $cats ) ) {
			$cats = explode( ',', $cats ); // Convert to array
		}
	}

	// Return ID's
	return $cats;
	
}

/**
 * Adds main classes to blog post entries
 *
 * @since 1.0.0
 */
function wpsp_blog_wrap_classes( $classes = NULL ) {
	
	// Return custom class if set
	if ( $classes ) {
		return $classes;
	}
	
	// Admin defaults
	$style   = wpsp_blog_style();
	$classes = array( 'entries', 'clearfix' );
		
	// Isotope classes
	if ( $style == 'grid-entry-style' ) {
		$classes[] = 'row';
		if ( 'masonry' == wpsp_blog_grid_style() ) {
			$classes[] = 'blog-masonry-grid ';
		} else {
			if ( 'infinite_scroll' == wpsp_blog_pagination_style() ) {
				$classes[] = 'blog-masonry-grid ';
			} else {
				$classes[] = 'blog-grid ';
			}
		}
	}

	// Left thumbs
	if ( 'thumbnail-entry-style' == $style ) {
		$classes[] = 'left-thumbs';
	}

	
	// Add some margin when author is enabled
	if ( $style == 'grid-entry-style' && wpsp_get_redux( 'blog-entry-author-avatar' ) ) {
		$classes[] = 'grid-w-avatars ';
	}
	
	// Infinite scroll classes
	if ( 'infinite_scroll' == wpsp_blog_pagination_style() ) {
		$classes[] = 'infinite-scroll-wrap ';
	}
	
	// Add filter for child theming
	$classes = apply_filters( 'wpsp_blog_wrap_classes', $classes );

	// Turn classes into space seperated string
	if ( is_array( $classes ) ) {
		$classes = implode( ' ', $classes );
	}

	// Echo classes
	echo esc_attr( $classes );
	
}

/**
 * Returns the correct blog style
 *
 * @since 1.0.0
 */
function wpsp_blog_style() {

	// Get default style from Customizer
	$style = wpsp_get_redux( 'blog-entry-style' );

	// Check custom category style
	if ( is_category() ) {
		$term      = get_query_var( 'cat' );
		$term_data = get_option( "category_$term" );
		if ( $term_data && ! empty ( $term_data['wpsp_term_style'] ) ) {
			$style = $term_data['wpsp_term_style'] .'-entry-style';
		}
	}

	// Sanitize
	$style = $style ? $style : 'large-image-entry-style';

	// Apply filters for child theming
	$style = apply_filters( 'wpsp_blog_style', $style );

	// Return style
	return $style;

}

/**
 * Returns the correct pagination style from category term
 *
 * @since 1.0.0
 */
function wpsp_blog_pagination_style() {

	// Get default style from Customizer
	$style = wpsp_get_redux( 'blog-pagination-style' );

	// Check custom category style
	if ( is_category() ) {
		$term       = get_query_var( 'cat' );
		$term_data  = get_option( "category_$term" );
		if ( $term_data && ! empty ( $term_data['wpsp_term_pagination'] ) ) {
			$style = $term_data['wpsp_term_pagination'];
		}
	}

	// Apply filters for child theming
	$style = apply_filters( 'wpsp_blog_pagination_style', $style );

	// Return style
	return $style;
}

/**
 * Returns correct style for the blog entry based on theme options or category options
 *
 * @since 1.0.0
 */
function wpsp_blog_entry_style() {

	// Get default style from Customizer
	$style = wpsp_get_redux( 'blog-entry-style' );

	// Check custom category style
	if ( is_category() ) {
		$term       = get_query_var( "cat" );
		$term_data  = get_option( "category_$term" );
		if ( ! empty ( $term_data['wpsp_term_style'] ) ) {
			$style = $term_data['wpsp_term_style'] .'-entry-style';
		}
	}

	// Sanitize
	$style = $style ? $style : 'large-image-entry-style';

	// Apply filters for child theming
	$style = apply_filters( 'wpsp_blog_entry_style', $style );

	// Return style
	return $style;

}

/**
 * Returns correct blog entry classes
 *
 * @since 1.0.0
 */
function wpsp_blog_entry_classes() {

	// Define classes array
	$classes = array();

	// Entry Style
	$entry_style = wpsp_blog_entry_style();

	// Core classes
	$classes[] = 'blog-entry';
	$classes[] = 'clearfix';

	// Add has media class
	if ( has_post_thumbnail()
		|| get_post_meta( $post->ID, 'wpsp_post_self_hosted_media', true )
		|| get_post_meta( $post->ID, 'wpsp_post_video_embed', true )
		|| get_post_meta( $post_id, '_easy_image_gallery', true )
	) {
		$classes[] = 'format-video';
		$classes[] = 'has-media';
	}

	// Masonry classes
	if ( 'masonry' == wpsp_blog_grid_style() ) {
		$classes[] = 'isotope-entry';
	}

	// Equal heights
	if ( wpsp_blog_entry_equal_heights() ) {
		$classes[] = 'blog-entry-equal-heights';
	}

	// Add columns for grid style entries
	if ( $entry_style == 'grid-entry-style' ) {
		$classes[] = bootstrap_grid_class( wpsp_blog_entry_columns() );
	}

	// No Featured Image Class, don't add if oembed or self hosted meta are defined
	if ( ! has_post_thumbnail()
		&& '' == get_post_meta( get_the_ID(), 'wpsp_post_oembed', true ) ) {
		$classes[] = 'no-featured-image';
	}

	// Blog entry style
	$classes[] = $entry_style;

	// Avatar
	if ( $avatar_enabled = wpsp_get_redux( 'blog-entry-author-avatar' ) ) {
		$classes[] = 'entry-has-avatar';
	}

	// Counter
	global $wpsp_count;
	if ( $wpsp_count ) {
		$classes[] = 'col-'. $wpsp_count;
	}

	// Apply filters to entry post class for child theming
	$classes = apply_filters( 'wpsp_blog_entry_classes', $classes );

	// Rturn classes array
	return $classes;
}

/**
 * Returns the grid style
 *
 * @since 1.0.0
 */
function wpsp_blog_grid_style() {

	// Get default style from Customizer
	$style = wpsp_get_redux( 'blog-grid-style' );

	// Check custom category style
	if ( is_category() ) {
		$term       = get_query_var( 'cat' );
		$term_data  = get_option( "category_$term" );
		if ( $term_data && ! empty ( $term_data['wpsp_term_grid_style'] ) ) {
			$style = $term_data['wpsp_term_grid_style'];
		}
	}

	// Sanitize
	$style = $style ? $style : 'fit-rows';

	// Apply filters for child theming
	$style = apply_filters( 'wpsp_blog_grid_style', $style );

	// Return style
	return $style;

}

/**
 * Checks if the blog entries should have equal heights
 *
 * @since   1.0.0
 */
function wpsp_blog_entry_equal_heights() {

	// Return if disabled via theme mod
	if ( ! wpsp_get_redux( 'blog-archive-grid-equal-heights', false ) ) {
		return false;
	}

	// Return true for the grid style
	if ( 'grid-entry-style' == wpsp_blog_entry_style() && 'masonry' != wpsp_blog_grid_style() ) {
		return true;
	}

}

/**
 * Returns correct columns for the blog entries
 *
 * @since 1.0.0
 */
function wpsp_blog_entry_columns() {

	// Get columns from customizer setting
	$columns = wpsp_get_redux( 'blog-grid-columns' );

	// Get custom columns per category basis
	if ( is_category() ) {
		$term       = get_query_var( 'cat' );
		$term_data  = get_option( "category_$term" );
		if ( ! empty ( $term_data['wpsp_term_grid_cols'] ) ) {
			$columns = $term_data['wpsp_term_grid_cols'];
		}
	}

	// Sanitize
	$columns = $columns ? $columns : '2';

	// Apply filters for child theming
	$columns = apply_filters( 'wpsp_blog_entry_columns', $columns );

	// Return columns
	return $columns;

}

/**
 * Returns blog entry blocks
 *
 * @since 1.0.0
 */
function wpsp_blog_entry_layout_blocks() {

	// Get layout blocks
	$blocks = wpsp_get_redux( 'blog-entry-block' );

	// If blocks are 100% empty return defaults
	$blocks = $blocks ? $blocks : 'featured_media,title,meta,excerpt_content,readmore';

	// Convert blocks to array so we can loop through them
	if ( ! is_array( $blocks ) ) {
		$blocks = explode( ',', $blocks );
	}

	// Set block keys equal to vals
	//$blocks = array_combine( $blocks, $blocks );

	// Apply filters to entry layout blocks after they are turned into an array
	$blocks = apply_filters( 'wpsp_blog_entry_layout_blocks', $blocks );

	// Return blocks
	return $blocks;

}

/**
 * Returns blog entry post blocks
 *
 * @since 1.0.0
 */
function wpsp_blog_entry_meta_sections() {

	// Default sections
	$sections = array( 'date', 'author', 'categories', 'comments' );

	// Get Sections from Customizer
	$sections = wpsp_get_redux( 'blog-entry-meta-sections', $sections );

	// Turn into array if string
	if ( $sections && ! is_array( $sections ) ) {
		$sections = explode( ',', $sections );
	}

	// Apply filters for easy modification
	$sections = apply_filters( 'wpsp_blog_entry_meta_sections', $sections );

	// Return sections
	return $sections;

}

/**
 * Returns the blog entry thumbnail
 *
 * @since 1.0.0
 */
function wpsp_get_blog_entry_thumbnail( $args = '' ) {

	// If args isn't array then it's the attachment
	if ( $args && ! is_array( $args ) ) {
		$args = array(
			'attachment' => $args,
		);
	}

	// Define thumbnail args
	$defaults = array(
		'attachment'    => get_post_thumbnail_id(),
		'size'          => 'blog_entry',
		'alt'           => wpsp_get_esc_title(),
		'width'         => '',
		'height'        => '',
		'class'         => '',
	);

	// Parse arguments
	$args = wp_parse_args( $args, $defaults );

	// Apply filter to args
	$args = apply_filters( 'wpsp_blog_entry_thumbnail_args', $args );

	// Generate thumbnail
	$thumbnail = wpsp_get_post_thumbnail( $args );

	// Return thumbnail
	return apply_filters( 'wpsp_blog_entry_thumbnail', $thumbnail );

}