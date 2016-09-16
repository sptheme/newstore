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

function wpsp_hook_page_before() {
	do_action( 'wpsp_hook_page_before' );
}
function wpsp_hook_page_after() {
	do_action( 'wpsp_hook_page_after' );
}
function wpsp_hook_page_top() {
	do_action( 'wpsp_hook_page_top' );
}
function wpsp_hook_page_bottom() {
	do_action( 'wpsp_hook_page_bottom' );
}

/**
 * Wrapper content hooks
 * 
 * @version 1.0.0
 */

function wpsp_hook_wrapper_content_before() {
	do_action( 'wpsp_hook_wrapper_content_before' );
}
function wpsp_hook_wrapper_content_after() {
	do_action( 'wpsp_hook_wrapper_content_after' );
}
function wpsp_hook_wrapper_content_top() {
	do_action( 'wpsp_hook_wrapper_content_top' );
}
function wpsp_hook_wrapper_content_bottom() {
	do_action( 'wpsp_hook_wrapper_content_bottom' );
}

/**
 * Header hooks
 * 
 * @version 1.0.0
 */

function wpsp_hook_header_before() {
	do_action( 'wpsp_hook_header_before' );
}
function wpsp_hook_header_top() {
	do_action( 'wpsp_hook_header_top' );
}
function wpsp_hook_header_inner() {
	do_action( 'wpsp_hook_header_inner' );
}
function wpsp_hook_header_bottom() {
	do_action( 'wpsp_hook_header_bottom' );
}
function wpsp_hook_header_after() {
	do_action( 'wpsp_hook_header_after' );
}

/**
 * Footer Hooks
 *
 * @since 1.0.0
 */
function wpsp_hook_footer_before() {
	do_action( 'wpsp_hook_footer_before' );
}
function wpsp_hook_footer_top() {
	do_action( 'wpsp_hook_footer_top' );
}
function wpsp_hook_footer_inner() {
	do_action( 'wpsp_hook_footer_inner' );
}
function wpsp_hook_footer_bottom() {
	do_action( 'wpsp_hook_footer_bottom' );
}
function wpsp_hook_footer_after() {
	do_action( 'wpsp_hook_footer_after' );
}

/**
 * Main Menu Hooks
 *
 * @since 1.0.0
 */
function wpsp_hook_main_menu_before() {
	do_action( 'wpsp_hook_main_menu_before' );
}
function wpsp_hook_main_menu_top() {
	do_action( 'wpsp_hook_main_menu_top' );
}
function wpsp_hook_main_menu_bottom() {
	do_action( 'wpsp_hook_main_menu_bottom' );
}
function wpsp_hook_main_menu_after() {
	do_action( 'wpsp_hook_main_menu_after' );
}

/**
 * Page Header Hooks
 *
 * @since 1.0.0
 */
function wpsp_hook_page_header_top() {
	do_action( 'wpsp_hook_page_header_top' );
}
function wpsp_hook_page_header_inner() {
	do_action( 'wpsp_hook_page_header_inner' );
}
function wpsp_hook_page_header_bottom() {
	do_action( 'wpsp_hook_page_header_bottom' );
}