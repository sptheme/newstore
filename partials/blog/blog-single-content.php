<?php
/**
 * Single blog post content
 *
 * @package newstore
 */

?>

<article class="entry"<?php wpsp_schema_markup( 'entry_content' ); ?>>
	<?php the_content(); ?>
</article><!-- .entry -->

<?php get_template_part( 'partials/next-prev' ); ?>