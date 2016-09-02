<?php
/**
 * newstore functions and definitions
 *
 * @package newstore
 */

/**
 * Startup class
 * 
 * @version 1.0.0
 */
class WPSP_Theme_Setup {
	
	function __construct() {

		// Define theme info
		add_action( 'after_setup_theme', array( $this, 'theme_info' ), 0 );

		// Defines hooks and runs actions
		add_action( 'init', array( $this, 'hooks_actions' ), 0 );

		// Load the scripts in WP Admin
		add_action( 'admin_enqueue_scripts', array( $this, 'wpsp_admin_scripts' ) );

		// Load theme js
		add_action( 'wp_enqueue_scripts', array( $this, 'theme_scripts' ) );

		// Outputs custom CSS to the head
		add_action( 'wp_head', array( $this, 'custom_css' ), 9999 );

		// Register sidebar
		add_action( 'widgets_init', array( $this, 'register_sidebar' ), 1 );

		// Load all core theme function files
		add_action( 'after_setup_theme', array( $this, 'wpsp_include_functions' ), 2 );

		// Load configuration classes (post types & 3rd party plugins)
		add_action( 'after_setup_theme', array( $this, 'configs'), 3 );

	}

	/**
	 * Define theme information
	 * 
	 * @version 1.0.0
	 */
	public function theme_info() {
		// Theme info
		$theme = wp_get_theme( 'newstore' );
		$theme_name = $theme['Name'];
		$theme_version = $theme['Version'];
		
		// Branding
		define( 'THEME_BRANDING', $theme_name );
		define( 'THEME_VERSION', $theme_version );
		define( 'THEME_BRANDING_PREFIX', 'NST');
	}

	/**
	 * Defines all theme hooks and runs all needed actions for theme hooks.
	 *
	 * @since 1.0.0
	 */
	public static function hooks_actions() {

		// Register hooks
		require_once( get_template_directory() .'/inc/hooks/hooks.php' );

		// Front-end stuff
		if ( ! is_admin() ) {
			require_once( get_template_directory() .'/inc/hooks/actions.php' );
			require_once( get_template_directory() .'/inc/hooks/partials.php' );
		}

	}

	/**
	 * Load custom admin scripts
	 *
	 * @since 1.0.0
	 */
	public static function wpsp_admin_scripts( $hook ) {
	    if ( !in_array($hook, array('post.php','post-new.php')) )
	    return;
	    wp_enqueue_script( 'admin-scripts', get_template_directory_uri() . '/js/admin-scripts.js', array( 'jquery' ) );
	}

