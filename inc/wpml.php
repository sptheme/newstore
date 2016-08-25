<?php
/**
 * WPML Configuration Class
 *
 * Used to fix issues with translation plugins such as WPML
 *
 * @package newstore
 */

function register_strings() {
	if ( function_exists( 'icl_register_string' ) && $strings = wpsp_register_theme_mod_strings() ) {
		foreach( $strings as $string => $default ) {
			icl_register_string( 'Theme Mod', $string, get_theme_mod( $string, $default ) );
		}
	}
}

/**
 * Returns correct ID for any object
 * Used to fix issues with translation plugins such as WPML
 *
 * @since 1.0.0
 */
function wpsp_parse_obj_id( $id = '', $type = 'page' ) {
	if ( $id && function_exists( 'icl_object_id' ) ) {
		$id = icl_object_id( $id, $type );
	}
	return $id;
}

/**
 * Retrives a theme mod value and translates it
 * Note :	Translated strings do not have any defaults in the Customizer
 *			Because they all have localized fallbacks.
 *
 * @since 1.0.0
 */
function wpsp_get_translated_theme_mod( $id ) {
	return wpsp_translate_theme_mod( $id, wpsp_get_redux( $id ) );
}

/**
 * Provides translation support for plugins such as WPML for theme_mods
 *
 * @since 1.0.0
 */
function wpsp_translate_theme_mod( $id, $val = '' ) {

	// Translate theme mod val
	if ( $val ) {

		// WPML translation
		if ( function_exists( 'icl_t' ) && $id ) {
			$val = icl_t( 'Theme Mod', $id, $val );
		}

		// Polylang Translation
		if ( function_exists( 'pll__' ) && $id ) {
			$val = pll__( $val );
		}

		// Return the value
		return $val;

	}

}

/**
 * Register theme mods for translations
 *
 * @since 1.0.0
 */
function wpsp_register_theme_mod_strings() {
	return apply_filters( 'wpsp_register_theme_mod_strings', array(
		'custom_logo'                    => false,
		'retina_logo'                    => false,
		'logo_height'                    => false,
		'error_page_title'               => '404: Page Not Found',
		'error_page_text'                => false,
		'top_bar_content'                => '[font_awesome icon="phone" margin_right="5px" color="#000"] 1-800-987-654 [font_awesome icon="envelope" margin_right="5px" margin_left="20px" color="#000"] admin@total.com [font_awesome icon="user" margin_right="5px" margin_left="20px" color="#000"] [wp_login_url text="User Login" logout_text="Logout"]',
		'top_bar_social_alt'             => false,
		'header_aside'                   => false,
		'breadcrumbs_home_title'         => false,
		'blog_entry_readmore_text'       => 'Read More',
		'social_share_heading'           => 'Please Share This',
		'portfolio_related_title'        => 'Related Projects',
		'staff_related_title'            => 'Related Staff',
		'blog_related_title'             => 'Related Posts',
		'callout_text'                   => 'I am the footer call-to-action block, here you can add some relevant/important information about your company or product. I can be disabled in the theme options.',
		'callout_link'                   => 'http://www.yourdomaint.com',
		'callout_link_txt'               => 'Get In Touch',
		'footer_copyright_text'          => 'Copyright <a href="#">Your Business Co.,Ltd.</a> - All Rights Reserved',
		'woo_shop_single_title'          => 'Store',
		'woo_menu_icon_custom_link'      => '',
		'blog_single_header_custom_text' => 'Blog',
		'mobile_menu_toggle_text'        => 'Menu',
	) );
}