<?php
/**
 * WooCommerce options
 * Setup wooCommerce options with reduxframework
 *
 * @package newstore
 * @subpackage WooCommerce
 * @version 1.0.0
 */

if ( ! class_exists( 'Redux' ) ) {
    return;
}

$opt_name = "redux_wpsp";

Redux::setSection( $opt_name, array(
    'title'            => __( 'WooCommerce', 'wpsp-redux-framework' ),
    'id'               => 'woocommcer-options',
    'desc'             => __( '', 'wpsp-redux-framework' ),
    'customizer_width' => '400px',
    'icon'             => 'el el-shopping-cart'
) );
// Woo > General
Redux::setSection( $opt_name, array(
    'title'      => __( 'General', 'wpsp-redux-framework' ),
    'id'         => 'woo-general-options',
    'subsection' => true,
    //'desc'       => __( 'Use for any post that do not have post featured image with landscape, portrait and square', 'wpsp-redux-framework' ),
    'fields'     => array(
    	array(
            'id'       => 'is-woo-custom-sidebar',
            'type'     => 'switch',
            'title'    => __( 'Enable/Disable WooCommerce sidebar', 'wpsp-redux-framework' ),
            'default'  => '1'// 1 = on | 0 = off
        ),
        array(
            'id'       => 'woo-menu-icon-display',
            'type'     => 'select',
            'title'    => __( 'Menu Cart: Display', 'wpsp-redux-framework' ),
            'options'  => array(
                'disabled' => 'Disabled',
                'icon' => 'Icon',
                'icon_total' => 'Icon And Cart Total',
                'icon_count' => 'Icon And Cart Count'
            ),
            'default'  => 'icon'
        ),
        array(
            'id'       => 'woo-menu-icon-class',
            'type'     => 'select',
            'title'    => __( 'Menu Cart: Icon', 'wpsp-redux-framework' ),
            'options'  => array(
                'shopping-cart' => 'Shopping Cart',
                'shopping-bag' => 'Shopping Bag',
                'shopping-basket' => 'Shopping Basket'
            ),
            'default'  => 'shopping-cart'
        ),
        array(
            'id'       => 'woo-menu-icon-style',
            'type'     => 'select',
            'title'    => __( 'Menu Cart: Style', 'wpsp-redux-framework' ),
            'options'  => array(
                'dropdown' => 'Dropdown',
                'overlay' => 'Open Cart Overlay',
                'store' => 'Go To Store',
                'custom-link' => 'Custom link'
            ),
            'default'  => 'dropdown'
        ),
        array(
            'id'       => 'woo-menu-icon-custom-link',
            'type'     => 'text',
            'title'    => __( 'Menu Cart: Custom Link', 'wpsp-redux-framework' ),
        ),
	)
) );
// Woo > Archive (shop)
Redux::setSection( $opt_name, array(
    'title'      => __( 'Archive', 'wpsp-redux-framework' ),
    'id'         => 'woo-shop-options',
    'subsection' => true,
    //'desc'       => __( 'Use for any post that do not have post featured image with landscape, portrait and square', 'wpsp-redux-framework' ),
    'fields'     => array(
    	array(
            'id'       => 'is-woo-shop-title',
            'type'     => 'switch',
            'title'    => __( 'Enable/Disable Shop Title', 'wpsp-redux-framework' ),
            'default'  => '1'// 1 = on | 0 = off
        ),
        array(
            'id'       => 'woo-shop-posts-per-page',
            'type'     => 'text',
            'title'    => __( 'Shop posts per page', 'wpsp-redux-framework' ),
            'default'  => '12'
        ),
        array(
            'id'       => 'woo-shop-layout',
            'type'     => 'image_select',
            'title'    => __( 'Shop layout', 'wpsp-redux-framework' ),
            'subtitle' => __( 'Layout for archive page', 'wpsp-redux-framework' ),
            'desc'     => __( 'Shop, Category, archive layout', 'wpsp-redux-framework' ),
            'options'  => array(
                'inherit' => array(
                    'alt' => 'Inherit',
                    'img' => get_template_directory_uri() . '/images/admin/layout-off.png'
                ),
                'full-width' => array(
                    'alt' => 'Full width',
                    'img' => get_template_directory_uri() . '/images/admin/full-width.png'
                ),
                'full-screen' => array(
                    'alt' => 'Full screen',
                    'img' => get_template_directory_uri() . '/images/admin/full-screen.png'
                ),
                'left-sidebar' => array(
                    'alt' => '2 Column Left',
                    'img' => get_template_directory_uri() . '/images/admin/2cl.png'
                ),
                'right-sidebar' => array(
                    'alt' => '2 Column Right',
                    'img' => get_template_directory_uri() . '/images/admin/2cr.png'
                )
            ),
            'default'  => 'inherit',
        ),
        array(
            'id'       => 'woocommerce-shop-columns',
            'type'     => 'select',
            'title'    => __( 'Shop column', 'wpsp-redux-framework' ),
            'options'  => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7'
            ),
            'default'  => '4'
        ),
        array(
            'id'       => 'woo-category-description-position',
            'type'     => 'select',
            'title'    => __( 'Category Description Position', 'wpsp-redux-framework' ),
            'options'  => array(
                'under_title' => 'Under title',
                'above_loop' => 'Above loop'
            ),
            'default'  => 'under_title'
        ),
        array(
            'id'       => 'woo-product-entry-style',
            'type'     => 'select',
            'title'    => __( 'Product Entry Media', 'wpsp-redux-framework' ),
            'options'  => array(
                'featured-image' => 'Featured image',
                'image-swap' => 'Image swape',
                'gallery-slider' => 'Gallery slider'
            ),
            'default'  => 'featured-image'
        ),
	)
) );

