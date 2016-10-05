<?php
/**
 * Perform all main WooCommerce configurations for this theme
 *
 * @package newstore
 * @subpackage WooCommerce
 * @version 1.0.0
 */

// Define global var for class, make child theme easier/possible
global $wpsp_woocommerce_config;

// Start and run
if ( ! class_exists( 'WPSP_WooCommerce_Config' ) ) {
	
	class WPSP_WooCommerce_Config {

		/**
		* Main class constructor
		*/
		function __construct(){
			
			// Setup wooCommerce options with reduxframework
			include_once( get_template_directory() . '/inc/woocommerce/woocommerce-options-redux.php' );
			
			// WooCommerce helper functions
			include_once( get_template_directory() . '/inc/woocommerce/woocommerce-helper.php' );

			// These filters/actions must run on init
			add_action( 'init', array( $this, 'init' ) );

			// Add new image sizes for WooCommerce
			add_filter( 'wpsp_image_sizes', array( $this, 'add_image_sizes' ), 99 );

			// Register Woo Sidebar
			add_filter( 'widgets_init', array( $this, 'register_woo_sidebar' ) );

			if ( ! is_admin() ) {
				// Display correct sidebar for products
				add_filter( 'wpsp_sidebar_primary', array( $this, 'display_woo_sidebar' ) );

				// Set correct post layouts
				add_filter( 'wpsp_post_layout_class', array( $this, 'layouts' ) );

				// Alter page header title
				add_filter( 'wpsp_title', array( $this, 'title_config' ) );

				// Show/hide main page header
				add_filter( 'wpsp_display_page_header', array( $this, 'display_page_header' ) );

				// Alter page header subheading
				add_filter( 'wpsp_post_subheading', array( $this, 'alter_subheadings' ) );

				// Show/hide category description
				add_filter( 'wpsp_has_term_description_above_loop', array( $this, 'term_description_above_loop' ) );

				// Show/hide social share on products
				add_filter( 'wpsp_has_social_share', array( $this, 'post_social_share' ) );

				// Show/hide next/prev on products
				add_filter( 'wpsp_has_next_prev', array( $this, 'next_prev' ) );
			}

			// Scripts
			add_action( 'woocommerce_enqueue_styles', array( $this, 'remove_styles' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'remove_scripts' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'add_custom_css' ) );

			// Menu cart
			add_action( 'wpsp_hook_header_inner', array( $this, 'cart_dropdown' ), 40 );
			add_action( 'wpsp_hook_main_menu_bottom', array( $this, 'cart_dropdown' ) );
			add_action( 'wp_footer', array( $this, 'cart_overlay' ) );

			// Product entries
			add_action( 'woocommerce_before_shop_loop_item', array( $this, 'add_shop_loop_item_inner_div' ) );
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'close_shop_loop_item_inner_div' ) );
			add_action( 'woocommerce_before_shop_loop_item', array( $this, 'add_shop_loop_item_out_of_stock_badge' ) );

			// Product post
			add_action( 'woocommerce_after_single_product_summary', array( $this, 'clear_summary_floats' ), 1 );

			// Main Woo Filters
			add_filter( 'wp_nav_menu_items', array( $this, 'menu_cart_icon' ) , 10, 2 );
			add_filter( 'add_to_cart_fragments', array( $this, 'menu_cart_icon_fragments' ) );
			add_filter( 'woocommerce_general_settings', array( $this, 'remove_general_settings' ) );
			add_filter( 'woocommerce_product_settings', array( $this, 'remove_product_settings' ) );
			add_filter( 'woocommerce_sale_flash', array( $this, 'woocommerce_sale_flash' ), 10, 3 );
			add_filter( 'loop_shop_per_page', array( $this, 'loop_shop_per_page' ), 20 );
			add_filter( 'loop_shop_columns', array( $this, 'loop_shop_columns' ) );
			add_filter( 'post_class', array( $this, 'add_product_entry_classes' ) );
			add_filter( 'product_cat_class', array( $this, 'product_cat_class' ) );
			add_filter( 'woocommerce_cart_item_thumbnail', array( $this, 'cart_item_thumbnail' ), 10, 3 );
			add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_product_args' ) );
			add_filter( 'woocommerce_pagination_args', array( $this, 'pagination_args' ) );
			add_filter( 'woocommerce_continue_shopping_redirect', array( $this, 'continue_shopping_redirect' ) );
		}

		/**
		 * Runs on Init.
		 * You can't remove certain actions in the constructor because it's too early.
		 *
		 * @since 1.0.0
		 */
		public function init() {

			// Remove category descriptions, these are added already by the theme
			remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );

			// Alter cross-sells display
			remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
			add_action( 'woocommerce_cart_collaterals', array( $this, 'cross_sell_display' ) );

			// Alter upsells display
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
			add_action( 'woocommerce_after_single_product_summary', array( $this, 'upsell_display' ), 15 );

			// Alter WooCommerce category thumbnail
			remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10 );
			add_action( 'woocommerce_before_subcategory_title', array( $this, 'subcategory_thumbnail' ), 10 );

			// Remove loop product thumbnail function and add our own that pulls from template parts
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'loop_product_thumbnail' ), 10 );

			// Remove coupon from checkout
			//remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

			// Remove single meta
			if ( ! wpsp_get_redux( 'woo-product-meta', true ) ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
			}

			// Remove upsells if set to 0
			if ( '0' == wpsp_get_redux( 'woocommerce-upsells-count', '4' ) ) {
				remove_action( 'woocommerce_after_single_product_summary', 'wpex_woocommerce_output_upsells', 15 );
			}

			// Remove related products if count is set to 0
			if ( '0' == wpsp_get_redux( 'woocommerce-related-count', '4' ) ) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
			}

			// Remove crossells if set to 0
			if ( '0' == wpsp_get_redux( 'woocommerce-cross-sells-count', '4' ) ) {
				remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
			}

			// Remove result count if disabled
			if ( ! wpsp_get_redux( 'is-woo-shop-result-count', true ) ) {
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
			}

			// Remove orderby if disabled
			if ( ! wpsp_get_redux( 'is-woo-shop-sort', true ) ) {
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
			}
		}

		/**
		 * Adds image sizes for WooCommerce to the image sizes panel.
		 *
		 * @since 1.0.0
		 */
		public static function add_image_sizes( $sizes ) {
			return array_merge( $sizes, array(
					'shop_catalog' => array(
						'label'   => esc_html__( 'Product Entry', 'newstore' ),
						'width'   => 'woo-entry-image-width',
						'height'  => 'woo-entry-image-height',
						'crop'    => 'woo-entry-crop-location',
					),
					'shop_single' => array(
						'label'   => esc_html__( 'Product Post', 'newstore' ),
						'width'   => 'woo-post-image-width',
						'height'  => 'woo-post-image-height',
						'crop'    => 'woo-post-crop-location',
					),
					'shop_single_thumbnail' => array(
						'label'   => esc_html__( 'Product Post Thumbnail', 'newstore' ),
						'width'   => 'woo-post-thumb-width',
						'height'  => 'woo-post-thumb-height',
						'crop'    => 'woo-post-thumb-crop-location',
					),
					'shop_thumbnail' => array(
						'label'     => esc_html__( 'Shop & Cart Thumbnail', 'newstore' ),
						'width'     => 'woo-shop-thumb-width',
						'height'    => 'woo-shop-thumb-height',
						'crop'      => 'woo-shop-thumb-crop-location',
					),
					'shop_category' => array(
						'label'     => esc_html__( 'Product Category Entry', 'newstore' ),
						'width'     => 'woo-cat-entry-width',
						'height'    => 'woo-cat-entry-height',
						'crop'      => 'woo-cat-entry-crop-location',
					)
				)
			);
		}

		/**
		 * Change products per row for crossells.
		 *
		 * @since 1.0.0
		 */
		public static function cross_sell_display() {
			// Get count
			$count = wpsp_get_redux( 'woocommerce-cross-sells-count', 2 );
			$count = $count ? $count : '2';
			// Get columns
			$columns = wpsp_get_redux( 'woocommerce-cross-sells-columns', 2 );
			$columns = $columns ? $columns : '2';
			// Alter cross-sell display
			woocommerce_cross_sell_display( $count, $columns );
		}

		/**
		 * Change products per row for upsells.
		 *
		 * @since 1.0.0
		 */
		public static function upsell_display() {
			// Get count
			$count = wpsp_get_redux( 'woocommerce-upsells-count', 3 );
			$count = $count ? $count : '3';
			// Get columns
			$columns = wpsp_get_redux( 'woocommerce-upsells-columns', 3 );
			$columns = $columns ? $columns : '3';
			// Alter upsell display
			woocommerce_upsell_display( $count, $columns );
		}

		/**
		 * Change category thumbnail.
		 *
		 * @since 1.0.0
		 */
		public static function subcategory_thumbnail( $category ) {

			// Get attachment id
			$attachment      = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );
			$attachment_data = wpsp_get_attachment_data( $attachment );

			// Get alt
			if ( ! empty( $attachment_data['alt'] ) ) {
				$alt = $attachment_data['alt'];
			} else {
				$alt = $category->name;
			}

			// Return thumbnail if attachment is defined
			if ( $attachment ) {

				wpsp_post_thumbnail( array(
					'attachment' => $attachment,
					'size'       => 'shop_category',
					'alt'        => esc_attr( $alt ),
				) );

			}

			// Display placeholder
			else {

				echo '<img src="'. wc_placeholder_img_src() .'" alt="'. esc_html__( 'Placeholder Image', 'newstore' ) .'" />';

			}

		}

		/**
		 * Returns our product thumbnail from our template parts based on selected style in theme mods.
		 *
		 * @since 1.0.0
		 */
		public static function loop_product_thumbnail() {
			if ( function_exists( 'wc_get_template' ) ) {
				// Get entry product media style
				$style = wpsp_get_redux( 'woo-product-entry-style', 'image-swap' ); // image-swap, featured-image, gallery-slider
				$style = $style ? $style : 'image-swap';
				// Get entry product media template part
				wc_get_template(  'loop/thumbnail/'. $style .'.php' );
			}
		}

		/**
		* Register WooCommerce Sidebar
		*
		* @since 1.0.0
		*/
		public static function register_woo_sidebar() {
			// Get correct sidebar heading tag
			$sidebar_headings = wpsp_get_redux( 'sidebar-headings', 'div' );
			$sidebar_headings = $sidebar_headings ? $sidebar_headings : 'div';

			// Register new woo_sidebar widget area
			register_sidebar( array (
				'name'          => esc_html__( 'WooCommerce Sidebar', 'newstore' ),
				'id'            => 'woo_sidebar',
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );
		}

		/**
		 * Display WooCommerce sidebar.
		 *
		 * @since 1.0.0
		 */
		public static function display_woo_sidebar( $sidebar ) {

			// Alter sidebar display to show woo_sidebar where needed
			if ( is_woocommerce() && is_active_sidebar( 'woo_sidebar' ) ) {
				$sidebar = 'woo_sidebar';
			}

			// Return correct sidebar
			return $sidebar;

		}

		/**
		 * Tweaks the post layouts for WooCommerce archives and single product posts.
		 *
		 * @since 1.0.0
		 */
		public static function layouts( $class ) {
			if ( wpsp_is_woo_shop() && ( wpsp_get_redux('woo-shop-layout') !='inherit' ) ) {
				$class = wpsp_get_redux( 'woo-shop-layout', 'right-sidebar' );
			} elseif ( wpsp_is_woo_tax() && ( wpsp_get_redux('woo-shop-layout') !='inherit' ) ) {
				$class = wpsp_get_redux( 'woo-shop-layout', 'right-sidebar' );
			} elseif ( wpsp_is_woo_single() && ( wpsp_get_redux('woo-product-layout') !='inherit' ) ) {
				$class = wpsp_get_redux( 'woo-product-layout', 'right-sidebar' );
			}
			return $class;
		}

		/**
		 * Returns correct title for WooCommerce pages.
		 *
		 * @since 1.0.0
		 */
		public static function title_config( $title ) {

			// Shop title
			if ( is_shop() ) {
				$title = get_the_title( wc_get_page_id( 'shop' ) );
				$title = $title ? $title : $title = esc_html__( 'Shop', 'newstore' );
			}

			// Product title
			elseif ( is_product() ) {
				$title = wpsp_get_translated_theme_mod( 'woo_shop_single_title' );
				$title = $title ? $title : esc_html__( 'Shop', 'newstore' );
			}

			// Checkout
			elseif ( is_order_received_page() ) {
				$title = esc_html__( 'Order Received', 'newstore' );
			}

			// Return title
			return $title;

		}

		/**
		 * Hooks into the wpsp_display_page_header and returns false if page header is disabled via the customizer.
		 *
		 * @since 1.0.0
		 */
		public static function display_page_header( $return ) {
			if ( is_shop() && ! wpsp_get_redux( 'is-woo-shop-title', true ) ) {
				$return = false;
			}
			return $return;
		}

		/**
		 * Alters subheading for the shop.
		 *
		 * @since 1.0.0
		 */
		public static function alter_subheadings( $subheading ) {

			// Woo Taxonomies
			if ( wpsp_is_woo_tax() ) {
				if ( 'under_title' == wpsp_get_redux( 'woo-category-description-position', 'under_title' ) ) {
					$subheading = term_description();
				} else {
					$subheading = NULL;
				}
			}

			// Orderby, search...etc
			if ( is_shop() ) {
				if ( ! empty( $_GET['s'] ) ) {
					$subheading = esc_html__( 'Search results for:', 'newstore' ) .' <span>&quot;'. $_GET['s'] .'&quot;</span>';
				}
			}

			// Return subheading
			return $subheading;

		}

		/**
		 * Alters subheading for the shop.
		 *
		 * @since 1.0.0
		 */
		public static function term_description_above_loop( $return ) {

			// Check if enabled
			if ( wpsp_is_woo_tax() && 'above_loop' == wpsp_get_redux( 'woo-category-description-position' ) ) {
				$return = true;
			}

			// Return bool
			return $return;

		}

		/**
		 * Enable post social share if enabled.
		 *
		 * @since 1.0.0
		 */
		public static function post_social_share( $return ) {
			if ( is_singular( 'product' ) ) {
				$return = true;
			}
			return $return;
		}

		/**
		 * Disables the next/previous links if disabled via the customizer.
		 *
		 * @since 1.0.0
		 */
		public static function next_prev( $return ) {
			if ( is_singular( 'product' ) && wpsp_get_redux( 'is-woo-next-prev', true ) ) {
				$return = true;
			}
			return $return;
		}

		/**
		 * Remove WooCommerce styles not needed for this theme.
		 *
		 * @since 1.0.0
		 * @link  http://docs.woothemes.com/document/disable-the-default-stylesheet/
		 */
		public static function remove_styles( $enqueue_styles ) {
			unset( $enqueue_styles['woocommerce-layout'] );
			unset( $enqueue_styles['woocommerce_prettyPhoto_css'] );
			return $enqueue_styles;
		}

		/**
		 * Remove WooCommerce scripts.
		 *
		 *
		 * @since 1.0.0
		 */
		public static function remove_scripts() {
			wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
			wp_dequeue_script( 'prettyPhoto' );
			wp_dequeue_script( 'prettyPhoto-init' );
		}

		/**
		 * Add Custom WooCommerce CSS.
		 *
		 * @since 1.0.0
		 */
		public static function add_custom_css() {

			// General WooCommerce Custom CSS
			wp_enqueue_style( 'wpsp-woocommerce', get_template_directory_uri() .'/css/woocommerce.css' );

		}

		/**
		 * Adds an opening div "product-inner" around product entries.
		 *
		 * @since 1.0.0
		 */
		public static function add_shop_loop_item_inner_div() {
			echo '<div class="product-inner clearfix">';
		}

		/**
		 * Closes the "product-inner" div around product entries.
		 *
		 * @since 1.0.0
		 */
		public static function close_shop_loop_item_inner_div() {
			echo '</div><!-- .product-inner .clear -->';
		}

		/**
		 * Clear floats after single product summary.
		 *
		 * @since 1.0.0
		 */
		public static function clear_summary_floats() {
			echo '<div class="clearfix"></div>';
		}

		/**
		 * Adds an out of stock tag to the products.
		 *
		 * @since 2.0.0
		 */
		public static function add_shop_loop_item_out_of_stock_badge() {
			if ( function_exists( 'wpsp_woo_product_instock' ) && ! wpsp_woo_product_instock() ) { ?>
				<div class="outofstock-badge">
					<?php echo apply_filters( 'wpsp_woo_outofstock_text', esc_html__( 'Out of Stock', 'newstore' ) ); ?>
				</div><!-- .product-entry-out-of-stock-badge -->
			<?php }
		}

		/**
		 * Add WooCommerce cart dropdown to the header
		 *
		 * @since 1.0.0
		 */
		public static function cart_dropdown() {

			// Return if style not set to dropdown
			if ( 'drop_down' != menu_cart_style() ) {
				return;
			}

			// Should we get the template part?
			$get = false;

			// Get current header style
			$header_style = wpsp_get_redux( 'header-style' );

			// Header Inner Hook
			if ( 'wpsp_hook_header_inner' == current_filter() ) {
				if ( 'one' == $header_style ) {
					$get = true;
				}
			}
			
			// Menu bottom hook
			elseif ( 'wpsp_hook_main_menu_bottom' == current_filter() ) {
				if ( 'two' == $header_style
					|| 'three' == $header_style
					|| 'four' == $header_style
					|| 'five' == $header_style ) {
					$get = true;
				}
			}

			// Get template file
			if ( $get ) {
				get_template_part( 'partials/cart/cart-dropdown' );
			}

		}

		/**
		 * Adds Cart overlay code to footer
		 *
		 * @since 3.0.0
		 */
		public static function cart_overlay() {
			if ( 'overlay' == menu_cart_style() ) {
				get_template_part( 'partials/cart/cart-overlay' );
			}
		}
		
		/**
		 * Adds cart icon to menu
		 *
		 * @since 1.0.0
		 */
		public static function menu_cart_icon( $items, $args ) {

			// Only used for the main menu
			if ( 'main_menu' != $args->theme_location ) {
				return $items;
			}

			// Get style
			$style = menu_cart_style();

			// Return items if no style
			if ( ! $style ) {
				return $items;
			}

			// Toggle class
			$toggle_class = 'toggle-cart-widget';

			// Define classes to add to li element
			$classes = array( 'woo-menu-icon', 'wpsp-menu-extra' );
			
			// Add style class
			$classes[] = 'wcmenucart-toggle-'. $style;

			// Prevent clicking on cart and checkout
			if ( 'custom-link' != $style && ( is_cart() || is_checkout() ) ) {
				$classes[] = 'nav-no-click';
			}

			// Add toggle class
			else {
				$classes[] = $toggle_class;
			}

			// Turn classes into string
			$classes = implode( ' ', $classes );
			
			// Add cart link to menu items
			$items .= '<li class="'. $classes .'">' . wpsp_wcmenucart_menu_item() .'</li>';
			
			// Return menu items
			return $items;
		}

		/**
		 * Add menu cart item to the Woo fragments so it updates with AJAX
		 *
		 * @since 1.0.0
		 */
		public static function menu_cart_icon_fragments( $fragments ) {
			$fragments['.wcmenucart'] = wpsp_wcmenucart_menu_item();
			return $fragments;
		}

		/**
		 * Remove general settings from Woo Admin panel.
		 *
		 * @since 1.0.0
		 */
		public static function remove_general_settings( $settings ) {
			$remove = array( 'woocommerce_enable_lightbox' );
			foreach( $settings as $key => $val ) {
				if ( isset( $val['id'] ) && in_array( $val['id'], $remove ) ) {
					unset( $settings[$key] );
				}
			}
			return $settings;
		}

		/**
		 * Remove product settings from Woo Admin panel.
		 *
		 * @since 1.0.0
		 */
		public static function remove_product_settings( $settings ) {
			$remove = array(
				'image_options',
				'shop_catalog_image_size',
				'shop_single_image_size',
				'shop_thumbnail_image_size',
				'woocommerce_enable_lightbox'
			);
			foreach( $settings as $key => $val ) {
				if ( isset( $val['id'] ) && in_array( $val['id'], $remove ) ) {
					unset( $settings[$key] );
				}
			}
			return $settings;
		}

		/**
		 * Change onsale text.
		 *
		 * @since 1.0.0
		 */
		public static function woocommerce_sale_flash( $text, $post, $_product ) {
			return '<span class="onsale">'. esc_html__( 'Sale', 'newstore' ) .'</span>';
		}

		/**
		 * Returns correct posts per page for the shop
		 *
		 * @since 1.0.0
		 */
		public static function loop_shop_per_page() {
			$posts_per_page = wpsp_get_redux( 'woo-shop-posts-per-page', 12 );
			$posts_per_page = $posts_per_page ? $posts_per_page : '12';
			return $posts_per_page;
		}

		/**
		 * Change products per row for the main shop.
		 *
		 * @since 1.0.0
		 */
		public static function loop_shop_columns() {
			$columns = wpsp_get_redux( 'woocommerce-shop-columns', 3 );
			$columns = $columns ? $columns : '3';
			return $columns;
		}

		/**
		 * Add classes to WooCommerce product entries.
		 *
		 * @since 1.0.0
		 */
		public static function add_product_entry_classes( $classes ) {
			global $product, $woocommerce_loop;
			if ( $product && $woocommerce_loop ) {
				$classes[] = 'col';
				if (!isset($woocommerce_loop['columns']) || !$woocommerce_loop['columns']) {
					$woocommerce_loop['columns'] = apply_filters('loop_shop_columns', wpsp_get_redux( 'woocommerce-shop-columns', 3 ) );
					$classes[] = bootstrap_grid_class( $woocommerce_loop['columns'] );
				}
				$classes[] = bootstrap_grid_class( $woocommerce_loop['columns'] );
			}
			return $classes;
		}

		/**
		 * Alter WooCommerce category classes
		 *
		 * @since 1.0.0
		 */
		public static function product_cat_class( $classes ) {
			global $woocommerce_loop;
			$classes[] = 'col';
			$classes[] = bootstrap_grid_class( $woocommerce_loop['columns'] );
			return $classes;
		}

		/**
		 * Alter the cart item thumbnail size
		 *
		 * @since 1.0.0
		 */
		public static function cart_item_thumbnail( $thumb, $cart_item, $cart_item_key ) {
			if ( ! empty( $cart_item['variation_id'] )
				&& $thumbnail = get_post_thumbnail_id( $cart_item['variation_id'] )
			) {
				return wpsp_get_post_thumbnail( array(
					'size'       => 'shop_thumbnail',
					'attachment' => $thumbnail,
				) );
			} elseif ( isset( $cart_item['product_id'] )
				&& $thumbnail = get_post_thumbnail_id( $cart_item['product_id'] )
			) {
				return wpsp_get_post_thumbnail( array(
					'size'       => 'shop_thumbnail',
					'attachment' => $thumbnail,
				) );
			} else {
				return wc_placeholder_img();
			}
		}

		/**
		 * Alter the related product arguments.
		 *
		 * @since 1.0.0
		 */
		public static function related_product_args() {
			// Get global vars
			global $product, $orderby, $related;
			// Get posts per page
			$posts_per_page = wpsp_get_redux( 'woocommerce-related-count', 3 );
			$posts_per_page = $posts_per_page ? $posts_per_page : '3';
			// Get columns
			$columns = wpsp_get_redux( 'woocommerce-related-columns', 3 );
			$columns = $columns ? $columns : '3';
			// Return array
			return array(
				'posts_per_page' => $posts_per_page,
				'columns'        => $columns,
			);
		}

		/**
		 * Tweaks pagination arguments.
		 *
		 * @since 1.0.0
		 */
		public static function pagination_args( $args ) {
			$args['prev_text'] = '<i class="fa fa-angle-left"></i>';
			$args['next_text'] = '<i class="fa fa-angle-right"></i>';
			return $args;
		}

		/**
		 * Alter continue shoping URL.
		 *
		 * @since 1.0.0
		 */
		public static function continue_shopping_redirect( $return_to ) {
			$shop_id = woocommerce_get_page_id( 'shop' );
			if ( function_exists( 'icl_object_id' ) ) {
				$shop_id = icl_object_id( $shop_id, 'page' );
			}
			if ( $shop_id ) {
				$return_to = get_permalink( $shop_id );
			}
			return $return_to;
		}

	}

}

$wpsp_woocommerce_config = new WPSP_WooCommerce_Config();