<?php
/**
 * Header menu template part.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package newstore
 */

// Menu Location
$menu_location = apply_filters( 'wpsp_main_menu_location', 'primary' );

// Display menu if defined
if ( has_nav_menu( $menu_location ) ) : 

	// Get classes for the header menu
	$wrap_classes  = wpsp_header_menu_classes( 'wrapper' );
	$inner_classes = wpsp_header_menu_classes( 'inner' );

	// Menu arguments
	$menu_args = array(
		'theme_location' => $menu_location,
		'menu_class'     => 'wpsp-dropdown-menu sf-menu',
		'container'      => false,
		'fallback_cb'    => false,
		'link_before'    => '<span class="link-inner">',
		'link_after'     => '</span>',
		'walker'         => new WPSP_Dropdown_Walker_Nav_Menu(),
	); ?>

	<?php wpsp_hook_main_menu_before(); ?>

	<div id="site-navigation-wrap" class="hidden-md-down <?php echo $wrap_classes; ?>">

		<nav id="site-navigation" class="main-navigation <?php echo $inner_classes; ?>"<?php wpsp_schema_markup( 'site_navigation' ); ?> role="navigation">

			<?php wpsp_hook_main_menu_top(); ?>

				<?php wp_nav_menu( $menu_args ); ?>

			<?php wpsp_hook_main_menu_bottom(); ?>

		</nav><!-- #site-navigation -->

	</div><!-- #site-navigation-wrap -->

	<?php wpsp_hook_main_menu_after(); ?>

<?php endif; ?>