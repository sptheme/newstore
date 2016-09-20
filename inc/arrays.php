<?php
/**
 * Useful functions that return arrays
 *
 * @package newstore
 */

function header_styles() {
	return apply_filters( 'wpsp_header_styles', array(
        'one' => esc_html__( 'One - Left Logo & Right Navbar','newstore' ),
        'two' => esc_html__( 'Two - Bottom Navbar','newstore' ),
        'three' => esc_html__( 'Three - Bottom Navbar Centered','newstore' ),
        'four' => esc_html__( 'Four - Top Navbar Centered','newstore' ),
        'five' => esc_html__( 'Five - Centered Inline Logo','newstore' ),
        'six' => esc_html__( 'Six - Vertical','newstore' ),
    ) );
}

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