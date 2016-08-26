<?php
/**
 * The page header displays at the top of all single pages, posts and archives.
 *
 * @see inc/page-header.php for all functions attached to the header hooks.
 * @see inc/hooks/actions.php for all functions attached to the header hooks.
 *
 * @package newstore
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<header class="<?php echo wpsp_page_header_classes(); ?>">

	<?php wpsp_hook_page_header_top(); ?>

	<div class="page-header-inner container clear">

		<?php wpsp_hook_page_header_inner(); // All default content added via this hook ?>

	</div><!-- .page-header-inner -->

	<?php wpsp_hook_page_header_bottom(); ?>

</header><!-- .page-header -->