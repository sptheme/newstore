<?php
/**
 * Shortcodes functions
 *
 * @package newstore
 */

/**
 * Print script and style of shortcodes
 */
//add_action( 'wp_enqueue_scripts', 'add_script_style_sc' );

function add_script_style_sc() {
	global $post;
	if( !is_admin() ){
		wp_enqueue_script( 'shortcode-js', SC_JS_URL . 'shortcodes.js', array(), SC_VER, true );
		wp_enqueue_style( 'shortcode', SC_CSS_URL . 'shortcodes.css', false, SC_VER );
	}
	
}

/**
 * Register and initialize short codes
 */
function wpsp_add_shortcodes() {
	add_shortcode( 'wpsp_row', 'wpsp_row' );
	add_shortcode( 'container_box', 'container_box' );
	add_shortcode( 'col', 'col' );
	add_shortcode( 'spacer_horz', 'spacer_horz' );
	add_shortcode( 'box_color', 'box_color' );
}
add_action( 'init', 'wpsp_add_shortcodes' );

/**
 * Fix Shortcodes 
 */
if( !function_exists('wpsp_fix_shortcodes') ) {
	function wpsp_fix_shortcodes($content){
		$array = array (
			'<p>['		=> '[', 
			']</p>'		=> ']', 
			']<br />'	=> ']'
		);
		$content = strtr($content, $array);
		return $content;
	}
}
add_filter('the_content', 'wpsp_fix_shortcodes');

/**
 * Helper function for removing automatic p and br tags from nested short codes
 */
function return_clean( $content, $p_tag = false, $br_tag = false )
{
	$content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content );

	if ( $br_tag )
		$content = preg_replace( '#<br \/>#', '', $content );

	if ( $p_tag )
		$content = preg_replace( '#<p>|</p>#', '', $content );

	return do_shortcode( shortcode_unautop( trim( $content ) ) );
}

/**
 * Column
 */
function container_box( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'class' => 'full'
	), $atts ) );
	return '<div class="container ' . $class . '">' . return_clean($content) . '</div>';
}

/**
 * Row shortcode
 *
 */
function wpsp_row( $atts, $content = null ) {
	return '<div class="row">' . return_clean($content). '</div>';
}

/**
 * Column
 */
function col( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'type' => 'full'
	), $atts ) );
	return '<div class="col-' . $type . '">' . return_clean($content) . '</div>';
}

/**
 * Divide
 */
function spacer_horz($atts, $content = null) {
	
	extract(shortcode_atts(array(
		'padding_top' => '10',
		'padding_bottom' => '10'
	), $atts));
	
	return '<div class="' .$style . '" style="padding-top:' . $padding_top . 'px;padding-bottom:' . $padding_bottom . 'px;"></div>';
}

/**
 * Box color
 */
function box_color($atts, $content = null) {
	
	extract(shortcode_atts(array(
		'bg_color' => '',
		'font_color' => '',
		'padding_top' => '10',
		'padding_right' => '10',
		'padding_bottom' => '10',
		'padding_left' => '10'
	), $atts));
	
	return '<div class="' .$style . '" style="background:' . $bg_color . '; color:' . $font_color . '; padding:' . $padding_top . 'px ' . $padding_right . 'px '  . $padding_bottom . 'px ' . $padding_left . 'px">' . return_clean($content). '</div>';
}


