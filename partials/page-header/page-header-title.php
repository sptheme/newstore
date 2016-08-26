<?php
/**
 * Returns the post title
 *
 * @see inc/page-header.php for all functions attached to the header hooks.
 * @see inc/hooks/actions.php for all functions attached to the header hooks.
 *
 * @package newstore
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define title args
$args = array();

// Single post markup
if ( ( is_singular( 'post' ) && 'custom_text' == wpsp_get_redux( 'blog-single-header', 'custom_text' ) ) ) {
	$args['html_tag'] = 'span';
	$args['schema_markup'] = '';
}

// Singular CPT
elseif ( is_singular() && ( ! is_singular( 'page' ) && ! is_singular( 'attachment' ) ) ) {
	$args['html_tag'] = 'span';
	$args['schema_markup'] = '';
}

// Apply filters
$args = apply_filters( 'wpsp_page_header_title_args', $args );

// Parse args to prevent empty attributes and extract
extract( wp_parse_args( $args, array(
	'html_tag'      => 'h1',
	'string'        => wpsp_title(),
	'schema_markup' => wpsp_get_schema_markup( 'headline' )
) ) );

// Display title
if ( ! empty( $string ) ) {
	echo '<'. strip_tags( $html_tag ) .' class="page-header-title"'. $schema_markup .'>'. wpsp_sanitize_data( $string, 'html' ) .'</'. strip_tags( $html_tag ) .'>';
}