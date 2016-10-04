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