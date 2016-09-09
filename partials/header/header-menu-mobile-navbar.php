<?php
/**
 * Navbar Style Mobile Menu Toggle
 *
 * @package newstore
 */

// Menu Location
$menu_location = apply_filters( 'wpsp_main_menu_location', 'primary' );

// Display if menu is defined
if ( has_nav_menu( $menu_location ) ) :

	// Get menu icon
	$icon = apply_filters( 'wpsp_mobile_menu_navbar_open_icon', '<span class="fa fa-navicon"></span>' );

	// Get menu text
	$text = wpsp_get_redux( 'mobile-menu-toggle-text', esc_html__( 'Menu', 'newstore' ) );
	$text = $text ? $text : esc_html__( 'Menu', 'newstore' );
	$text = apply_filters( 'wpsp_mobile_menu_navbar_open_text', $text ); ?>

	<?php
	// Closing toggle for the sidr mobile menu style
	if ( 'sidr' == mobile_menu_style() ) : ?>

		<div id="sidr-close"><a href="#sidr-close" class="toggle-sidr-close"></a></div>

	<?php endif; ?>

	<div id="wpsp-mobile-menu-navbar" class="hidden-lg-up">
		<div class="container">
			<a href="#mobile-menu" class="mobile-menu-toggle" title="<?php echo $text; ?>"><?php echo $icon; ?><span class="wpsp-text"><?php echo $text; ?></span></a>
		</div><!-- .container -->
	</div><!-- #wpex-mobile-menu-navbar -->

<?php endif; ?>