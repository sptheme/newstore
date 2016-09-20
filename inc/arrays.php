<?php
/**
 * Useful functions that return arrays
 *
 * @package newstore
 */

/**
 * Header menu style
 *
 * @since 1.0.0
 */
function header_styles_array() {
	return apply_filters( 'wpsp_header_styles', array(
        'one' => esc_html__( 'One - Left Logo & Right Navbar','newstore' ),
        'two' => esc_html__( 'Two - Bottom Navbar','newstore' ),
        'three' => esc_html__( 'Three - Bottom Navbar Centered','newstore' ),
        'four' => esc_html__( 'Four - Top Navbar Centered','newstore' ),
        'five' => esc_html__( 'Five - Centered Inline Logo','newstore' ),
        'six' => esc_html__( 'Six - Vertical','newstore' ),
    ) );
}

/**
 * Create an array of overlay styles so they can be altered via child themes
 *
 * @since 1.0.0
 */
function wpsp_overlay_styles_array( $style = NULL ) {
	$array = array(
		''                                => esc_html__( 'None', 'total' ),
		'hover-button'                    => esc_html__( 'Hover Button', 'total' ),
		'magnifying-hover'                => esc_html__( 'Magnifying Glass Hover', 'total' ),
		'plus-hover'                      => esc_html__( 'Plus Icon Hover', 'total' ),
		'plus-two-hover'                  => esc_html__( 'Plus Icon #2 Hover', 'total' ),
		'plus-three-hover'                => esc_html__( 'Plus Icon #3 Hover', 'total' ),
		'view-lightbox-buttons-buttons'   => esc_html__( 'View/Lightbox Icons Hover', 'total' ),
		'view-lightbox-buttons-text'      => esc_html__( 'View/Lightbox Text Hover', 'total' ),
		'title-bottom'                    => esc_html__( 'Title Bottom', 'total' ),
		'title-bottom-see-through'        => esc_html__( 'Title Bottom See Through', 'total' ),
		'title-push-up'                   => esc_html__( 'Title Push Up', 'total' ),
		'title-excerpt-hover'             => esc_html__( 'Title + Excerpt Hover', 'total' ),
		'title-category-hover'            => esc_html__( 'Title + Category Hover', 'total' ),
		'title-category-visible'          => esc_html__( 'Title + Category Visible', 'total' ),
		'categories-title-bottom-visible' => esc_html__( 'Categories + Title Bottom Visible', 'total' ),
		'title-date-hover'                => esc_html__( 'Title + Date Hover', 'total' ),
		'title-date-visible'              => esc_html__( 'Title + Date Visible', 'total' ),
		'slideup-title-white'             => esc_html__( 'Slide-Up Title White', 'total' ),
		'slideup-title-black'             => esc_html__( 'Slide-Up Title Black', 'total' ),
		'category-tag'                    => esc_html__( 'Category Tag', 'total' ),
		'category-tag-two'                => esc_html__( 'Category Tag', 'total' ) .' 2',
	);
	return apply_filters( 'wpex_overlay_styles_array', $array );
}

/**
 * Cropping location images
 *
 * @since 1.0.0
 */
function wpsp_image_crop_locations() {
	return array(
		''              => esc_html__( 'Default', 'wpsp-blog' ),
		'left-top'      => esc_html__( 'Top Left', 'wpsp-blog' ),
		'right-top'     => esc_html__( 'Top Right', 'wpsp-blog' ),
		'center-top'    => esc_html__( 'Top Center', 'wpsp-blog' ),
		'left-center'   => esc_html__( 'Center Left', 'wpsp-blog' ),
		'right-center'  => esc_html__( 'Center Right', 'wpsp-blog' ),
		'center-center' => esc_html__( 'Center Center', 'wpsp-blog' ),
		'left-bottom'   => esc_html__( 'Bottom Left', 'wpsp-blog' ),
		'right-bottom'  => esc_html__( 'Bottom Right', 'wpsp-blog' ),
		'center-bottom' => esc_html__( 'Bottom Center', 'wpsp-blog' ),
	);
}