	/**
	 *Enqueue scripts and styles
	 *
	 * @version 1.0.0
	 */
	public function theme_scripts() {
		$localize_array = $this->localize_array();

	    wp_enqueue_style( 'styles', get_stylesheet_directory_uri() . '/css/theme.min.css', array(), '0.4.6');
	    wp_enqueue_script('jquery'); 

	    // Superfish used for menu dropdowns
		wp_enqueue_script( 'wpsp-superfish', get_stylesheet_directory_uri() .'/js/vendors/superfish.js', array( 'jquery' ), THEME_VERSION, true );
		wp_enqueue_script( 'wpsp-supersubs', get_stylesheet_directory_uri() .'/js/vendors/supersubs.js', array( 'jquery' ), THEME_VERSION, true );
		wp_enqueue_script( 'wpsp-hoverintent', get_stylesheet_directory_uri() .'/js/vendors/hoverintent.js', array( 'jquery' ), THEME_VERSION, true );
		wp_enqueue_script( 'wpsp-leanner-modal', get_stylesheet_directory_uri() .'/js/vendors/leanner-modal.js', array( 'jquery' ), THEME_VERSION, true );

	    wp_enqueue_script( 'scripts', get_template_directory_uri() . '/js/theme.min.js', array(), '0.4.6', true );

	    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	        wp_enqueue_script( 'comment-reply' );
	    }

	    
	    wp_enqueue_script( 'wpsp-custom-script', get_template_directory_uri() .'/js/custom.js', array( 'jquery' ), THEME_VERSION, true );
	    // Localize script
	    wp_localize_script( 'wpsp-custom-script', 'wpspLocalize', $localize_array );

	}

	/**
	 * Localize array
	 * 
	 * @version 1.0.0
	 */
	public static function localize_array() {

		$header_style      = wpsp_get_redux( 'header-style' );
		$sticky_header     = wpsp_get_redux( 'is-fixed-header' );
		$has_fixed_header  = wpsp_has_fixed_header();
		$fixed_header_style = wpsp_fixed_header_style();
		$wpsp_shrink_fixed_header = wpsp_shrink_fixed_header();

		$array = array(
			'isRTL'                 => is_rtl(),
			'menuSearchStyle'       => wpsp_get_redux( 'menu-search-style' ),
			'hasStickyHeader'       => $sticky_header,	        
			'siteHeaderStyle'       => $header_style,
			'superfishDelay'        => 600,
			'superfishSpeed'        => 'fast',
			'superfishSpeedOut'     => 'fast',			
	    );

	    // Header params 
		if ( 'disabled' != $header_style ) {

			// Sticky Header
			if ( $has_fixed_header ) {
				$array['hasStickyHeader'] = true;
				$array['stickyHeaderStyle']      = $fixed_header_style;
				$array['hasStickyMobileHeader']  = wpsp_get_redux( 'is-fixed-header-mobile' );
				$array['overlayHeaderStickyTop'] = 0;
				$array['stickyHeaderBreakPoint'] = 960;

				// Shrink sticky header > used for local-scroll offset
				if ( $wpsp_shrink_fixed_header ) {
					$height = intval( wpsp_get_redux( 'fixed-header-shrink-end-height', 50 ) );
					$height = $height ? $height + 20 : 70;
					$array['shrinkHeaderHeight'] = $height;
				}
				
			}

			// Header five
			if ( 'five' == $header_style ) {
				$array['headerFiveSplitOffset'] = 1;
			}

		} // End header params

		return apply_filters( 'wpsp_localize_array', $array );
	}

	/**
	 * All theme functions hook into the wpex_head_css filter for this function.
	 * This way all dynamic CSS is minified and outputted in one location in the site header.
	 *
	 * @since 1.0.0
	 */
	public static function custom_css( $output = NULL ) {

		global $redux_wpsp;

		// Add filter for adding custom css via other functions
		$output = apply_filters( 'wpsp_head_css', $output );

		// Page header
		$bg = $redux_wpsp['page-title-background-img']['url'];
		if ( $bg ) {
			$output .= '.page-header.wpsp-supports-mods{background-image:url('. $bg .');}';
		}

		// Minify and output CSS in the wp_head
		if ( ! empty( $output ) ) {
			echo "<!-- Custom CSS -->\n<style type=\"text/css\">\n" . wp_strip_all_tags( wpsp_minify_css( $output ) ) . "\n</style>";
		}

	}

	/**
	 * Register widget area.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
	 *
	 * @version 1.0.0
	 */
	public static function register_sidebar() {
		require_once( get_template_directory() . '/inc/widgets.php' );
	}

	/**
	 * Framework functions
	 * Load before Classes & Addons so we can use them
	 *
	 * @since 1.0.0
	 */
	public static function wpsp_include_functions() {
		require_once( get_template_directory() . '/inc/core-functions.php' );
		require_once( get_template_directory() . '/inc/security.php' );
		require_once( get_template_directory() . '/inc/sanitize-data.php' );
		require_once( get_template_directory() . '/inc/arrays.php' );
		require_once( get_template_directory() . '/inc/wpml.php' );
		require_once( get_template_directory() . '/inc/custom-login.php' );
		require_once( get_template_directory() . '/inc/layout.php' );
		require_once( get_template_directory() . '/inc/header-functions.php' ); // main navigation style
		require_once( get_template_directory() . '/inc/page-header.php' ); // page title style
	}

	/**
	 * Configs for post types and 3rd party plugins.
	 * 
	 * @version 1.0.0
	 */
	public static function configs(){
		// Register post type will goes here

		// Add admin option with redux framework
		require_once( get_template_directory() . '/inc/admin/admin-init.php' );

		// Included Metabox.io framework as meta boxes of theme core
		require_once( get_template_directory() . '/inc/meta-box/meta-box.php' );
		require_once( get_template_directory() . '/inc/meta-box/meta-config.php' );

		// Add shortcode supports
		require_once( get_template_directory() . '/inc/shortcodes/shortcodes.php' );		
	}
}

$wpsp_theme_setup = new WPSP_Theme_Setup();

/**
 * Theme setup and custom theme supports.
 */
require get_template_directory() . '/inc/setup.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/custom-comments.php';

/**
* Load custom WordPress nav walker.
*/
require get_template_directory() . '/inc/bootstrap-wp-navwalker.php';

/**
* Load custom WordPress gallery.
*/
require get_template_directory() . '/inc/bootstrap-wp-gallery.php';


/**
* Load WooCommerce functions.
*/
require get_template_directory() . '/inc/woocommerce.php';
