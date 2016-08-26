<?php
/**
 * Page subheading output
 *
 * @see inc/page-header.php for all functions attached to the header hooks.
 * @see inc/hooks/actions.php for all functions attached to the header hooks.
 *
 * @package newstore
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Display subheading if there is one
if ( $subheading = wpsp_get_page_subheading() ) : ?>

	<div class="page-subheading">
		<?php echo do_shortcode( $subheading ); ?>
	</div><!-- .page-subheading -->

<?php endif; ?>