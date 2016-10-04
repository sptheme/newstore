<?php
/**
 * All core theme actions.
 *
 * @package newstore
 */

/*-------------------------------------------------------------------------------*/
/* #  Page
/*-------------------------------------------------------------------------------*/

/* Page > Before
-------------------------------------------------------------------------------*/
//add_action( 'wpsp_hook_page_before', 'wpsp_mobile_menu_navbar' ); // @TODO: has_overlay_header
add_action( 'wpsp_hook_page_before', 'wpsp_mobile_menu_fixed_top' );

/* Page > Top
-------------------------------------------------------------------------------*/
add_action( 'wpsp_hook_page_top', 'wpsp_header' );

/*-------------------------------------------------------------------------------*/
/* #  Header
/*-------------------------------------------------------------------------------*/

/* Header > Top
-------------------------------------------------------------------------------*/
add_action( 'wpsp_hook_header_top', 'wpsp_header_menu' );

/* Header > Inner
-------------------------------------------------------------------------------*/
add_action( 'wpsp_hook_header_inner', 'wpsp_header_logo' );
add_action( 'wpsp_hook_header_inner', 'wpsp_header_menu' );
add_action( 'wpsp_hook_header_inner', 'wpsp_mobile_menu_icons' );
add_action( 'wpsp_hook_header_inner', 'wpsp_search_dropdown' );
add_action( 'wpsp_hook_header_inner', 'wpsp_search_header_replace' );

/* Header > Bottom
-------------------------------------------------------------------------------*/
add_action( 'wpsp_hook_header_bottom', 'wpsp_header_menu' );
add_action( 'wpsp_hook_header_bottom', 'wpsp_mobile_menu_navbar' );

/* Menu > Bottom
-------------------------------------------------------------------------------*/
add_action( 'wpsp_hook_main_menu_bottom', 'wpsp_search_dropdown' );

/*-------------------------------------------------------------------------------*/
/* #  Content
/*-------------------------------------------------------------------------------*/

/* Page Header > Bottom
-------------------------------------------------------------------------------*/
// Hook will goes here...

/* Content > Top
-------------------------------------------------------------------------------*/
add_action( 'wpsp_hook_wrapper_content_top', 'wpsp_page_header' );

/* Page Header > Inner
-------------------------------------------------------------------------------*/
add_action( 'wpsp_hook_page_header_inner', 'wpsp_page_header_title_table_wrap_open', 0 );
add_action( 'wpsp_hook_page_header_inner', 'wpsp_page_header_title' );
add_action( 'wpsp_hook_page_header_inner', 'wpsp_page_header_subheading' );
add_action( 'wpsp_hook_page_header_inner', 'wpsp_page_header_title_table_wrap_close', 9999 );

/* Page Header > Bottom
-------------------------------------------------------------------------------*/
add_action( 'wpsp_hook_page_header_bottom', 'wpsp_page_header_overlay' ); // @see page-header.php

/* Main > Top
-------------------------------------------------------------------------------*/
add_action( 'wpsp_hook_main_top', 'wpsp_term_description' );

/* Wrap > Bottom
-------------------------------------------------------------------------------*/
add_action( 'wpsp_hook_wrapper_content_bottom', 'wpsp_footer' );

/* Footer > Before
-------------------------------------------------------------------------------*/
//add_action( 'wpsp_hook_footer_before', 'wpsp_footer_subscripe' );

/* Footer > Inner
-------------------------------------------------------------------------------*/
add_action( 'wpsp_hook_footer_inner', 'wpsp_footer_widgets' );

/* Footer > After
-------------------------------------------------------------------------------*/
add_action( 'wpsp_hook_footer_after', 'wpsp_footer_bottom' );


/* WP_Footer
-------------------------------------------------------------------------------*/
add_action( 'wp_footer', 'wpsp_mobile_menu_alt' );
add_action( 'wp_footer', 'wpsp_search_overlay' );
add_action( 'wp_footer', 'wpsp_sidr_close' );
add_action( 'wp_footer', 'wpsp_mobile_searchform' );
add_action( 'wp_footer', 'wpsp_scroll_top' );