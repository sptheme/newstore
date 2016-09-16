<?php
/**
 * Footer bottom content
 *
 * @package newstore
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get copyright info
$copyright = wpsp_get_redux( 'footer-copyright-text', 'Copyright <a href="#">Your Business LLC.</a> - All Rights Reserved' );

// WPML translations
$copyright = wpsp_translate_theme_mod( 'footer-copyright-text', $copyright ); ?>

<div id="footer-bottom" class="clearfix"<?php wpsp_schema_markup( 'footer_bottom' ); ?>>

	<div id="footer-bottom-inner" class="container">

		<?php
		// Display copyright info
		if ( $copyright ) : ?>

			<div id="copyright" class="clearfix" role="contentinfo">
				<?php echo do_shortcode( $copyright ); ?>
			</div><!-- #copyright -->

		<?php endif; ?>

		<?php
		// Get footer menu location and apply filters for child theming
		$menu_location = 'footer_menu';
		$menu_location = apply_filters( 'wpsp_footer_menu_location', $menu_location);

		// Display footer bottom menu if location is defined
		if ( has_nav_menu( $menu_location ) ) : ?>

			<div id="footer-bottom-menu" class="clearfix">
				<?php
				// Display footer menu
				wp_nav_menu( array(
					'theme_location' => $menu_location,
					'sort_column'    => 'menu_order',
					'fallback_cb'    => false,
				) ); ?>

			</div><!-- #footer-bottom-menu -->

		<?php endif; ?>

	</div><!-- #footer-bottom-inner -->

</div><!-- #footer-bottom -->