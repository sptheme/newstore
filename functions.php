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
		require_once( get_template_directory() .'/inc/core-functions.php' );
		require_once( get_template_directory() . '/inc/arrays.php' );
		require_once( get_template_directory() . '/inc/layout.php' );
		require_once( get_template_directory() . '/inc/security.php' );
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
	}
}

$wpsp_theme_setup = new WPSP_Theme_Setup();

/**
 * Theme setup and custom theme supports.
 */
require get_template_directory() . '/inc/setup.php';

/**
* Load functions to secure your WP install.
*/


/**
 * Enqueue scripts and styles.
 */
require get_template_directory() . '/inc/enqueue.php';

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
