<?php
/**
 * Setup theme hooks
 *
 * @package newstore
 */

/**
 * Page hooks
 * 
 * @version 1.0.0
 */

function wpsp_page_before() {
	do_action( 'wpsp_page_before' );
}
function wpsp_page_after() {
	do_action( 'wpsp_page_after' );
}
function wpsp_page_top() {
	do_action( 'wpsp_page_top' );
}
function wpsp_page_bottom() {
	do_action( 'wpsp_page_bottom' );
}

/**
 * Wrapper content hooks
 * 
 * @version 1.0.0
 */

function wpsp_wrapper_content_before() {
	do_action( 'wpsp_wrapper_content_before' );
}
function wpsp_wrapper_content_after() {
	do_action( 'wpsp_wrapper_content_after' );
}
function wpsp_wrapper_content_top() {
	do_action( 'wpsp_wrapper_content_top' );
}
function wpsp_wrapper_content_bottom() {
	do_action( 'wpsp_wrapper_content_bottom' );
}