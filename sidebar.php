<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package newstore
 */
	
$choice_sidebar = wpsp_sidebar_primary(); 

if ( ! is_active_sidebar( $choice_sidebar ) || in_array( wpsp_post_layout(), array( 'full-screen', 'full-width' ) ) ) {
	return;
} ?>

<div id="secondary" class="col-md-4 widget-area" role="complementary">
	<?php dynamic_sidebar( $choice_sidebar ); ?>
</div><!-- #secondary -->
