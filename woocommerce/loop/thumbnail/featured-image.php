<?php
/**
 * Image Swap style thumbnail
 *
 * @package newstore
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Return placeholder if there isn't a thumbnail defined.
if ( ! has_post_thumbnail() ) {
    wpsp_woo_placeholder_img();
    return;
}

// Get featured image
$attachment = get_post_thumbnail_id();

// Display featured image if defined
if ( $attachment ) {

    wpsp_post_thumbnail( array(
        'attachment' => $attachment,
        'size'       => 'shop_catalog',
        'alt'        => wpsp_get_esc_title(),
        'class'      => 'woo-entry-image-main image-border',
    ) );

}

// Display placeholder
else {
    echo '<img src="'. wc_placeholder_img_src() .'" alt="'. esc_html__( 'Placeholder Image', 'smallshop' ) .'" class="woo-entry-image-main" />';
} ?>