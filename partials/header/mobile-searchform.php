<?php
/**
 * Searchform for the mobile sidebar menu
 *
 * @package newstore
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div id="mobile-menu-search" class="clearfix wpsp-hidden">
	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search" class="mobile-menu-searchform">
		<div class="input-group">
			<input type="search" class="field form-control" name="s" id="s" placeholder="<?php esc_attr_e( 'Search &hellip;', 'newstore' ); ?>" />
			<?php if ( defined( 'ICL_LANGUAGE_CODE' ) ) { ?>
				<input type="hidden" name="lang" value="<?php echo( ICL_LANGUAGE_CODE ); ?>"/>
			<?php } ?>
			<span class="input-group-btn">
				<button type="submit" class="btn btn-primary">
				  <span class="fa fa-search"></span>
				</button>
			</span>
		</div>
	</form>
</div><!-- .mobile-menu-search -->