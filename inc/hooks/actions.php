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


/* Page > Top
-------------------------------------------------------------------------------*/
add_action( 'wpsp_hook_page_top', 'wpsp_header' );

/*-------------------------------------------------------------------------------*/
/* #  Header
/*-------------------------------------------------------------------------------*/

/* Header > Inner
-------------------------------------------------------------------------------*/
add_action( 'wpsp_hook_header_inner', 'wpsp_header_logo' );

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