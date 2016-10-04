<?php
/**
 * WooCommerce helper functions
 * This functions only load if WooCommerce is enabled because
 * they should be used within Woo loops only.
 *
 * @package newstore
 * @subpackage WooCommerce
 * @version 1.0.0
 */


/*-------------------------------------------------------------------------------*/
/* [ Condition ]
/*-------------------------------------------------------------------------------*/

/**
 * Checks if on the WooCommerce shop page.
 *
 * @since 1.0.0
 */
function wpsp_is_woo_shop() {
	if ( ! class_exists( 'woocommerce' ) ) {
		return false;
	} elseif ( function_exists( 'is_shop' ) && is_shop() ) {
		return true;
	}
}

/**
 * Checks if on a WooCommerce tax.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_is_woo_tax' ) ) {
	function wpsp_is_woo_tax() {
		if ( ! class_exists( 'woocommerce' ) ) {
			return false;
		} elseif ( ! is_tax() ) {
			return false;
		} elseif ( function_exists( 'is_product_category' ) && function_exists( 'is_product_tag' ) ) {
			if ( is_product_category() || is_product_tag() ) {
				return true;
			}
		}
	}
}

/**
 * Checks if on singular WooCommerce product post.
 *
 * @since 1.0.0
 */
function wpsp_is_woo_single() {
	if ( ! class_exists( 'woocommerce' ) ) {
		return false;
	} elseif ( is_woocommerce() && is_singular( 'product' ) ) {
		return true;
	}
}

/*-------------------------------------------------------------------------------*/
/* [ General ]
/*-------------------------------------------------------------------------------*/

/**
 * Creates the WooCommerce link for the navbar
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'wpsp_wcmenucart_menu_item' ) ) {
	function wpsp_wcmenucart_menu_item() {
		
		// Vars
		global $woocommerce;
		$icon_style   = wpsp_get_redux( 'woo-menu-icon-style', 'drop_down' );
		$custom_link  = wpsp_get_redux( 'woo-menu-icon-custom-link' );
		$header_style = wpsp_get_redux( 'header-style' );

		// URL
		if ( 'custom-link' == $icon_style && $custom_link ) {
			$url = esc_url( $custom_link );
		} else {
			$cart_id = woocommerce_get_page_id( 'cart' );
			if ( function_exists( 'icl_object_id' ) ) {
				$cart_id = icl_object_id( $cart_id, 'page' );
			}
			$url = get_permalink( $cart_id );
		}
		
		// Cart total
		$display = wpsp_get_redux( 'woo-menu-icon-display', 'icon_count' );
		if ( 'icon_total' == $display ) {
			$cart_extra = WC()->cart->get_cart_total();
			$cart_extra = str_replace( 'amount', 'wcmenucart-details', $cart_extra );
		} elseif ( 'icon_count' == $display ) {
			$cart_extra = '<span class="wcmenucart-details count">'. WC()->cart->cart_contents_count .'</span>';
		} else {
			$cart_extra = '';
		}

		// Cart Icon
		$icon_class = wpsp_get_redux( 'woo-menu-icon-class' ); // shopping-cart, shopping-bag, shopping-basket
		$icon_class = $icon_class ? $icon_class : 'shopping-cart';
		$cart_icon = '<span class="wcmenucart-icon fa fa-'. esc_attr( $icon_class ) .'"></span><span class="wcmenucart-text">'. esc_html__( 'Shop', 'newstore' ) .'</span>';
		$cart_icon = apply_filters( 'wpsp_menu_cart_icon_html', $cart_icon );

		ob_start(); ?>

			<a href="<?php echo esc_url( $url ); ?>" class="wcmenucart" title="<?php esc_html_e( 'Your Cart', 'newstore' ); ?>">
				<span class="link-inner">
					<span class="wcmenucart-count"><?php echo $cart_icon; ?><?php echo $cart_extra; ?></span>
				</span>
			</a>
			
		<?php
		return ob_get_clean();
	}
}

/**
 * Returns header search style
 *
 * @since 1.0.0
 */
function menu_cart_style() {

	// Return if WooCommerce isn't enabled or icon is disabled
	if ( ! class_exists( 'woocommerce' ) || 'disabled' == wpsp_get_redux( 'woo-menu-icon-display', 'icon_count' ) ) {
		return false;
	}

	// Get Menu Icon Style
	$style = wpsp_get_redux( 'woo-menu-icon-style', 'drop_down' );

	// Overlay header should use pop-up
	if ( wpsp_get_redux( 'enable-header' ) && 'six' == wpsp_get_redux( 'header-style' ) ) {
		$style = 'overlay';
	}

	// Return click style for these pages
	if ( is_cart() || is_checkout() ) {
		$style = 'custom-link';
	}

	// Apply filters for advanced edits
	$style = apply_filters( 'wpsp_menu_cart_style', $style );

	// Sanitize output so it's not empty
	if ( 'drop_down' == $style || ! $style ) {
		$style = 'drop_down';
	}

	// Return style
	return $style;

}

/**
 * Outputs placeholder image
 *
 * @since 1.0.0
 */
function wpsp_woo_placeholder_img() {
	if ( function_exists( 'wc_placeholder_img_src' ) && wc_placeholder_img_src() ) {
		$placeholder = '<img src="'. wc_placeholder_img_src() .'" alt="'. esc_attr__( 'Placeholder Image', 'newstore' ) .'" class="woo-entry-image-main" />';
		$placeholder = apply_filters( 'wpsp_woo_placeholder_img_html', $placeholder );
		if ( $placeholder ) {
			echo $placeholder;
		}
	}
}

/**
 * Check if product is in stock
 *
 * @since 1.0.0
 */
function wpsp_woo_product_instock( $post_id = '' ) {
	global $post;
	$post_id      = $post_id ? $post_id : $post->ID;
	$stock_status = get_post_meta( $post_id, '_stock_status', true );
	if ( 'instock' == $stock_status ) {
		return true;
	} else {
		return false;
	}
}