// Woo > Single
Redux::setSection( $opt_name, array(
    'title'      => __( 'Single', 'wpsp-redux-framework' ),
    'id'         => 'woo-single-options',
    'subsection' => true,
    //'desc'       => __( 'Use for any post that do not have post featured image with landscape, portrait and square', 'wpsp-redux-framework' ),
    'fields'     => array(
    	array(
            'id'       => 'woo-shop-single-title',
            'type'     => 'text',
            'title'    => __( 'Page Header Title', 'wpsp-redux-framework' ),
            'default'  => 'Store'
        ),
        array(
            'id'       => 'woo-product-layout',
            'type'     => 'image_select',
            'title'    => __( 'Product layout', 'wpsp-redux-framework' ),
            'subtitle' => __( 'Layout for archive page', 'wpsp-redux-framework' ),
            'desc'     => __( 'Single product layout', 'wpsp-redux-framework' ),
            'options'  => array(
                'inherit' => array(
                    'alt' => 'Inherit',
                    'img' => get_template_directory_uri() . '/images/admin/layout-off.png'
                ),
                'full-width' => array(
                    'alt' => 'Full width',
                    'img' => get_template_directory_uri() . '/images/admin/full-width.png'
                ),
                'full-screen' => array(
                    'alt' => 'Full screen',
                    'img' => get_template_directory_uri() . '/images/admin/full-screen.png'
                ),
                'left-sidebar' => array(
                    'alt' => '2 Column Left',
                    'img' => get_template_directory_uri() . '/images/admin/2cl.png'
                ),
                'right-sidebar' => array(
                    'alt' => '2 Column Right',
                    'img' => get_template_directory_uri() . '/images/admin/2cr.png'
                )
            ),
            'default'  => 'inherit',
        ),
        array(
            'id'       => 'woocommerce-upsells-count',
            'type'     => 'text',
            'title'    => __( 'Up-Sells Count', 'wpsp-redux-framework' ),
            'default'  => '4'
        ),
        array(
            'id'       => 'woocommerce-upsells-columns',
            'type'     => 'select',
            'title'    => __( 'Up-Sells Columns', 'wpsp-redux-framework' ),
            'options'  => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7'
            ),
            'default'  => '4'
        ),
        array(
            'id'       => 'woocommerce-related-count',
            'type'     => 'text',
            'title'    => __( 'Related Items Count', 'wpsp-redux-framework' ),
            'default'  => '4'
        ),
        array(
            'id'       => 'woocommerce-related-columns',
            'type'     => 'select',
            'title'    => __( 'Related Products Columns', 'wpsp-redux-framework' ),
            'options'  => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7'
            ),
            'default'  => '4'
        ),
        array(
            'id'       => 'is-woo-product-meta',
            'type'     => 'switch',
            'title'    => __( 'Product meta', 'wpsp-redux-framework' ),
            'default'  => '1'// 1 = on | 0 = off
        ),
        array(
            'id'       => 'is-woo-next-prev',
            'type'     => 'switch',
            'title'    => __( 'Next & Previous Links', 'wpsp-redux-framework' ),
            'default'  => '1'// 1 = on | 0 = off
        ),
	)
) );

// Woo > Cart
Redux::setSection( $opt_name, array(
    'title'      => __( 'Cart', 'wpsp-redux-framework' ),
    'id'         => 'woo-cart-options',
    'subsection' => true,
    //'desc'       => __( 'Use for any post that do not have post featured image with landscape, portrait and square', 'wpsp-redux-framework' ),
    'fields'     => array(
    	array(
            'id'       => 'woocommerce-cross-sells-count',
            'type'     => 'text',
            'title'    => __( 'Cross-Sells Count', 'wpsp-redux-framework' ),
            'default'  => '2'
        ),
        array(
            'id'       => 'woocommerce-cross-sells-columns',
            'type'     => 'select',
            'title'    => __( 'Cross-Sells Columns', 'wpsp-redux-framework' ),
            'options'  => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7'
            ),
            'default'  => '2'
        ),
 	)
) );

// Woo > Single
Redux::setSection( $opt_name, array(
    'title'      => __( 'Single', 'wpsp-redux-framework' ),
    'id'         => 'woo-single-options',
    'subsection' => true,
    //'desc'       => __( 'Use for any post that do not have post featured image with landscape, portrait and square', 'wpsp-redux-framework' ),
    'fields'     => array(
    	
	)
) );