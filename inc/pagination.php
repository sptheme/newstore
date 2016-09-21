<?php
/**
 * Custom pagination functions
 *
 * @package newstore
 */

/**
 * Numbered Pagination
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_pagination' ) ) :
	function wpsp_pagination( $query = '' ) {
		
		// Arrows with RTL support
		$prev_arrow = is_rtl() ? 'fa fa-angle-right' : 'fa fa-angle-left';
		$next_arrow = is_rtl() ? 'fa fa-angle-left' : 'fa fa-angle-right';
		
		// Get global $query
		if ( ! $query ) {
			global $wp_query;
			$query = $wp_query;
		}

		// Set vars
		$total  = $query->max_num_pages;
		$big    = 999999999;

		// Display pagination
		if ( $total > 1 ) {

			// Get current page
			if ( $current_page = get_query_var( 'paged' ) ) {
				$current_page = $current_page;
			} elseif ( $current_page = get_query_var( 'page' ) ) {
				$current_page = $current_page;
			} else {
				$current_page = 1;
			}

			// Get permalink structure
			if ( get_option( 'permalink_structure' ) ) {
				if ( is_page() ) {
					$format = 'page/%#%/';
				} else {
					$format = '/%#%/';
				}
			} else {
				$format = '&paged=%#%';
			}

			// Midsize
			$mid_size = '3';

			// Output pagination
			echo paginate_links( array(
				'base'      => str_replace( $big, '%#%', html_entity_decode( get_pagenum_link( $big ) ) ),
				'format'    => $format,
				'current'   => max( 1, $current_page ),
				'total'     => $total,
				'mid_size'  => $mid_size,
				'type'      => 'list',
				'prev_text' => '<span class="'. $prev_arrow .'"></span>',
				'next_text' => '<span class="'. $next_arrow .'"></span>',
			) );
		}

	}
endif;

/**
 * Next/Prev Pagination
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_pagejump' ) ) :
	function wpsp_pagejump( $pages = '', $range = 4 ) {
		$output     = '';
		$showitems  = ($range * 2)+1; 
		global $paged;
		if ( empty( $paged ) ) $paged = 1;
		
		if ( $pages == '' ) {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if ( ! $pages) {
				$pages = 1;
			}
		}
		if ( 1 != $pages ) {
		$output .= '<div class="page-jump clear">';
			$output .= '<div class="alignleft newer-posts">';
				$output .= get_previous_posts_link( '&larr; '. esc_html__( 'Newer Posts', 'wpsp-blog' ) );
			$output .= '</div>';
			$output .= '<div class="alignright older-posts">';
				$output .= get_next_posts_link( esc_html__( 'Older Posts', 'wpsp-blog' ) .' &rarr;' );
			$output .= '</div>';
		$output .= '</div>';
		}
		echo $output;
	}
endif;

/**
 * Infinite Scroll Pagination
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_infinite_scroll' ) ) :
	function wpsp_infinite_scroll( $type = 'standard' ) {
		
		// Load infinite scroll js for standard blog style
		if ( $type == 'standard' ) {
			wp_enqueue_script( 'wpsp-infinitescroll', WPSP_JS_DIR_URI .'infinite-scroll/infinitescroll.js', array( 'jquery' ), 1.0, true );
			wp_enqueue_script( 'wpsp-infinitescroll-standard', WPSP_JS_DIR_URI .'infinite-scroll/infinitescroll-standard.js', array( 'jquery' ), 1.0, true );
		}
		
		// Load infinite scroll js for grid
		if ( $type == 'standard-grid' ) {
			wp_enqueue_script( 'wpsp-infinitescroll', WPSP_JS_DIR_URI .'infinite-scroll/infinitescroll.js', array( 'jquery' ), 1.0, true );
			wp_enqueue_script( 'wpsp-infinitescroll-grid', WPSP_JS_DIR_URI .'infinite-scroll/infinitescroll-standard-grid.js', array( 'jquery' ), 1.0, true );
		}
		
		// Localize loading text
		$is_params = array( 'msgText' => esc_html__( 'Loading...', 'wpsp-blog' ) );
		wp_localize_script( 'wpsp-infinitescroll', 'wpspInfiniteScroll', $is_params );  
		
		// Output pagination HTML
		$output = '';
		$output .= '<div class="infinite-scroll-nav clear">';
			$output .= '<div class="alignleft newer-posts">';
				$output .= get_previous_posts_link('&larr; '. esc_html__( 'Newer Posts', 'wpsp-blog' ) );
			$output .= '</div>';
			$output .= '<div class="alignright older-posts">';
				$output .= get_next_posts_link( esc_html__( 'Older Posts', 'wpsp-blog' ) .' &rarr;');
			$output .= '</div>';
		$output .= '</div>';

		echo $output;

	}
endif;

/**
 * Blog Pagination
 * Used to load the correct pagination function for blog archives
 * Execute the correct pagination function based on the theme settings
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_blog_pagination' ) ) :
	function wpsp_blog_pagination() {
		
		// Admin Options
		$blog_style       = wpsp_get_redux( 'blog-entry-style', 'large-image' );
		$pagination_style = wpsp_get_redux( 'blog-pagination-style', 'standard' );
		
		// Category based settings
		if ( is_category() ) {
			
			// Get taxonomy meta
			$term       = get_query_var( 'cat' );
			$term_data  = get_option( 'category_'. $term );
			$term_style = $term_pagination = '';
			
			if ( isset( $term_data['wpsp_term_style'] ) ) {
				$term_style = '' != $term_data['wpsp_term_style'] ? $term_data['wpsp_term_style'] .'' : $term_style;
			}
			
			if ( isset( $term_data['wpsp_term_pagination'] ) ) {
				$term_pagination = '' != $term_data['wpsp_term_pagination'] ? $term_data['wpsp_term_pagination'] .'' : '';
			}
			
			if ( $term_style ) {
				$blog_style = $term_style .'-entry-style';
			}
			
			if ( $term_pagination ) {
				$pagination_style = $term_pagination;
			}
			
		}
		
		// Set default $type for infnite scroll
		if ( 'grid-entry-style' == $blog_style ) {
			$infinite_type = 'standard-grid';
		} else {
			$infinite_type = 'standard';
		}
		
		// Execute the correct pagination function
		if ( 'infinite_scroll' == $pagination_style ) {
			wpsp_infinite_scroll( $infinite_type );
		} elseif ( $pagination_style == 'next_prev' ) {
			wpsp_pagejump();
		} else {
			wpsp_pagination();
		}

	}

endif;