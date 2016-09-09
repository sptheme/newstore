<?php
 /**
 * Mobile Icons Header Menu.
 *
 * @package newstore
 */  
 ?>

<div id="mobile-menu" class="hidden-lg-up">
	<?php
	// Toggle only needed if main menu is defined
	$menu_location  = apply_filters( 'wpsp_main_menu_location', 'primary' );
	if ( has_nav_menu( $menu_location ) ) : ?>
		<a href="#" class="mobile-menu-toggle"><?php echo apply_filters( 'wpsp_mobile_menu_open_button_text', '<span class="fa fa-navicon"></span>' ); ?></a>
	<?php endif; ?>
	<?php
	// Output icons if the mobile_menu region has a menu defined
	if ( has_nav_menu( 'mobile_menu' ) ) {
		if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ 'mobile_menu' ] ) ) {
			$menu = wp_get_nav_menu_object( $locations[ 'mobile_menu' ] );
			if ( ! empty( $menu ) ) {
				$menu_items = wp_get_nav_menu_items( $menu->term_id );
				foreach ( $menu_items as $key => $menu_item ) {
					if ( in_array( $menu_item->title, wpsp_get_awesome_icons() ) ) {
						$url = $menu_item->url;
						$attr_title = $menu_item->attr_title; ?>
						<a href="<?php echo esc_url( $url ); ?>" title="<?php echo esc_attr( $attr_title ); ?>" class="mobile-menu-extra-icons mobile-menu-<?php echo esc_attr( $menu_item->title ); ?>">
							<span class="fa fa-<?php echo esc_attr( $menu_item->title ); ?>"></span>
						</a>
				<?php }
				}
			}
		}
	} ?>
</div><!-- #mobile-menu -->