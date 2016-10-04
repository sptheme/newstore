<?php
/**
 * Term descriptions
 *
 * @package newstore
 */

// Display term description if there is one
if ( $term_description = term_description() ) : ?>

	<div class="term-description clearfix">
	    <?php echo term_description(); ?>
	</div><!-- #term-description -->

<?php endif; ?>