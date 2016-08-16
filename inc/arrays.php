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