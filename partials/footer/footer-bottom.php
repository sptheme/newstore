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

<div class="footer-bottom"<?php wpsp_schema_markup( 'footer_bottom' ); ?>>

	<div class="footer-bottom-inner container">

		<?php
		// Get footer menu location and apply filters for child theming
		$menu_location = 'footer_menu';
		$menu_location = apply_filters( 'wpsp_footer_menu_location', $menu_location);

		// Display footer bottom menu if location is defined
		if ( has_nav_menu( $menu_location ) ) : ?>
		<div id="nav-footer" class="text-xs-center">
			<?php
			// Display footer menu
			wp_nav_menu( array(
				'menu_class' 	 => 'nav nav-inline',
				'container'		 => 'nav',
				'container_id'   => 'nav-footer',
				'fallback_cb'    => '',
				'theme_location' => $menu_location,
				'walker' => new wp_bootstrap_navwalker()
			) ); ?>
		</div> <!-- #nav-footer -->
		<?php endif; ?>

		<?php
		// Display copyright info
		if ( $copyright ) : ?>

			<div id="copyright" role="contentinfo" class="text-xs-center">
				<?php echo do_shortcode( $copyright ); ?>
			</div><!-- #copyright -->

		<?php endif; ?>

	</div><!-- .footer-bottom-inner -->

</div><!-- .footer-bottom -->