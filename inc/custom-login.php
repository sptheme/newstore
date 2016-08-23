<?php
/**
 * Custom branding in admin page.
 *
 * @package newstore
 */

if ( ! function_exists( 'wpsp_custom_login_logo' ) ) :
/*
 * Custom logo login
 */
function wpsp_custom_login_logo() {
	global $redux_wpsp;
	$logo 					= $redux_wpsp['custom-login-logo']['url'];
	$logo_height 			= ( wpsp_get_redux( 'login-logo-height' ) ) ? wpsp_get_redux( 'login-logo-height' ) : '84px'; 
	$login_bg_color			= wpsp_get_redux( 'login-bg-color' ); 
	
	$out ='<style type="text/css">';
	// logo
	if ( $logo ) {
		$out .= 'body.login div#login h1 a {';
			$out .= 'background:url('. $logo .') center center no-repeat;';
			$out .= 'height: '. intval( $logo_height ) .';';
			$out .= 'width: 100%;';
			$out .= 'display:block;';
		$out .= '}';
	}
	if ( $login_bg_color ) {
		$out .='body.login{ background-color:'. $login_bg_color .'; }';
	}
	$out .='</style>';
	echo $out;
}
add_action('login_head', 'wpsp_custom_login_logo');
endif;

/**
 * Add custom favicon
 */
function wpsp_adminfavicon() {
	global $redux_wpsp;
	$custom_admin_favicon = $redux_wpsp['custom-admin-favicon']['url']; 
	if ( empty($custom_admin_favicon) ) {
		return;
	}
	echo '<link rel="shortcut icon" type="image/x-icon" href="'.$custom_admin_favicon.'" />'."\n";
}
add_action( 'admin_head', 'wpsp_adminfavicon' );

/**
 * Remove wordpress link on admin login logo
 */
function wpsp_remove_link_on_admin_login_info() {
     return  esc_url( home_url() );
}
add_filter('login_headerurl', 'wpsp_remove_link_on_admin_login_info');

/**
 * Change login logo title
 */
function wpsp_change_loging_logo_title(){
	return 'Go to '.get_bloginfo('name').' Homepage';
}
add_filter('login_headertitle', 'wpsp_change_loging_logo_title');

/**
 *Remove logo and other items in Admin menu bar
 */
function wpsp_remove_admin_bar_links() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
	$wp_admin_bar->remove_menu('wp-logo');
}
add_action( 'wp_before_admin_bar_render', 'wpsp_remove_admin_bar_links' );