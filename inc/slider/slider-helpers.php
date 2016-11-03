<?php 
/**
 * Useful global functions for the slider
 *
 * @package newstore
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Checks if on a theme slider category page.
 *
 * @since 1.1.0
 */
function wpsp_is_slider_tax() {
	if ( ! is_search() && ( is_tax( 'slider_category' ) || is_tax( 'slider_tag' ) ) ) {
		return true;
	} else {
		return false;
	}
}

add_filter( 'rwmb_meta_boxes', 'wpsp_register_slider_meta_boxes' );

function wpsp_register_slider_meta_boxes( $meta_boxes ) {
	$prefix = 'wpsp_';

	$meta_boxes[] = array(
    	'id'			=> 'slider-options',
		'title'			=> __( 'Slider setting', 'wpsp-meta-box' ),
		'post_types'	=> array( 'slider' ),
		'context'		=> 'normal', // Where the meta box appear: normal (default), advanced, side. Optional.
		'priority'		=> 'high', // Order of meta box: high (default), low. Optional.
		'autosave'		=> true, // Auto save: true, false (default). Optional.

		'fields'		=> array(
			array(
				'name'  => __( 'Slide link', 'wpsp-meta-box' ), 
				'id'    => $prefix . "slide_link",
				'desc' => __( 'URL/Link for slide (e.g: http://google.com). You can keep it blank, if does not have link', 'wpsp-meta-box' ),
				'type'  => 'url',
				'std'  => '',
			),
			array(
				'name'  => __( 'Slide link', 'wpsp-meta-box' ), 
				'id'    => $prefix . "slide_link_target",
				'type'  => 'select',
				'options'     => array(
					'_blank' => __( 'Open link in new tab', 'wpsp-meta-box' ),
					'_self' => __( 'Open link in current tab', 'wpsp-meta-box' ),
				),
			),
		)
    );

    return $meta_boxes;
}
