<?php
/**
 * The Scroll-Top Button
 *
 * @package newstore
 */

// Get arrow
$arrow = wpsp_get_redux( 'scroll-top-arrow' );
$arrow = $arrow ? $arrow : 'chevron-up'; ?>

<a href="#" id="site-scroll-top"><span class="fa fa-<?php echo esc_attr( $arrow ); ?>"></span></a>